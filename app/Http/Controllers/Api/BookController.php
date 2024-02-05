<?php

namespace App\Http\Controllers\Api;

use App\Actions\BookRentalAction;
use App\Actions\BookReturnAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\BookResource;
use App\Http\Resources\Api\RentalResource;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::paginate();

        return BookResource::collection($books);
    }

    public function show(Book $book)
    {
        return new BookResource($book);
    }

    public function rent(Book $book)
    {
        $user = auth()->user();

        try {
            $bookRentalAction = new BookRentalAction();
            $bookRentalAction($book, $user);

            return response()->json(['message' => __('messages.book_rented')]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function return(Book $book)
    {
        $user = auth()->user();

        $bookReturnAction = new BookReturnAction();
        $bookReturnAction($book, $user);

        return response()->json(['message' => __('messages.book_returned')]);
    }

    public function rentedBooks()
    {
        $user = auth()->user();

        $rentals = $user->rentals->where('status', 'rented');

        return RentalResource::collection($rentals);


    }
}
