<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Book;
use Illuminate\Http\Request;

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
}
