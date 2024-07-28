<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Tạo các quyền
        Permission::create(['name' => 'User Manager']);
        Permission::create(['name' => 'Role Manager']);
        Permission::create(['name' => 'Permission Manager']);
        Permission::create(['name' => 'Products Manager']);
        Permission::create(['name' => 'Contact Manager']);
        Permission::create(['name' => 'Setting Manager']);
        Permission::create(['name' => 'News Manager']);
        // Thêm các quyền khác nếu cần
    }
}
