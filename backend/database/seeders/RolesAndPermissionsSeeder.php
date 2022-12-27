<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'api']);
        $manager = Role::firstOrCreate(['name' => 'manager', 'guard_name' => 'api']);
        $controller = Role::firstOrCreate(['name' => 'ticket controller', 'guard_name' => 'api']);

        $this->eventPermissions($admin, $manager, $controller);
        $this->reservationPermissions($admin, $manager, $controller);
        $this->menuSectionPermissions($admin, $manager, $controller);
        $this->menuItemPermissions($admin, $manager, $controller);
        $this->miscPermissions($admin, $manager, $controller);
        $this->userPermissions($admin);
    }

    /**
     * Create and assing the permissions for handle actions over events
     *
     * @param Role $admin
     * @param Role $manager
     * @param Role $controller
     */
    protected function eventPermissions(Role $admin, Role $manager, Role $controller)
    {
        $permissions = [
            Permission::firstOrCreate(['name' => 'events.create', 'guard_name' => 'api']),
            Permission::firstOrCreate(['name' => 'events.update', 'guard_name' => 'api']),
            Permission::firstOrCreate(['name' => 'events.delete', 'guard_name' => 'api']),
            Permission::firstOrCreate(['name' => 'events.erase', 'guard_name' => 'api']),
            Permission::firstOrCreate(['name' => 'events.restore', 'guard_name' => 'api']),
        ];

        $admin->givePermissionTo($permissions);
        $manager->givePermissionTo([$permissions[0], $permissions[1], $permissions[2]]);
    }

    /**
     * Create and assing the permissions for handle actions over menu sections
     *
     * @param Role $admin
     * @param Role $manager
     * @param Role $controller
     */
    protected function menuSectionPermissions(Role $admin, Role $manager, Role $controller)
    {
        $permissions = [
            Permission::firstOrCreate(['name' => 'menu_sections.create', 'guard_name' => 'api']),
            Permission::firstOrCreate(['name' => 'menu_sections.update', 'guard_name' => 'api']),
            Permission::firstOrCreate(['name' => 'menu_sections.delete', 'guard_name' => 'api']),
        ];

        $admin->givePermissionTo($permissions);
        $manager->givePermissionTo($permissions);
    }

    /**
     * Create and assing the permissions for handle actions over menu items
     *
     * @param Role $admin
     * @param Role $manager
     * @param Role $controller
     */
    protected function menuItemPermissions(Role $admin, Role $manager, Role $controller)
    {
        $permissions = [
            Permission::firstOrCreate(['name' => 'menu_items.create', 'guard_name' => 'api']),
            Permission::firstOrCreate(['name' => 'menu_items.update', 'guard_name' => 'api']),
            Permission::firstOrCreate(['name' => 'menu_items.delete', 'guard_name' => 'api']),
        ];

        $admin->givePermissionTo($permissions);
        $manager->givePermissionTo($permissions);
    }

    /**
     * Create and assing the permissions for handle actions over reservations
     *
     * @param Role $admin
     * @param Role $manager
     * @param Role $controller
     */
    protected function reservationPermissions(Role $admin, Role $manager, Role $controller)
    {
        $permissions = [
            Permission::firstOrCreate(['name' => 'reservations.create', 'guard_name' => 'api']),
            Permission::firstOrCreate(['name' => 'reservations.update', 'guard_name' => 'api']),
            Permission::firstOrCreate(['name' => 'reservations.delete', 'guard_name' => 'api']),
            Permission::firstOrCreate(['name' => 'reservations.erase', 'guard_name' => 'api']),
            Permission::firstOrCreate(['name' => 'reservations.restore', 'guard_name' => 'api']),
        ];

        $admin->givePermissionTo($permissions);
        $manager->givePermissionTo([$permissions[0], $permissions[1], $permissions[2]]);
        $controller->givePermissionTo($permissions[1]);
    }

    /**
     * Create and assing the permissions for handle actions over misc things
     *
     * @param Role $admin
     * @param Role $manager
     * @param Role $controller
     */
    protected function miscPermissions(Role $admin, Role $manager, Role $controller)
    {
        $permissions = [
            Permission::firstOrCreate(['name' => 'menu.copy', 'guard_name' => 'api']),
        ];

        $admin->givePermissionTo($permissions);
        $manager->givePermissionTo($permissions);
    }

    /**
     * Create and assing the permissions for handle actions over misc things
     *
     * @param Role $admin
     */
    protected function userPermissions(Role $admin)
    {
        $permissions = [
            Permission::firstOrCreate(['name' => 'users.create', 'guard_name' => 'api']),
            Permission::firstOrCreate(['name' => 'users.update', 'guard_name' => 'api']),
            Permission::firstOrCreate(['name' => 'users.delete', 'guard_name' => 'api']),
            Permission::firstOrCreate(['name' => 'users.erase', 'guard_name' => 'api']),
            Permission::firstOrCreate(['name' => 'users.restore', 'guard_name' => 'api']),
        ];

        $admin->givePermissionTo($permissions);
    }
}
