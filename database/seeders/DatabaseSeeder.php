<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Team;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $roleAdmin = Role::create(['name' => 'admin']);
        $roleEditor = Role::create(['name' => 'editor']);

        $permissionEditPosts = Permission::create(['name' => 'edit-posts']);
        $permissionDeletePosts = Permission::create(['name' => 'delete-posts']);

        $roleAdmin->permissions()->attach([$permissionEditPosts->id, $permissionDeletePosts->id]);
        $roleEditor->permissions()->attach($permissionEditPosts->id);

        $user = User::find(1);
        $user->roles()->attach($roleAdmin->id);
        // /** @var Tenant $tenant */
        // $tenant = Tenant::query()->create(
        //     attributes: [
        //         'id' => 'treblle',
        //     ],
        // );

        // $tenant->domains()->create(
        //     attributes: [
        //         'domain' => 'treblle.localhost',
        //     ],
        // );

        // Tenant::all()->runForEach(function (Tenant $tenant) {
        //     $user = User::factory()->create([
        //         'name' => 'Mecene Phrygien',
        //         'email' => 'mecene@gmail.com',
        //     ]);

        //     Team::factory()->for($user)->create([
        //         'name' => 'Developer Laravel',
        //         'logo' => null,
        //         'description' => 'The DevRel Team is awesome'
        //     ]);
        // });

    }
}
