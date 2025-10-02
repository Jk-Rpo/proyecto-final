<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class UsersMain extends Seeder
{
    public function run()
    {

        $roles = [
            [ 'name' => 'admin', 'guard_name' => 'web',],
            [ 'name' => 'user', 'guard_name' => 'web',],
            [ 'name' => 'doctor', 'guard_name' => 'web',],
            [ 'name' => 'receptionist', 'guard_name' => 'web',],
            [ 'name' => 'nurse', 'guard_name' => 'web',],
            [ 'name' => 'doctor', 'guard_name' => 'web',],
        ];
        foreach ($roles as $role) {
            Role::updateOrInsert(
                ['name' => $role['name'], 'guard_name' => $role['guard_name']]
            );
        }

        $permissions = [
            ['name' => 'create', 'guard_name' => 'web'],
            ['name' => 'read', 'guard_name' => 'web'],
            ['name' => 'update', 'guard_name' => 'web'],
            ['name' => 'delete', 'guard_name' => 'web'],
        ];
        foreach ($permissions as $permission) {
            Permission::updateOrInsert(
                ['name' => $permission['name'], 'guard_name' => $permission['guard_name']]
            );
        }

        $users = [
            ['name' => 'Admin', 'email' => 'admin@gmail.com', 'password' => Hash::make('password'), 'role' => 'admin'],
            ['name' => 'User', 'email' => 'user@gmail.com', 'password' => Hash::make('password'), 'role' => 'user'],
            ['name' => 'Doctor', 'email' => 'doctor@gmail.com', 'password' => Hash::make('password'), 'role' => 'doctor'],
            ['name' => 'Nurse', 'email' => 'nurse@gmail.com', 'password' => Hash::make('password'), 'role' => 'nurse'],
            ['name' => 'Receptionist', 'email' => 'receptionist@gmail.com', 'password' => Hash::make('password'), 'role' => 'receptionist'],
        ];

        foreach ($users as $user) {
            $userCreated = User::updateOrCreate(
                ['name' => $user['name'], 'email' => $user['email'], 'password' => $user['password']]
            );

            // asignar el rol de admin
            $userCreated->assignRole($user['role']);
        }
    }
}
