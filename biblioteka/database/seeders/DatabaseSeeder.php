<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\User;
use App\Models\Genre;
use App\Models\Rent;
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
        
        $this->call([
            RoleSeeder::class,
            
        ]);
        User::factory(10)->create();
        Author::factory(4)->create();
        Genre::factory(7)->create();
        Book::factory(100)->create();
        Rent::factory(2)->create();
    }
}
