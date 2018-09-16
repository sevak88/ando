<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create(
            [
                "name" => "Andranik tatulyan",
                "email" => "and-5588@mail.ru",
                "password" => Hash::make("qwerty2468"),
                "created_at" => \Illuminate\Support\Carbon::now(),
                "updated_at" => \Illuminate\Support\Carbon::now(),
            ]
        );
    }
}
