<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
            "name" => "Thasso Araújo",
            "email" => "thasso@mail.com",
            "password" => Hash::make("teste@123"),
        ]);
    }
}
