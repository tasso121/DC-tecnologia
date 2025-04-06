<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;


class UsuarioTesteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'teste@teste.com'],
            [
                'name' => 'Usuário Teste',
                'password' => bcrypt('12345678'),
            ]
        );
    }
}
