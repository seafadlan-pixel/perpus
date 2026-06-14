<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BorrowingController extends Controller
{
    /**
     * Hitung dan update denda otomatis untuk peminjaman terlambat.
     */
    private function autoCalculateFines(int $userId): void
    {
        $today = Carbon::today();
        $finePerDay = 2000; // Rp 2.000 per hari

        $activeBorrowings = Borrowing::where('user_id', $userId)
            ->where('status', 'approved')
            ->whereNull('return_date')
            ->get();

        foreach ($activeBorrowings as $borrowing) {
            $dueDate = Carbon::parse($borrowing->due_date);
            if ($today->gt($dueDate)) {
                $daysLate = $today->diffInDays($dueDate);
                $calculatedFine = $daysLate * $finePerDay;
                if ($calculatedFine > ($borrowing->fine_amount ?? 0)) {
                    $borrowing->update(['fine_amount' => $calculatedFine]);
                }
            }
        }
    }

    /**
     * Show form peminjaman buku
     */
    public function create($bookId)
    {
        if (Auth::user()->role === 'admin') {
            abort(403, 'Admin tidak diperbolehkan meminjam buku.');
        }

        $book = Book::findOrFail($bookId);

        if ($book->stock <= 0) {
            return redirect()->route('public.show', $book->id)
                ->with('error', 'Maaf, stok buku ini sedang habis.');
        }

        return view('borrow.create', compact('book'));
    }

    /**
     * Simpan peminjaman baru
     */
    public function store(Request $request)
    {
        if (Auth::user()->role === 'admin') {
            abort(403, 'Admin tidak diperbolehkan meminjam buku.');
        }

        $request->validate([
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
            return redirect()->route('public.show', $book->id)
                ->with('error', 'Maaf, stok buku ini sedang habis.');
        }

        $borrowDate = Carbon::parse($request->borrow_date);
        $dueDate = $borrowDate->copy()->addDays((int) $request->duration);

        Borrowing::create([
            'user_id'          => Auth::id(),
            'book_id'          => $request->book_id,
            'borrower_name'    => $request->borrower_name,
            'borrower_phone'   => $request->borrower_phone,
            'borrower_address' => $request->borrower_address,
            'borrow_date'      => $borrowDate,
            'due_date'         => $dueDate,
            'status'           => 'pending',
            'notes'            => $request->notes,
        ]);

        return redirect()->route('borrow.my')
            ->with('success', 'Peminjaman berhasil diajukan! Menunggu persetujuan admin.');
    }

    /**
     * Tampilkan daftar peminjaman user yang login
     */
    public function myBorrowings()
    {
        // Auto-hitung denda sebelum menampilkan data
        $this->autoCalculateFines(Auth::id());

        $borrowings = Borrowing::with('book')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        // Data buku yang terlambat untuk banner peringatan
        $overdueItems = $borrowings->filter(function ($b) {
            return $b->status === 'approved'
                && is_null($b->return_date)
                && Carbon::parse($b->due_date)->lt(Carbon::today());
        })->map(function ($b) {
            $daysLate = Carbon::today()->diffInDays(Carbon::parse($b->due_date));
            return [
                'title'     => $b->book?->title ?? 'Buku tidak diketahui',
                'due_date'  => Carbon::parse($b->due_date)->format('d M Y'),
                'days_late' => $daysLate,
                'fine'      => $b->fine_amount ?? 0,
            ];
        })->values();

        return view('borrow.my', compact('borrowings', 'overdueItems'));
    }
}
