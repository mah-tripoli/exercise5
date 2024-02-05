<?php

namespace App\Http\Controllers;

use App\Actions\BookRentalAction;
use App\Actions\BookReturnAction;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    
    public function index()
    {
        $rentals = collect([]);

        $user = auth()->user();
        if ($user) {
            $rentals = $user->rentals;
        }

        $books = Book::paginate();
        
        // Add the userRented property to each book
        /** @var \Illuminate\Pagination\LengthAwarePaginator $books */
        $books->getCollection()->transform(function ($book) use ($rentals) {
            $book->userRented = $rentals->where('book_id', $book->id)->where('status', 'rented')->isNotEmpty();
            return $book;
        });

        return view('books.index', compact('books'));
    }

    public function rentBook(Request $request)
    {
        $user = auth()->user();

        $bookId = $request->input('book_id');

        $book = Book::find($bookId);

        try {
            $bookRentalAction = new BookRentalAction();
            $bookRentalAction($book, $user);
        } catch (\Exception $e) {
            return redirect()->route('books.index')->with('error', $e->getMessage());
        }

        return redirect()->route('books.index')->with('success', __('messages.book_rented'));
    }

    public function returnBook(Request $request)
    {
        $user = auth()->user();

        $bookId = $request->input('book_id');

        $book = Book::find($bookId);

        $bookReturnAction = new BookReturnAction();
        $bookReturnAction($book, $user);

        return redirect()->route('books.index')->with('success', __('messages.book_returned'));
    }
}
