<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Author::truncate();
        User::truncate();
        Book::truncate();
        

        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $author1 = Author::factory()->create();
        $author2 = Author::factory()->create();
        $author3 = Author::factory()->create();
        $author4 = Author::factory()->create();


        Book::factory(2)->create([
            'user_id'=>$user1->id,
            'author_id'=>$author1->id,
        ]);

        Book::factory(2)->create([
            'user_id'=>$user1->id,
            'author_id'=>$author2->id,
        ]);

        Book::factory(2)->create([
            'user_id'=>$user1->id,
            'author_id'=>$author3->id,
        ]);
        Book::factory(2)->create([
            'user_id'=>$user2->id,
            'author_id'=>$author4->id,
        ]);
    }
}
