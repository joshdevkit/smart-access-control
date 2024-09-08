<?php

namespace Database\Seeders;

use App\Models\Section;
use App\Models\User;
use App\Models\Year;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $subjects = \App\Models\Subjects::pluck('id')->toArray();
        $years = Year::pluck('id')->toArray();
        $sections = Section::pluck('id')->toArray();
        $courses = ['Course 1', 'Course 2', 'Course 3', 'Course 4'];
        $sexes = ['Male', 'Female'];

        for ($i = 1; $i <= 20; $i++) {
            $firstName = $faker->firstName;
            $lastName = $faker->lastName;
            $username = 'C' . strtoupper(substr($firstName, 0, 1)) . strtoupper(substr($lastName, 0, 1)) . '0' . str_pad($i, 4, '0', STR_PAD_LEFT);

            $user = User::create([
                'student_no' => 'S' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'name' => $firstName . ' ' . $lastName,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password'),
                'sex' => $faker->randomElement($sexes),
                'course_year_section' => $faker->randomElement($courses),
                'username' => $username,
            ]);

            $user->syncRoles('Student');

            $randomSubjects = $faker->randomElements($subjects, $faker->numberBetween(1, 5));
            foreach ($randomSubjects as $subjectId) {
                \App\Models\StudentSubjects::create([
                    'student_id' => $user->id,
                    'subject_id' => $subjectId,
                ]);
            }

            \App\Models\StudentYearAndSection::create([
                'student_id' => $user->id,
                'year_id' => $faker->randomElement($years),
                'section_id' => $faker->randomElement($sections),
            ]);
        }
    }
}
