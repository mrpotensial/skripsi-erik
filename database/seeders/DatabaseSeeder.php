<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('users')->insert([
            'name' => 'Koordinator',
            'email' => 'koordinator@example.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => \Illuminate\Support\Str::random(10),
            'level' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ]); //Create User
        \Illuminate\Support\Facades\DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => \Illuminate\Support\Str::random(10),
            'level' => '0',
            'created_at' => now(),
            'updated_at' => now(),
        ]); //Create User
        \Illuminate\Support\Facades\DB::table('users')->insert([
            'name' => 'Petugas',
            'email' => 'petugas@example.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => \Illuminate\Support\Str::random(10),
            'level' => '2',
            'created_at' => now(),
            'updated_at' => now(),
        ]); //Create User

        \Illuminate\Support\Facades\DB::table('districts')->insert([
            'nama_kecamatan' => 'Sekadau Hilir',
            'created_at' => now(),
            'updated_at' => now(),
        ]); //Create User

        \Illuminate\Support\Facades\DB::table('districts')->insert([
            'nama_kecamatan' => 'Sekadau Hulu',
            'created_at' => now(),
            'updated_at' => now(),
        ]); //Create User


        // \App\Models\User::factory(10)->create();
    }
}
