<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\FaqCategory;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function home()
    {
        $latestNews = News::latest('published_at')->take(3)->get();
        $faqCategories = FaqCategory::with('faqs')->orderBy('name')->get();

        // API fallback for News
        $apiNews = collect();
        if ($latestNews->count() === 0) {
            // Featured gym blog posts for homepage
            $featuredPosts = [
                [
                    'title' => '5 Essential Compound Exercises Every Beginner Should Master',
                    'image' => 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=800&h=600&fit=crop',
                    'author' => 'FitLife Training Team',
                ],
                [
                    'title' => 'The Truth About Rest Days: Why Recovery Matters More Than You Think',
                    'image' => 'https://images.unsplash.com/photo-1540497077202-7c8a3999166f?w=800&h=600&fit=crop',
                    'author' => 'Dr. Sarah Mitchell',
                ],
                [
                    'title' => 'Pre-Workout Nutrition: What to Eat for Maximum Performance',
                    'image' => 'https://images.unsplash.com/photo-1490645935967-10de6ba17061?w=800&h=600&fit=crop',
                    'author' => 'Nutrition Coach Mike Torres',
                ],
            ];

            $apiNews = collect($featuredPosts)
                ->map(function (array $post, $index) {
                    return (object) [
                        'id' => 2000 + $index,
                        'title' => $post['title'],
                        'content' => '',
                        'image_url' => $post['image'],
                        'published_at' => now()->subDays($index + 1),
                        'author' => $post['author'],
                    ];
                })
                ->values();
        }

        // API fallback for FAQ - Gym/Fitness focused
        $apiFaq = collect();
        if ($faqCategories->isEmpty() || $faqCategories->every(fn($cat) => $cat->faqs->isEmpty())) {
            // Static gym-focused FAQ when no DB content
            $apiFaq = collect([
                (object) [
                    'category_name' => 'Getting Started',
                    'question' => 'How often should I go to the gym as a beginner?',
                    'answer' => 'For beginners, 3-4 days per week is ideal. This gives your body time to adapt and recover between sessions. Focus on full-body workouts or an upper/lower split.',
                ],
                (object) [
                    'category_name' => 'Nutrition',
                    'question' => 'How much protein do I need to build muscle?',
                    'answer' => 'Aim for 1.6-2.2 grams of protein per kilogram of body weight daily. For a 70kg person, that\'s about 112-154 grams per day. Spread intake throughout the day for optimal results.',
                ],
                (object) [
                    'category_name' => 'Training',
                    'question' => 'Should I do cardio before or after weights?',
                    'answer' => 'Do weights first if muscle building is your priority. Cardio after weights allows you to lift with maximum energy. If fat loss is the goal, either order works.',
                ],
                (object) [
                    'category_name' => 'Recovery',
                    'question' => 'How important is sleep for muscle growth?',
                    'answer' => 'Sleep is crucial! Aim for 7-9 hours per night. During deep sleep, your body releases growth hormone and repairs muscle tissue. Poor sleep can reduce gains by up to 30%.',
                ],
                (object) [
                    'category_name' => 'Supplements',
                    'question' => 'What supplements should beginners take?',
                    'answer' => 'Start with basics: whey protein (if needed to meet protein goals), creatine monohydrate (5g daily), and a multivitamin. These are proven, safe, and cost-effective.',
                ],
            ]);
        }

        return view('home', compact('latestNews', 'faqCategories', 'apiNews', 'apiFaq'));
    }

    public function dashboard()
    {
        return view('dashboard');
    }
}
