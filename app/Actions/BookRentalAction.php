<?php

namespace App\Actions;

use App\Events\BookRented;
use App\Models\Book;
use App\Models\Rental;
use App\Models\User;

class BookRentalAction
{

    public function __invoke(Book $book, User $user)
    {
        // Check if the book is already rented
        $rentedBefore = Rental::where('book_id', $book->id)
            ->where('user_id', $user->id)
            ->where('status', 'rented')
            ->exists();
        if ($rentedBefore) {
            throw new \Exception(__('messages.book_already_rented'));
        }

        if ($book->available_quantity > 0) {
            $book->available_quantity--;
            $book->save();

            Rental::create([
                'user_id' => $user->id,
                'book_id' => $book->id,
                'rental_date' => now(),
                'due_date' => now()->addDays(7),
                'status' => 'rented',
            ]);

            BookRented::dispatch($book, $user);
        } else {
            throw new \Exception(__('messages.book_not_available'));
        }
        
        return true;
    }
}
