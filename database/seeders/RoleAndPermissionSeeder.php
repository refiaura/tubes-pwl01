<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Buat Permissions
        Permission::create(['name' => 'view branches']);
        Permission::create(['name' => 'crud products']);
        Permission::create(['name' => 'crud transactions']);
        Permission::create(['name' => 'view reports']);
        Permission::create(['name' => 'check checklist']);

        // Buat Roles dan assign permissions
        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo(['view branches', 'view reports']);

        $manager = Role::create(['name' => 'manager']);
        $manager->givePermissionTo(['check checklist']);

        $supervisor = Role::create(['name' => 'supervisor']);
        $supervisor->givePermissionTo(['view transactions', 'check checklist', 'view reports']);

        $kasir = Role::create(['name' => 'kasir']);
        $kasir->givePermissionTo(['view products', 'view stock']);

        $pegawaiGudang = Role::create(['name' => 'pegawai_gudang']);
        $pegawaiGudang->givePermissionTo(['crud products', 'crud stock']);
    }
}
