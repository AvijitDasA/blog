<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Reset cached roles and permissions
            app()['cache']->forget('spatie.permission.cache');
            $arrPermissions = [
            // user------------------
            'user View',
            'user Create',
            'user Edit',
            'user Delete',
            // posts------------------
            'posts View',
            'posts Create',
            'posts Edit',
            'posts Delete',
            // comments------------------
            'comments View',
            'comments Create',
            'comments Edit',
            'comments Delete',
            ];
            $permissions=Permission::get()->pluck('name')->toArray();
            foreach($arrPermissions as $ap)
            {
                if(in_array($ap,$permissions))
                continue;
                Permission::create( ['name' => $ap]);
            }
            $existingRole = Role::where('name', 'Admin')
            ->where('guard_name', "web")
            ->first();

        if ($existingRole) {
            // The role exists, so delete it
            $existingRole->delete();
        }
        $adminRole = Role::create(
            [
                'name' => 'Admin',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),

            ]
        );

        foreach($arrPermissions as $ap)
        {
            $permission = Permission::findByName($ap);
           // $adminRole->givePermissionTo($permission);
            $adminRole->givePermissionTo($permission);
        }
            $seededWebsite = 'admin@gmail.com';
        $user = User::where('email', '=', $seededWebsite)->first();
        if ($user === null) {

            $user = User::create([
                'name'                         => 'Admin',
                'email'                         => 'admin@gmail.com',
                'password'                      => Hash::make('admin'),

            ]);

            $user->assignRole($adminRole);

        }
        else
        {

            $user->assignRole($adminRole);
        }


    }

}
