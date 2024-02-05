<?php

namespace App\Actions;

use App\Events\BookRented;
use App\Models\Book;
use App\Models\Rental;
use App\Models\User;

class BookReturnAction
{

    public function __invoke(Book $book, User $user)
    {
        if ($user->rentals()->where('book_id', $book->id)->exists()) {
            $user->rentals()->where('book_id', $book->id)->where('status', 'rented')->update([
                'status' => 'returned',
                'return_date' => now(),
            ]);
            $book->available_quantity++;
            $book->save();
        }
        
        return true;
    }
}
