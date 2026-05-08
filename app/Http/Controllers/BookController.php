<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $books = Book::with('user')
            ->when($search, function ($query) use ($search) {
                $query->where('author_name', 'like', '%' . $search . '%')
                    ->orWhere('title', 'like', '%' . $search . '%')
                    ->orWhere('status', 'like', '%' . $search . '%')
                    ->orWhere('note', 'like', '%' . $search . '%');
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('books.index', compact('books', 'search'));
    }

    public function adminIndex(Request $request)
    {
        $search = $request->search;

        $books = Book::with('user')
            ->when($search, function ($query) use ($search) {
                $query->where('author_name', 'like', '%' . $search . '%')
                    ->orWhere('title', 'like', '%' . $search . '%')
                    ->orWhere('status', 'like', '%' . $search . '%')
                    ->orWhere('note', 'like', '%' . $search . '%')
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', '%' . $search . '%')
                            ->orWhere('email', 'like', '%' . $search . '%');
                    });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.books.index', compact('books', 'search'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'entry_date' => 'required|date',
            'author_name' => 'required|string',
            'title' => 'required|string',
            'status' => 'required|string',
            'note' => 'nullable|string',
        ]);

        Book::create([
            'user_id' => auth()->id(),
            'entry_date' => $request->entry_date,
            'author_name' => $request->author_name,
            'title' => $request->title,
            'status' => $request->status,
            'note' => $request->note,
        ]);

        return back()->with('success', 'Data buku berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'entry_date' => 'required|date',
            'author_name' => 'required|string',
            'title' => 'required|string',
            'status' => 'required|string',
            'note' => 'nullable|string',
        ]);

        $book = Book::findOrFail($id);

        $book->update([
            'entry_date' => $request->entry_date,
            'author_name' => $request->author_name,
            'title' => $request->title,
            'status' => $request->status,
            'note' => $request->note,
        ]);

        return back()->with('success', 'Data buku berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();

        return back()->with('success', 'Data buku berhasil dihapus.');
    }
}