<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert(
            [
                [
                    'name' => 'W',
                    'email' => 'w@gmail.com',
                    'password' => Hash::make('RsxneGcgXi26h3N'),
                    'email_verified_at' => now(),
                    'slug' => Str::slug('w'),
                    'phone' => '06 06 06 06 06'
                ],
                [
                    'name' => 'N',
                    'email' => 'n@gmail.com',
                    'password' => Hash::make('nUgJCMQtUrG72QE'),
                    'email_verified_at' => now(),
                    'slug' => Str::slug('n'),
                    'phone' => '06 06 06 06 06'
                ],
                [
                    'name' => 'P',
                    'email' => 'p@gmail.com',
                    'password' => Hash::make('nUgJCMQtUrG72QE'),
                    'email_verified_at' => now(),
                    'slug' => Str::slug('p'),
                    'phone' => '06 06 06 06 06'
                ],
                [
                    'name' => 'B',
                    'email' => 'b@gmail.com',
                    'password' => Hash::make('nUgJCMQtUrG72QE'),
                    'email_verified_at' => now(),
                    'slug' => Str::slug('b'),
                    'phone' => '06 06 06 06 06'

                ],
                [
                    'name' => 'Admin',
                    'email' => 'admin@gmail.com',
                    'password' => Hash::make('@admin2024!'),
                    'email_verified_at' => now(),
                    'slug' => Str::slug('Admin'),
                    'phone' => '06 06 06 06 06'
                ],
                [
                    'name' => 'User',
                    'email' => 'user@gmail.com',
                    'password' => Hash::make('@admin2024!'),
                    'email_verified_at' => now(),
                    'slug' => Str::slug('User'),
                    'phone' => '06 06 06 06 06'
                ],
                [
                    'name' => 'Hôte',
                    'email' => 'host@gmail.com',
                    'password' => Hash::make('@admin2024!'),
                    'email_verified_at' => now(),
                    'slug' => Str::slug('Hôte'),
                    'phone' => '06 06 06 06 06'
                ],
            ]
        );

        $william = User::where('email', 'w@gmail.com')->first();
        $nicolas = User::where('email', 'n@gmail.com')->first();
        $patrick = User::where('email', 'p@gmail.com')->first();
        $benjamin = User::where('email', 'b@gmail.com')->first();
        $admin = User::where('email', 'admin@gmail.com')->first();
        $user = User::where('email', 'user@gmail.com')->first();
        $host = User::where('email', 'host@gmail.com')->first();

        $adminRole = Role::where('name', 'admin')->first();

        if ($adminRole) {
            $william->assignRole($adminRole);
            $nicolas->assignRole($adminRole);
            $patrick->assignRole($adminRole);
            $benjamin->assignRole($adminRole);
            $admin->assignRole($adminRole);
        }

        $userRole = Role::where('name', 'user')->first();
        $hoteRole = Role::where('name', 'hôte')->first();

        if ($userRole && $hoteRole) {
            $user->assignRole($userRole);
            $host->assignRole($hoteRole);
        }


        User::factory()->count(10)->create()->each(function ($user) use ($userRole) {
            $user->assignRole($userRole);
        });

        User::factory()->count(10)->create()->each(function ($user) use ($hoteRole) {
            $user->assignRole($hoteRole);
        });
    }
}
