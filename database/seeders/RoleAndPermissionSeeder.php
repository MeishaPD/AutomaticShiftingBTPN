<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'view dashboard',
            'request shifting',
            'view reports',
            'download reports',
            'manage employee onboarding',
            'delete employee shifts',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $employeeRole = Role::create(['name' => 'employee']);
        $employeeRole->givePermissionTo([
            'view dashboard',
            'request shifting',
        ]);

        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo([
            'view dashboard',
            'request shifting',
            'view reports',
            'download reports',
            'manage employee onboarding',
            'delete employee shifts',
        ]);

        $adminUser = User::firstOrCreate(
            ['email' => 'admin@btpn.com'],
            [
                'nik'      => '1234567890123456',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role'     => 'admin',
            ]
        );

        $adminUser->assignRole('admin');

        $employeeUser = User::firstOrCreate(
            ['email' => 'employee@btpn.com'],
            [
                'nik'      => '6543210987654321',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role'     => 'employee',
            ]
        );

        $employeeUser->assignRole('employee');
    }
}
