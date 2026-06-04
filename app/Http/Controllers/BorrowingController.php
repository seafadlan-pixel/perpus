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
            'book_id' => 'required|exists:books,id',
            'borrower_name' => 'required|string|max:255',
            'borrower_phone' => 'required|string|max:20',
            'borrower_address' => 'nullable|string',
            'borrow_date' => 'required|date',
            'duration' => 'required|integer|min:1|max:30',
            'notes' => 'nullable|string',
        ]);

        $book = Book::findOrFail($request->book_id);

        if ($book->stock <= 0) {
            return redirect()->route('public.show', $book->id)
                ->with('error', 'Maaf, stok buku ini sedang habis.');
        }

        $borrowDate = Carbon::parse($request->borrow_date);
        $dueDate = $borrowDate->copy()->addDays((int) $request->duration);

        Borrowing::create([
            'user_id' => Auth::id(),
            'book_id' => $request->book_id,
            'borrower_name' => $request->borrower_name,
            'borrower_phone' => $request->borrower_phone,
            'borrower_address' => $request->borrower_address,
            'borrow_date' => $borrowDate,
            'due_date' => $dueDate,
            'status' => 'pending',
            'notes' => $request->notes,
        ]);

        return redirect()->route('borrow.my')
            ->with('success', 'Peminjaman berhasil diajukan! Menunggu persetujuan admin.');
    }

    /**
     * Tampilkan daftar peminjaman user yang login
     */
    public function myBorrowings()
    {
        $borrowings = Borrowing::with('book')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('borrow.my', compact('borrowings'));
    }
}
