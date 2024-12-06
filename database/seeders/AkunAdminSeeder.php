<?php

namespace Database\Seeders;

use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;

class AkunAdminSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('admins')->insert([
            'username' => 'afifahnn',
            'password' => Hash::make('admin1234'),
            'nama_admin' => 'Afifah',
            'telp_admin' => '0812345',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
