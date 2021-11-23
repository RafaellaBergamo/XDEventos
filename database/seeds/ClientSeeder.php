<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('clients')->insert([
            'id'          =>  1,
            'client_name' => 'João da Silva',
            'client_email' => 'joao.silva@gmail.com',
            'client_cnpj' => '26.462.283/0001-87',
            'client_phone' => '(14) 99854-5158',
            'client_origin' => 'Facebook',
            'client_state' => 'SP',
            'client_city' => 'Barueri',
            'client_sit' => 'A',
            'client_obs' => '',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('clients')->insert([
            'id'          => 2,
            'client_name' => 'Ana Maria de Oliveira',
            'client_email' => 'anamaria_oliveira@gmail.com',
            'client_cnpj' => '44.375.566/0001-73',
            'client_phone' => '(14) 99742-8567',
            'client_origin' => 'Site',
            'client_state' => 'MG',
            'client_city' => 'Belo Horizonte',
            'client_sit' => 'I',
            'client_obs' => '',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
