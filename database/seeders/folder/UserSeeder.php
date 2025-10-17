<?php

namespace Database\Seeders\Folder;

use App\Models\Credential;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ADMIN
        $credential = Credential::firstOrCreate([
            'username' => 'JhonRoca',
            'password' => Hash::make('hola1234'),
            'role' => 'admin',
        ]);

        User::firstOrCreate([
            'credential_id' => $credential->id,
            'document' => '1005772426',
            'names' => 'Jhon',
            'last_names' => 'Roca',
        ]);

        // USERS
        $users = [
            [
                'document' => '1111111111',
                'names' => 'Pepe',
                'last_names' => 'Chun',
            ],
            [
                'document' => '2222222222',
                'names' => 'Mara',
                'last_names' => 'DelMar',
            ],
            [
                'document' => '3333333333',
                'names' => 'Jose',
                'last_names' => 'Perez',
            ]
        ];

        foreach ($users as $user) {
            $credential = Credential::firstOrCreate([
                'username' => $user['names'].$user['last_names'],
                'password' => Hash::make('hola1234'),
            ]);

            User::firstOrCreate([
                'credential_id' => $credential->id,
                'document' => $user['document'],
                'names' => $user['names'],
                'last_names' => $user['last_names'],
            ]);
        }
    }
}
