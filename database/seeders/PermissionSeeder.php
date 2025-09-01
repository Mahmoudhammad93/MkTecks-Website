<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Table;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Dashboard
        $table = Table::create([
            'name'=>'dashboard',
            'display_name_ar'=>'لوحة التحكم',
            'display_name_en'=>'Dashboard',
        ]);

        Permission::create([
            'table_id'=>$table->id,
            'name'=>'browse_dashboard',
            'display_name_ar'=>'تصفح لوحة التحكم',
            'display_name_en'=>'Dashboard',
        ]);

        Permission::create([
            'table_id'=>$table->id,
            'name'=>'browse_all_team',
            'display_name_ar'=>'كل الفريق',
            'display_name_en'=>'All Team',
        ]);

        Permission::create([
            'table_id'=>$table->id,
            'name'=>'browse_all_projects',
            'display_name_ar'=>'كل المشاريع',
            'display_name_en'=>'All Projects',
        ]);

        Permission::create([
            'table_id'=>$table->id,
            'name'=>'browse_all_services',
            'display_name_ar'=>'كل الخدمات',
            'display_name_en'=>'All Services',
        ]);

        // Admins
        $table = Table::create([
            'name'=>'admins',
            'display_name_ar'=>'المشرفين',
            'display_name_en'=>'Admins',
        ]);
        Permission::create([
            'table_id'=>$table->id,
            'name'=>'browse_admins',
            'display_name_ar'=>'المشرفين',
            'display_name_en'=>'Admins',
        ]);

        Permission::create([
            'table_id'=>$table->id,
            'name'=>'view_admins',
            'display_name_ar'=>'المشرفين',
            'display_name_en'=>'Admins View',
        ]);

        Permission::create([
            'table_id'=>$table->id,
            'name'=>'create_admins',
            'display_name_ar'=>'المشرفين',
            'display_name_en'=>'Admins Create',
        ]);

        Permission::create([
            'table_id'=>$table->id,
            'name'=>'edit_admins',
            'display_name_ar'=>'المشرفين',
            'display_name_en'=>'Admins Edit',
        ]);

        Permission::create([
            'table_id'=>$table->id,
            'name'=>'delete_admins',
            'display_name_ar'=>'المشرفين',
            'display_name_en'=>'Admins Delete',
        ]);

        // Roles

        $table = Table::create([
            'name'=>'roles',
            'display_name_ar'=>'المشرفين',
            'display_name_en'=>'Roles',
        ]);
        Permission::create([
            'table_id'=>$table->id,
            'name'=>'browse_roles',
            'display_name_ar'=>'الادوار',
            'display_name_en'=>'Roles',
        ]);

        Permission::create([
            'table_id'=>$table->id,
            'name'=>'view_roles',
            'display_name_ar'=>'الادوار',
            'display_name_en'=>'Roles View',
        ]);

        Permission::create([
            'table_id'=>$table->id,
            'name'=>'create_roles',
            'display_name_ar'=>'الادوار',
            'display_name_en'=>'Roles Create',
        ]);

        Permission::create([
            'table_id'=>$table->id,
            'name'=>'edit_roles',
            'display_name_ar'=>'الادوار',
            'display_name_en'=>'Roles Edit',
        ]);

        Permission::create([
            'table_id'=>$table->id,
            'name'=>'delete_roles',
            'display_name_ar'=>'الادوار',
            'display_name_en'=>'Roles Delete',
        ]);

        // Services

        $table = Table::create([
            'name'=>'services',
            'display_name_ar'=>'الخدمات',
            'display_name_en'=>'Services',
        ]);
        Permission::create([
            'table_id'=>$table->id,
            'name'=>'browse_services',
            'display_name_ar'=>'الخدمات',
            'display_name_en'=>'Services',
        ]);

        Permission::create([
            'table_id'=>$table->id,
            'name'=>'view_services',
            'display_name_ar'=>'الخدمات',
            'display_name_en'=>'Services View',
        ]);

        Permission::create([
            'table_id'=>$table->id,
            'name'=>'create_services',
            'display_name_ar'=>'الخدمات',
            'display_name_en'=>'Services Create',
        ]);

        Permission::create([
            'table_id'=>$table->id,
            'name'=>'edit_services',
            'display_name_ar'=>'الخدمات',
            'display_name_en'=>'Services Edit',
        ]);

        Permission::create([
            'table_id'=>$table->id,
            'name'=>'delete_services',
            'display_name_ar'=>'الخدمات',
            'display_name_en'=>'Services Delete',
        ]);

        // Projects

        $table = Table::create([
            'name'=>'projects',
            'display_name_ar'=>'المشاريع',
            'display_name_en'=>'Projects',
        ]);
        Permission::create([
            'table_id'=>$table->id,
            'name'=>'browse_projects',
            'display_name_ar'=>'المشاريع',
            'display_name_en'=>'Projects',
        ]);

        Permission::create([
            'table_id'=>$table->id,
            'name'=>'view_projects',
            'display_name_ar'=>'المشاريع',
            'display_name_en'=>'Projects View',
        ]);

        Permission::create([
            'table_id'=>$table->id,
            'name'=>'create_projects',
            'display_name_ar'=>'المشاريع',
            'display_name_en'=>'Projects Create',
        ]);

        Permission::create([
            'table_id'=>$table->id,
            'name'=>'edit_projects',
            'display_name_ar'=>'المشاريع',
            'display_name_en'=>'Projects Edit',
        ]);

        Permission::create([
            'table_id'=>$table->id,
            'name'=>'delete_projects',
            'display_name_ar'=>'المشاريع',
            'display_name_en'=>'Projects Delete',
        ]);

         // Team

         $table = Table::create([
            'name'=>'team',
            'display_name_ar'=>'الفريق',
            'display_name_en'=>'Team',
        ]);
        Permission::create([
            'table_id'=>$table->id,
            'name'=>'browse_team',
            'display_name_ar'=>'الفريق',
            'display_name_en'=>'Team',
        ]);

        Permission::create([
            'table_id'=>$table->id,
            'name'=>'view_team',
            'display_name_ar'=>'الفريق',
            'display_name_en'=>'Team View',
        ]);

        Permission::create([
            'table_id'=>$table->id,
            'name'=>'create_team',
            'display_name_ar'=>'الفريق',
            'display_name_en'=>'Team Create',
        ]);

        Permission::create([
            'table_id'=>$table->id,
            'name'=>'edit_team',
            'display_name_ar'=>'الفريق',
            'display_name_en'=>'Team Edit',
        ]);

        Permission::create([
            'table_id'=>$table->id,
            'name'=>'delete_team',
            'display_name_ar'=>'الفريق',
            'display_name_en'=>'Team Delete',
        ]);

        // Settings
        $table = Table::create([
            'name'=>'settings',
            'display_name_ar'=>'المشرفين',
            'display_name_en'=>'Settings',
        ]);
        Permission::create([
            'table_id'=>$table->id,
            'name'=>'browse_settings',
            'display_name_ar'=>'الاعدادات',
            'display_name_en'=>'Settings',
        ]);

        Permission::create([
            'table_id'=>$table->id,
            'name'=>'view_settings',
            'display_name_ar'=>'الاعدادات',
            'display_name_en'=>'Settings View',
        ]);

        Permission::create([
            'table_id'=>$table->id,
            'name'=>'create_settings',
            'display_name_ar'=>'الاعدادات',
            'display_name_en'=>'Settings Create',
        ]);

        Permission::create([
            'table_id'=>$table->id,
            'name'=>'edit_settings',
            'display_name_ar'=>'الاعدادات',
            'display_name_en'=>'Settings Edit',
        ]);

        Permission::create([
            'table_id'=>$table->id,
            'name'=>'delete_settings',
            'display_name_ar'=>'الاعدادات',
            'display_name_en'=>'Settings Delete',
        ]);
        
    }
}
