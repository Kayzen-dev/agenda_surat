<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'admin',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('admin123') 
        ]);
        $admin->assignRole('admin');

        $sekre = User::create([
            'name' => 'sekre',
            'username' => 'sekre',
            'email' => 'sekre@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('sekre123') 
        ]);
        $sekre->assignRole('sekretariat');



        $arsip = User::create([
            'name' => 'arsip',
            'username' => 'arsip',
            'email' => 'arsip@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('arsip123') 
        ]);
        $arsip->assignRole('kearsipan');


        $layanan = User::create([
            'name' => 'layanan',
            'username' => 'layanan',
            'email' => 'layanan@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('layanan123') 
        ]);
        $layanan->assignRole('layanan');



        $pengembangan = User::create([
            'name' => 'pengembangan',
            'username' => 'pengembangan',
            'email' => 'pengembangan@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('pengembangan123') 
        ]);
        $pengembangan->assignRole('pengembangan');


        
    }
}
