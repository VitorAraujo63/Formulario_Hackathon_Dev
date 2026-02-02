<?php

namespace Database\Seeders;

use App\Models\AulaCategoria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AulaCategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cats = ['PHP Básico', 'PHP Intermediário', 'Laravel Inicial'];
        foreach ($cats as $c) {
            AulaCategoria::create([
                'nome' => $c,
                'slug' => Str::slug($c)
            ]);
        }
    }
}
