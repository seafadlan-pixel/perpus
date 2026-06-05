<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminBorrowingController extends Controller
{
    /**
     * Tampilkan semua data peminjaman
     */
    public function index(Request $request)
    {
        $query = Borrowing::with(['user', 'book'])->orderBy('created_at', 'desc');

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $borrowings = $query->get();

        return view('admin.borrowings.index', compact('borrowings'));
    }

    /**
     * Approve peminjaman — stok buku berkurang
     */
    public function approve($id)
    {
        $borrowing = Borrowing::findOrFail($id);

        if ($borrowing->status !== 'pending') {
            return redirect()->route('admin.borrowings.index')
                ->with('error', 'Peminjaman ini sudah diproses sebelumnya.');
        }

        $book = Book::findOrFail($borrowing->book_id);

        if ($book->stock <= 0) {
            return redirect()->route('admin.borrowings.index')
                ->with('error', 'Stok buku habis, tidak bisa approve.');
        }

        $book->decrement('stock');
        $borrowing->update(['status' => 'approved']);

        return redirect()->route('admin.borrowings.index')
            ->with('success', 'Peminjaman berhasil di-approve. Stok buku dikurangi.');
    }

    /**
     * Reject peminjaman
     */
    public function reject($id)
    {
        $borrowing = Borrowing::findOrFail($id);

        if ($borrowing->status !== 'pending') {
            return redirect()->route('admin.borrowings.index')
                ->with('error', 'Peminjaman ini sudah diproses sebelumnya.');
        }

        $borrowing->update(['status' => 'rejected']);

        return redirect()->route('admin.borrowings.index')
            ->with('success', 'Peminjaman ditolak.');
    }

    /**
     * Tandai buku dikembalikan — stok buku bertambah
     */
    public function returnBook($id)
    {
        $borrowing = Borrowing::findOrFail($id);

        if ($borrowing->status !== 'approved') {
            return redirect()->route('admin.borrowings.index')
                ->with('error', 'Hanya peminjaman yang sudah di-approve yang bisa dikembalikan.');
        }

        $book = Book::findOrFail($borrowing->book_id);
        $book->increment('stock');

        $borrowing->update([
            'status' => 'returned',
            'return_date' => now(),
        ]);

        return redirect()->route('admin.borrowings.index')
            ->with('success', 'Buku berhasil dikembalikan. Stok buku ditambah.');
    }

    /**
     * Hapus data peminjaman
     */
    public function destroy($id)
    {
        $borrowing = Borrowing::findOrFail($id);

        // Jika status approved (belum dikembalikan), kembalikan stok
        if ($borrowing->status === 'approved') {
            $book = Book::findOrFail($borrowing->book_id);
            $book->increment('stock');
        }

        $borrowing->delete();

        return redirect()->route('admin.borrowings.index')
            ->with('success', 'Data peminjaman berhasil dihapus.');
    }

    /**
     * Perbarui jumlah denda peminjaman
     */
    public function updateFine(Request $request, $id)
    {
        $request->validate([
            'fine_amount' => 'required|integer|min:0',
        ]);

        $borrowing = Borrowing::findOrFail($id);
        $borrowing->update([
            'fine_amount' => $request->fine_amount,
        ]);

        return redirect()->back()
            ->with('success', 'Denda berhasil diperbarui.');
    }

    /**
     * Tampilkan form peminjaman langsung oleh admin
     * Berbeda dari visitor: admin memilih member & buku, langsung approved
     */
    public function createForAdmin()
    {
        $books = Book::where('stock', '>', 0)->orderBy('title')->get();
        $members = User::where('role', 'visitor')->orderBy('name')->get();
        $preselectedBookId = request('book_id');

        return view('admin.borrowings.create', compact('books', 'members', 'preselectedBookId'));
    }

    /**
     * Simpan peminjaman langsung oleh admin (status langsung approved, stok langsung berkurang)
     */
    public function storeForAdmin(Request $request)
    {
        $request->validate([
            'user_id'          => 'required|exists:users,id',
            'book_id'          => 'required|exists:books,id',
            'borrower_name'    => 'required|string|max:255',
            'borrower_phone'   => 'required|string|max:20',
            'borrower_address' => 'nullable|string',
            'borrow_date'      => 'required|date',
            'duration'         => 'required|integer|min:1|max:30',
            'notes'            => 'nullable|string',
        ]);

        $book = Book::findOrFail($request->book_id);

        if ($book->stock <= 0) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Stok buku sudah habis, tidak bisa dipinjam.');
        }

        $borrowDate = Carbon::parse($request->borrow_date);
        $dueDate    = $borrowDate->copy()->addDays((int) $request->duration);

        // Langsung approved — stok langsung dikurangi
        $book->decrement('stock');

        Borrowing::create([
            'user_id'          => $request->user_id,
            'book_id'          => $request->book_id,
            'borrower_name'    => $request->borrower_name,
            'borrower_phone'   => $request->borrower_phone,
            'borrower_address' => $request->borrower_address,
            'borrow_date'      => $borrowDate,
            'due_date'         => $dueDate,
            'status'           => 'approved',   // Langsung approved tanpa pending
            'notes'            => '[via:admin]' . ($request->notes ? ' ' . $request->notes : ''),
        ]);

        return redirect()->route('admin.borrowings.index', ['status' => 'approved'])
            ->with('success', 'Buku berhasil dipinjamkan. Stok dikurangi otomatis.');
    }
}
