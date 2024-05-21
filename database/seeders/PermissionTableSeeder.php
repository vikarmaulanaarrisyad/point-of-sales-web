<?php

namespace Database\Seeders;

use App\Models\PermissionGroup;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            [
                'name' => 'Dashboard Index',
                'permission_group_id' => PermissionGroup::where('name', 'Dashboard')->first()->id,
            ],
            [
                'name' => 'Konfigurasi Index',
                'permission_group_id' => PermissionGroup::where('name', 'Konfigurasi')->first()->id,
            ],
            [
                'name' => 'User Index',
                'permission_group_id' => PermissionGroup::where('name', 'User')->first()->id,
            ],
            [
                'name' => 'User Store',
                'permission_group_id' => PermissionGroup::where('name', 'User')->first()->id,
            ],
            [
                'name' => 'User Show',
                'permission_group_id' => PermissionGroup::where('name', 'User')->first()->id,
            ],
            [
                'name' => 'User Edit',
                'permission_group_id' => PermissionGroup::where('name', 'User')->first()->id,
            ],
            [
                'name' => 'User Update',
                'permission_group_id' => PermissionGroup::where('name', 'User')->first()->id,
            ],
            [
                'name' => 'User Delete',
                'permission_group_id' => PermissionGroup::where('name', 'User')->first()->id,
            ],
            [
                'name' => 'Role Index',
                'permission_group_id' => PermissionGroup::where('name', 'Role')->first()->id,
            ],
            [
                'name' => 'Role Store',
                'permission_group_id' => PermissionGroup::where('name', 'Role')->first()->id,
            ],
            [
                'name' => 'Role Edit',
                'permission_group_id' => PermissionGroup::where('name', 'Role')->first()->id,
            ],
            [
                'name' => 'Role Show',
                'permission_group_id' => PermissionGroup::where('name', 'Role')->first()->id,
            ],
            [
                'name' => 'Role Update',
                'permission_group_id' => PermissionGroup::where('name', 'Role')->first()->id,
            ],
            [
                'name' => 'Role Delete',
                'permission_group_id' => PermissionGroup::where('name', 'Role')->first()->id,
            ],
            [
                'name' => 'Permission Index',
                'permission_group_id' => PermissionGroup::where('name', 'Permission')->first()->id,
            ],
            [
                'name' => 'Permission Store',
                'permission_group_id' => PermissionGroup::where('name', 'Permission')->first()->id,
            ],
            [
                'name' => 'Permission Show',
                'permission_group_id' => PermissionGroup::where('name', 'Permission')->first()->id,
            ],
            [
                'name' => 'Permission Edit',
                'permission_group_id' => PermissionGroup::where('name', 'Permission')->first()->id,
            ],
            [
                'name' => 'Permission Update',
                'permission_group_id' => PermissionGroup::where('name', 'Permission')->first()->id,
            ],
            [
                'name' => 'Permission Delete',
                'permission_group_id' => PermissionGroup::where('name', 'Permission')->first()->id,
            ],
            [
                'name' => 'Group Permission Index',
                'permission_group_id' => PermissionGroup::where('name', 'Group Permission')->first()->id,
            ],
            [
                'name' => 'Group Permission Store',
                'permission_group_id' => PermissionGroup::where('name', 'Group Permission')->first()->id,
            ],
            [
                'name' => 'Group Permission Show',
                'permission_group_id' => PermissionGroup::where('name', 'Group Permission')->first()->id,
            ],
            [
                'name' => 'Group Permission Edit',
                'permission_group_id' => PermissionGroup::where('name', 'Group Permission')->first()->id,
            ],
            [
                'name' => 'Group Permission Update',
                'permission_group_id' => PermissionGroup::where('name', 'Group Permission')->first()->id,
            ],
            [
                'name' => 'Group Permission Delete',
                'permission_group_id' => PermissionGroup::where('name', 'Group Permission')->first()->id,
            ],
            [
                'name' => 'Pengaturan Index',
                'permission_group_id' => PermissionGroup::where('name', 'Pengaturan')->first()->id,
            ],

        ];

        foreach ($permissions as $value) {
            $permission = new Permission;
            $permission->name = $value['name'];
            $permission->permission_group_id = $value['permission_group_id'];
            $permission->save();
        }
    }
}
