<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PublicController extends Controller
{
    /**
     * Hitung dan update denda otomatis untuk semua peminjaman aktif yang terlambat.
     * Dipanggil setiap visitor membuka halaman utama.
     */
    private function autoCalculateFines(int $userId): void
    {
        $today = Carbon::today();
        $finePerDay = 2000; // Rp 2.000 per hari

        // Ambil semua peminjaman yang sudah disetujui dan belum dikembalikan
        $activeBorrowings = Borrowing::where('user_id', $userId)
            ->where('status', 'approved')
            ->whereNull('return_date')
            ->get();

        foreach ($activeBorrowings as $borrowing) {
            $dueDate = Carbon::parse($borrowing->due_date);

            if ($today->gt($dueDate)) {
                // Hitung jumlah hari terlambat
                $daysLate = $today->diffInDays($dueDate);
                $calculatedFine = $daysLate * $finePerDay;

                // Update hanya jika denda bertambah (agar admin bisa manual edit dan tidak ter-override)
                if ($calculatedFine > ($borrowing->fine_amount ?? 0)) {
                    $borrowing->update(['fine_amount' => $calculatedFine]);
                }
            }
        }
    }

    public function index(Request $request)
    {
        $query = Book::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
        }

        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        $books = $query->paginate(12);

        // Get unique categories for the filter
        $categories = Book::select('category')->distinct()->whereNotNull('category')->pluck('category');

        // Hitung denda otomatis jika visitor login
        $overdueWarnings = collect();
        $recommendedBooks = collect();
        
        if (Auth::check()) {
            // Logika Rekomendasi Buku Hari Ini
            if (!session()->has('recommended_book_ids')) {
                $randomIds = Book::inRandomOrder()->limit(3)->pluck('id')->toArray();
                session()->put('recommended_book_ids', $randomIds);
            }

            $recommendedBookIds = session()->get('recommended_book_ids');
            $recommendedBooks = Book::whereIn('id', $recommendedBookIds)->get();

            // Validasi jika ada buku yang terhapus dari DB agar jumlahnya tetap sesuai
            $totalAvailable = Book::count();
            $expectedCount = min(3, $totalAvailable);
            if ($recommendedBooks->count() < $expectedCount) {
                $randomIds = Book::inRandomOrder()->limit(3)->pluck('id')->toArray();
                session()->put('recommended_book_ids', $randomIds);
                $recommendedBooks = Book::whereIn('id', $randomIds)->get();
            }

            // Hitung denda jika role visitor
            if (Auth::user()->role === 'visitor') {
                $this->autoCalculateFines(Auth::id());

                // Ambil peminjaman yang terlambat untuk peringatan popup
                $overdueWarnings = Borrowing::with('book')
                    ->where('user_id', Auth::id())
                    ->where('status', 'approved')
                    ->whereNull('return_date')
                    ->whereDate('due_date', '<', Carbon::today())
                    ->get()
                    ->map(function ($b) {
                        $daysLate = Carbon::today()->diffInDays(Carbon::parse($b->due_date));
                        return [
                            'title'     => $b->book?->title ?? 'Buku tidak diketahui',
                            'due_date'  => Carbon::parse($b->due_date)->format('d M Y'),
                            'days_late' => $daysLate,
                            'fine'      => $b->fine_amount ?? 0,
                        ];
                    });
            }
        }

        return view('welcome', compact('books', 'categories', 'overdueWarnings', 'recommendedBooks'));
    }

    public function show($id)
    {
        $book = Book::findOrFail($id);
        return view('show', compact('book'));
    }
}
