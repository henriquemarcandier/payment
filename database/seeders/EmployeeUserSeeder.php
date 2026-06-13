<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EmployeeUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Ana Silva',
            'email'    => 'ana@empresa.com',
            'password' => Hash::make('password'),
            'role'     => 'employee',
            'country'  => 'Portugal',
            'currency' => 'EUR',
        ]);

        User::create([
            'name'     => 'John Smith',
            'email'    => 'john@empresa.com',
            'password' => Hash::make('password'),
            'role'     => 'employee',
            'country'  => 'United Kingdom',
            'currency' => 'GBP',
        ]);

        User::create([
            'name'     => 'Maria Garcia',
            'email'    => 'maria@empresa.com',
            'password' => Hash::make('password'),
            'role'     => 'employee',
            'country'  => 'Spain',
            'currency' => 'EUR',
        ]);

        User::create([
            'name'     => 'Takashi Yamamoto',
            'email'    => 'takashi@empresa.com',
            'password' => Hash::make('password'),
            'role'     => 'employee',
            'country'  => 'Japan',
            'currency' => 'JPY',
        ]);

        User::create([
            'name'     => 'Sarah Johnson',
            'email'    => 'sarah@empresa.com',
            'password' => Hash::make('password'),
            'role'     => 'employee',
            'country'  => 'United States',
            'currency' => 'USD',
        ]);

        User::create([
            'name'     => 'Carlos Mendes',
            'email'    => 'carlos@empresa.com',
            'password' => Hash::make('password'),
            'role'     => 'employee',
            'country'  => 'Brazil',
            'currency' => 'BRL',
        ]);

        User::create([
            'name'     => 'Finance Team',
            'email'    => 'finance@empresa.com',
            'password' => Hash::make('password'),
            'role'     => 'finance',
            'country'  => 'Portugal',
            'currency' => 'EUR',
        ]);
    }
}
