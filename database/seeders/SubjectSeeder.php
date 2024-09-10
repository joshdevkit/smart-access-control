<?php

namespace Database\Seeders;

use App\Models\Subjects;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        Subjects::firstOrCreate([
            'subject' => 'Sample Subject 123',
        ]);

        foreach (range(1, 10) as $index) {
            Subjects::firstOrCreate([
                'subject' => $faker->word . ' ' . $faker->numberBetween(100, 999),
            ]);
        }
    }
}
