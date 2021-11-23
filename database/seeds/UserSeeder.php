<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id'        => 1
            'user_name' => 'Usuário Padrão',
            'user_email' => 'usuario@email.com',
            'user_state' => 'SP',
            'user_city'  => 'Bauru',
            'user_phone' => '(14) 99145-2857',
            'user_gender' => 'M',
            'user_sit'    => 'A',
            'user_password' => Hash::make('Senha@123'),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
