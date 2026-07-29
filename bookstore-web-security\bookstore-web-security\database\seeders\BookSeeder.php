<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookSeeder extends Seeder
{
    public function run()
    {
        DB::table('books')->insert([
            [
                'title' => 'The Great Gatsby',
                'author' => 'F. Scott Fitzgerald',
                'genre' => 'Fiction',
                'price' => 10.99,
                'published_at' => '1925-04-10',
            ],
            [
                'title' => '1984',
                'author' => 'George Orwell',
                'genre' => 'Dystopian',
                'price' => 8.99,
                'published_at' => '1949-06-08',
            ],
            [
                'title' => 'To Kill a Mockingbird',
                'author' => 'Harper Lee',
                'genre' => 'Fiction',
                'price' => 7.99,
                'published_at' => '1960-07-11',
            ],
            [
                'title' => 'The Catcher in the Rye',
                'author' => 'J.D. Salinger',
                'genre' => 'Fiction',
                'price' => 6.99,
                'published_at' => '1951-07-16',
            ],
            [
                'title' => 'Moby Dick',
                'author' => 'Herman Melville',
                'genre' => 'Adventure',
                'price' => 9.99,
                'published_at' => '1851-10-18',
            ],
        ]);
    }
}