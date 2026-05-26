<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::all();
        return view('books.index', compact('books'));
    }

    public function create()
    {
        return view('books.create');
    }

    public function store(Request $request)
    {
        Book::create([
            'title' => $request->title,
            'author' => $request->author,
            'publisher' => $request->publisher,
            'year' => $request->year,
            'stock' => $request->stock,
            'language' => $request->language,
            'isbn' => $request->isbn,
            'category' => $request->category,
            'synopsis' => $request->synopsis,
            'cover_image' => $request->cover_image,
        ]);

        return redirect('/admin/books')->with('success', 'Book created successfully.');
    }

    public function edit($id)
    {
        $book = Book::findOrFail($id);
        return view('books.edit', compact('book'));
    }

    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);
        
        $book->update([
            'title' => $request->title,
            'author' => $request->author,
            'publisher' => $request->publisher,
            'year' => $request->year,
            'stock' => $request->stock,
            'language' => $request->language,
            'isbn' => $request->isbn,
            'category' => $request->category,
            'synopsis' => $request->synopsis,
            'cover_image' => $request->cover_image,
        ]);

        return redirect('/admin/books')->with('success', 'Book updated successfully.');
    }

    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();

        return redirect('/admin/books')->with('success', 'Book deleted successfully.');
    }
}