<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\News;
use App\Models\FaqCategory;
use App\Models\Faq;

class DemoContentSeeder extends Seeder
{
    public function run(): void
    {
        // Buscar admin
        $admin = User::where('email', 'admin@ehb.be')->first();

        // --- NEWS DEMO ---
        if ($admin && News::count() === 0) {
            News::create([
                'user_id' => $admin->id,
                'title' => 'Welcome to FitLife',
                'content' => 'This is a demo news item. Admins can create, edit and delete news.',
                'published_at' => now(),
            ]);

            News::create([
                'user_id' => $admin->id,
                'title' => 'Training tip',
                'content' => 'Consistency is more important than intensity.',
                'published_at' => now()->subDays(1),
            ]);
        }

        // --- FAQ DEMO ---
        if (FaqCategory::count() === 0) {
            $account = FaqCategory::create(['name' => 'Account']);
            $training = FaqCategory::create(['name' => 'Training']);

            Faq::create([
                'faq_category_id' => $account->id,
                'question' => 'How do I reset my password?',
                'answer' => 'Go to login and click on "Forgot password".',
            ]);

            Faq::create([
                'faq_category_id' => $training->id,
                'question' => 'Do I need a gym?',
                'answer' => 'No, you can start with home workouts.',
            ]);
        }
    }
}
