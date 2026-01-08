<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FaqCategory;
use App\Models\Faq;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Getting Started' => [
                [
                    'question' => 'How often should I go to the gym as a beginner?',
                    'answer' => 'For beginners, 3-4 days per week is ideal. This gives your body time to adapt and recover between sessions. Focus on full-body workouts or an upper/lower split to build a solid foundation.',
                ],
                [
                    'question' => 'What should I do on my first day at the gym?',
                    'answer' => 'Start with a tour of the facility, learn how to use basic equipment safely, and do a light full-body workout. Focus on form over weight. Consider hiring a trainer for 1-2 sessions to learn proper technique.',
                ],
            ],
            'Nutrition' => [
                [
                    'question' => 'How much protein do I need to build muscle?',
                    'answer' => 'Aim for 1.6-2.2 grams of protein per kilogram of body weight daily. For a 70kg person, that\'s about 112-154 grams per day. Spread protein intake throughout the day for optimal muscle protein synthesis.',
                ],
                [
                    'question' => 'Should I eat before or after working out?',
                    'answer' => 'Both! Eat a balanced meal 2-3 hours before training for energy. After training, consume protein and carbs within 2 hours to support recovery and muscle growth. The post-workout "anabolic window" is flexible.',
                ],
            ],
            'Training' => [
                [
                    'question' => 'Should I do cardio before or after weights?',
                    'answer' => 'Do weights first if muscle building is your priority. Cardio after weights allows you to lift with maximum energy and strength. If fat loss is the main goal, either order works effectively.',
                ],
                [
                    'question' => 'How long should my workouts be?',
                    'answer' => '45-75 minutes is optimal for most people. This includes warm-up and cool-down. Quality beats quantity—focused, intense 45-minute sessions often beat unfocused 2-hour sessions.',
                ],
            ],
            'Recovery' => [
                [
                    'question' => 'How important is sleep for muscle growth?',
                    'answer' => 'Sleep is crucial! Aim for 7-9 hours per night. During deep sleep, your body releases growth hormone and repairs muscle tissue. Poor sleep can reduce muscle gains by up to 30% and increase injury risk.',
                ],
                [
                    'question' => 'How long should I rest between sets?',
                    'answer' => 'For strength: 3-5 minutes. For hypertrophy (muscle growth): 60-90 seconds. For endurance: 30-60 seconds. Rest enough to maintain quality reps but not so long you get cold.',
                ],
            ],
            'Supplements' => [
                [
                    'question' => 'What supplements should beginners take?',
                    'answer' => 'Start with basics: whey protein (if needed to meet protein goals), creatine monohydrate (5g daily), and a quality multivitamin. These three are scientifically proven, safe, and cost-effective.',
                ],
            ],
            'Fat Loss' => [
                [
                    'question' => 'How do I lose fat while maintaining muscle?',
                    'answer' => 'Create a moderate calorie deficit (300-500 calories), keep protein high (2g per kg), continue strength training, and don\'t cut calories too drastically. Aim to lose 0.5-1% of body weight per week.',
                ],
            ],
        ];

        foreach ($categories as $categoryName => $faqs) {
            $category = FaqCategory::firstOrCreate(['name' => $categoryName]);
            
            foreach ($faqs as $faq) {
                Faq::firstOrCreate(
                    [
                        'faq_category_id' => $category->id,
                        'question' => $faq['question']
                    ],
                    [
                        'answer' => $faq['answer']
                    ]
                );
            }
        }
    }
}
