<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Daftar izin untuk manajemen (hanya untuk admin)
        $permissionsManage = [
            'tambah-user', 'edit-user', 'hapus-user', 'lihat-user',
            'tambah-surat-masuk', 'edit-surat-masuk', 'hapus-surat-masuk', 'lihat-surat-masuk',
            'tambah-surat-keluar', 'edit-surat-keluar', 'hapus-surat-keluar', 'lihat-surat-keluar'
        ];

        $permissionApp = [
            'tambah-surat-masuk', 'edit-surat-masuk', 'hapus-surat-masuk', 'lihat-surat-masuk',
            'tambah-surat-keluar', 'edit-surat-keluar', 'hapus-surat-keluar', 'lihat-surat-keluar'
        ];

        // Buat izin jika belum ada
        foreach (array_merge($permissionsManage, $permissionApp) as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Buat role jika belum ada
        $roleAdmin = Role::firstOrCreate(['name' => 'admin']);
        $roleSekre = Role::firstOrCreate(['name' => 'sekretariat']);
        $roleArsip = Role::firstOrCreate(['name' => 'kearsipan']);
        $roleLayanan = Role::firstOrCreate(['name' => 'layanan']);
        $rolePengembangan = Role::firstOrCreate(['name' => 'pengembangan']);

        // Tetapkan semua izin ke peran admin
        $roleAdmin->syncPermissions($permissionsManage);
        $roleSekre->syncPermissions($permissionsManage);


        $roleArsip->syncPermissions($permissionApp);
        $roleLayanan->syncPermissions($permissionApp);
        $rolePengembangan->syncPermissions($permissionApp);
        
    }
}
