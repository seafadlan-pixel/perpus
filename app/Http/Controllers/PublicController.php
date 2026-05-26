<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class PublicController extends Controller
{
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

        return view('welcome', compact('books', 'categories'));
    }

    public function show($id)
    {
        $book = Book::findOrFail($id);
        return view('show', compact('book'));
    }
}
