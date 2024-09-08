<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'Administrator']);
        $facultyRole = Role::firstOrCreate(['name' => 'Faculty']);
        $studentRole = Role::firstOrCreate(['name' => 'Student']);
        $adminUsername = 'A' . str_pad(User::where('username', 'like', 'A%')->count() + 1, 6, '0', STR_PAD_LEFT);
        $facultyUsername = 'B' . str_pad(User::where('username', 'like', 'B%')->count() + 1, 6, '0', STR_PAD_LEFT);
        $studentUsername = 'C' . str_pad(User::where('username', 'like', 'C%')->count() + 1, 6, '0', STR_PAD_LEFT);

        $admin = User::firstOrCreate([
            'email' => 'admin@example.com',
        ], [
            'name' => 'Admin User',
            'username' => $adminUsername,
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole($adminRole);

        // Create Faculty User
        $faculty = User::firstOrCreate([
            'email' => 'faculty@example.com',
        ], [
            'name' => 'Faculty User',
            'username' => $facultyUsername,
            'password' => Hash::make('password'),
        ]);
        $faculty->assignRole($facultyRole);

        // Create Student User
        $student = User::firstOrCreate([
            'email' => 'student@example.com',
        ], [
            'name' => 'Student User',
            'username' => $studentUsername,
            'password' => Hash::make('password'),
        ]);
        $student->assignRole($studentRole);
    }
}
