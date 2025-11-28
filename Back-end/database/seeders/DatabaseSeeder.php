<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category; // <--- Importante: Adicione essa linha!
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $categories = [
            'Vestimentas',
            'Acessórios',
            'Livros',
            'Dados',
            'Brinquedos',
            'Outro'
        ];

        foreach ($categories as $categoryName) {
            // firstOrCreate: Cria apenas se não existir (evita duplicatas)
            Category::firstOrCreate([
                'name' => $categoryName
            ]);
        }
    }
}


