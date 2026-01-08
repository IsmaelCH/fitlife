<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            'Fitness',
            'Nutrition',
            'Workout',
            'Health',
            'Training',
            'Cardio',
            'Strength',
            'Weight Loss',
            'Muscle Building',
            'Yoga',
            'Running',
            'Cycling',
            'Wellness',
            'Recovery',
            'Motivation',
        ];

        foreach ($tags as $tag) {
            Tag::firstOrCreate(['name' => $tag]);
        }
    }
}
