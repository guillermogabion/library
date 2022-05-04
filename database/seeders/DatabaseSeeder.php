<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

use function PHPSTORM_META\map;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        User::create([
            'name' => 'admin lang',
            'password' => bcrypt(123123),
            'email' => 'admin@lang.com',
            'isAdmin' => true
        ]);

        Student::create([
            'first_name' => 'Cody',
            'last_name' => 'Kazuto',
            'phone_number' => '213217',
            'email'=> 'cody@gmail.com',
            'course' => 'bscpe', 
            'year' => '4',
        ]);

        Teacher::create([
            'first_name' => 'Keno',
            'last_name' => 'Bacunawa',
            'phone_number' => '99999',
            'email' => 'keno@gmail.com',
        ]);

        Book::create([
            'book_title'=> 'Calculus',
            'author'=> 'Cong',
            'available'=>'20',
            'total'=> '20',
            'status'=>'1',
        ]);

        Book::create([
            'book_title'=> 'English',
            'author'=> 'Alfred',
            'available'=>'10',
            'total'=> '10',
            'status'=>'1',
        ]);

        Artisan::call('passport:install');
        Artisan::call('storage:link');
        Artisan::call('key:generate');
    }
}
