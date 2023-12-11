<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\View;
class RolesandPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role_admin = Role::create(['name' => 'admin']);
        $role_customer = Role::create(['name' => 'customer']);

        $manage_payroll   = Permission::create (['name' =>'manage_payroll']);
        // $read_payroll = Permission::create (['name' => 'read_payslip']);
        $add_customer = Permission::create (['name'=> 'add_customer']);
        $delete_customer = Permission::create (['name'=> 'delete_customer']);
        $edit_customer = Permission::create (['name'=> 'edit_customer']);
        $add_rental = Permission::create(['name' => 'add_rental']);



        $permission_admin = [$add_customer,$delete_customer, $edit_customer, $manage_payroll , $add_rental];
        $permission_customer = [$add_rental];


        $role_admin->syncPermissions($permission_admin);
        $role_customer->syncPermissions($permission_customer);


        User::find(1)->assignRole($role_admin);
        User::find(2)->assignRole($role_customer);


        // Retrieve the "employee" and "specialEmployee" roles and pass their IDs to the view
        // $employeeRole = Role::where('name', 'employee')->first();
        // $specialEmployeeRole = Role::where('name', 'specialEmployee')->first();

        // View::share([
        //     'employeeRoleId' => $employeeRole ? $employeeRole->id : null,
        //     'specialEmployeeRoleId' => $specialEmployeeRole ? $specialEmployeeRole->id : null,
        // ]);

    }
}
