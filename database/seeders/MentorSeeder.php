<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mentor;
use Illuminate\Support\Facades\Hash;

class MentorSeeder extends Seeder
{
    public function run(): void
    {
        if (!Mentor::where('email', 'admin@hackhealth.com')->exists()) {
            Mentor::create([
                'nome' => 'Root',
                'email' => 'administracao@devmenthors.com.br',
                'password' => Hash::make('DevMenthors@123'),
                'funcao' => 'Root',
                'status' => 'ativo',
            ]);
        }
    }
}
