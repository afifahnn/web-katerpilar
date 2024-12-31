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
            'id' => 1,
            'username' => 'admin',
            'password' => Hash::make('admin12345'),
            'nama_admin' => 'Afifah',
            'telp_admin' => '0812345',
            'jenis_rekening' => 'BRI',
            'no_rekening' => '0002928391827009',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
