<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function __construct()
    {
        // Public can see index + show
        // Admin only for create/edit/delete
        $this->middleware('auth')->except(['index', 'show']);
        $this->middleware('can:admin')->except(['index', 'show']);
    }

    // PUBLIC: list
    public function index()
    {
        $news = News::with('user')
            ->orderByDesc('published_at')
            ->paginate(10);

        $apiNews = collect();
        if ($news->count() === 0) {
            // Realistic gym/fitness blog posts with curated content
            $gymPosts = [
                [
                    'title' => '5 Essential Compound Exercises Every Beginner Should Master',
                    'content' => "Starting your fitness journey can be overwhelming, but mastering these five compound exercises will set you up for success. Squats, deadlifts, bench press, overhead press, and rows form the foundation of any solid training program. These movements engage multiple muscle groups simultaneously, maximizing your time in the gym and promoting functional strength.\n\nCompound exercises not only build muscle mass more efficiently than isolation exercises, but they also improve coordination, burn more calories, and increase your metabolic rate. Focus on perfecting your form with lighter weights before progressing to heavier loads.\n\nRemember: consistency beats intensity. Start with 3 sets of 8-12 reps for each exercise, and gradually increase the weight as you become more comfortable with the movements.",
                    'image' => 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=800&h=600&fit=crop',
                    'author' => 'FitLife Training Team',
                ],
                [
                    'title' => 'The Truth About Rest Days: Why Recovery Matters More Than You Think',
                    'content' => "Many gym enthusiasts believe that more training equals better results, but this couldn't be further from the truth. Rest days are when your muscles actually grow and repair themselves. During intense workouts, you create micro-tears in muscle fibers. It's during rest that your body repairs these tears, making the muscles stronger and larger.\n\nWithout adequate recovery, you risk overtraining syndrome, which can lead to decreased performance, increased injury risk, and even hormonal imbalances. Aim for at least 1-2 full rest days per week, and don't be afraid to take an extra day if your body is telling you it needs it.\n\nActive recovery, like light walking, yoga, or swimming, can also be beneficial on rest days to promote blood flow without overtaxing your system.",
                    'image' => 'https://images.unsplash.com/photo-1540497077202-7c8a3999166f?w=800&h=600&fit=crop',
                    'author' => 'Dr. Sarah Mitchell',
                ],
                [
                    'title' => 'Pre-Workout Nutrition: What to Eat for Maximum Performance',
                    'content' => "Your pre-workout meal can make or break your training session. The right combination of nutrients provides energy, prevents muscle breakdown, and sets the stage for optimal performance. Aim to eat a balanced meal 2-3 hours before training, containing complex carbohydrates, lean protein, and a small amount of healthy fats.\n\nGood pre-workout meal examples include: oatmeal with banana and almond butter, chicken breast with sweet potato and vegetables, or Greek yogurt with berries and granola. If you're training early morning or can't eat a full meal, a piece of fruit with a protein shake 30-45 minutes before works great.\n\nHydration is equally important. Drink 16-20 ounces of water 2-3 hours before exercise, and another 8-10 ounces 15-20 minutes before starting. This ensures you're properly hydrated without feeling bloated during your workout.",
                    'image' => 'https://images.unsplash.com/photo-1490645935967-10de6ba17061?w=800&h=600&fit=crop',
                    'author' => 'Nutrition Coach Mike Torres',
                ],
                [
                    'title' => 'Breaking Through Plateaus: Advanced Techniques for Continued Progress',
                    'content' => "Hit a plateau in your training? Don't worry, it happens to everyone. When your body adapts to your current routine, progress stalls. The key is to introduce new stimuli to shock your muscles into growth. Progressive overload is fundamental—gradually increase weight, reps, or sets over time.\n\nTry implementing these proven plateau-busting techniques: deload weeks (reduce volume by 40-50% every 6-8 weeks), tempo training (slow down the eccentric phase), drop sets, or changing your rep ranges. Even something as simple as switching from barbell to dumbbell exercises can provide a new stimulus.\n\nDon't forget to assess your nutrition and sleep. Sometimes plateaus aren't about training at all—they're about inadequate recovery or insufficient calories to support muscle growth. Track your food intake for a week and ensure you're eating enough protein and overall calories.",
                    'image' => 'https://images.unsplash.com/photo-1571019614242-c5c5dee9f50b?w=800&h=600&fit=crop',
                    'author' => 'Coach James Rodriguez',
                ],
                [
                    'title' => 'Building a Home Gym on a Budget: Essential Equipment Guide',
                    'content' => "You don't need expensive equipment to build an effective home gym. With just a few key pieces, you can create a versatile training space that rivals commercial gyms. Start with the basics: a quality set of adjustable dumbbells (5-50 lbs), a flat/adjustable bench, and a pull-up bar. These three items alone allow for hundreds of exercise variations.\n\nAs your budget allows, add resistance bands, a barbell with weight plates, and a squat rack. Resistance bands are incredibly versatile and cost-effective, perfect for warm-ups, assistance work, or adding variable resistance. A simple barbell setup opens up the world of compound lifts.\n\nDon't overlook the power of bodyweight training. Push-ups, dips, pull-ups, and various core exercises require zero equipment and deliver excellent results. A good gym mat and some discipline is all you really need to start your fitness journey. Remember: consistency and effort matter far more than fancy equipment.",
                    'image' => 'https://images.unsplash.com/photo-1517836357463-d25dfeac3438?w=800&h=600&fit=crop',
                    'author' => 'FitLife Equipment Expert',
                ],
                [
                    'title' => 'Understanding Progressive Overload: The Science of Getting Stronger',
                    'content' => "Progressive overload is the single most important principle for building muscle and strength. Simply put, you must continually challenge your muscles with increasing demands to force adaptation. This doesn't always mean adding more weight—you can also increase reps, sets, training frequency, or decrease rest periods.\n\nThe key is gradual progression. Trying to add too much weight too quickly leads to injury and poor form. A good rule of thumb: increase weight by 2.5-5% when you can complete all prescribed sets and reps with good form. For example, if you're squatting 100 lbs for 3 sets of 10, try 105 lbs next session.\n\nKeep a training log to track your progress. Write down exercises, weights, sets, and reps for every workout. This objective data helps you identify when it's time to increase the challenge and ensures you're actually progressing, not just spinning your wheels in the gym.",
                    'image' => 'https://images.unsplash.com/photo-1581009146145-b5ef050c2e1e?w=800&h=600&fit=crop',
                    'author' => 'Strength Coach Alex Chen',
                ],
                [
                    'title' => 'Muscle Recovery: The Best Post-Workout Strategies',
                    'content' => "What you do after your workout is just as important as the workout itself. Proper recovery strategies can significantly reduce soreness, speed up muscle repair, and improve your next training session. Start with a proper cool-down: 5-10 minutes of light cardio and static stretching helps remove metabolic waste and reduces muscle tension.\n\nNutrition timing matters. Consume a combination of protein and carbohydrates within 2 hours post-workout. Aim for 20-40 grams of protein and 40-80 grams of carbs depending on your body size and training intensity. A chicken breast with rice, protein shake with banana, or Greek yogurt with granola all work excellently.\n\nOther recovery tools include foam rolling (helps break up adhesions and improve blood flow), adequate sleep (7-9 hours for optimal hormone production), and active recovery days. Ice baths and contrast showers can help reduce inflammation, though the research is mixed. Find what works for your body and stay consistent with it.",
                    'image' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=800&h=600&fit=crop',
                    'author' => 'Recovery Specialist Lisa Wang',
                ],
                [
                    'title' => 'Common Gym Mistakes That Are Sabotaging Your Progress',
                    'content' => "Even experienced lifters make mistakes that limit their results. The most common error? Ego lifting—using weights that are too heavy with poor form. This not only increases injury risk but also reduces muscle activation because you're relying on momentum instead of muscle contraction.\n\nAnother major mistake is neglecting certain muscle groups. Many people focus heavily on chest and arms while ignoring back, legs, and posterior chain. This creates muscle imbalances that can lead to posture problems and injuries. A balanced program works all major muscle groups equally.\n\nInconsistency kills progress. Hitting the gym hard for two weeks then disappearing for a month doesn't work. Your body needs regular, consistent stimulus to adapt. It's better to train moderately 3-4 times per week year-round than to go all-out for short bursts. Also, stop program hopping—stick with a solid routine for at least 8-12 weeks before switching.",
                    'image' => 'https://images.unsplash.com/photo-1584735935682-2f2b69dff9d2?w=800&h=600&fit=crop',
                    'author' => 'Personal Trainer Marcus Johnson',
                ],
                [
                    'title' => 'HIIT vs Steady-State Cardio: Which is Better for Fat Loss?',
                    'content' => "The debate between High-Intensity Interval Training (HIIT) and steady-state cardio continues, but the truth is both have their place in a well-rounded fitness program. HIIT burns more calories in less time and creates an 'afterburn effect' (EPOC) where you continue burning calories post-workout. It's excellent for preserving muscle mass while cutting fat.\n\nSteady-state cardio, like jogging or cycling at a moderate pace, is easier to recover from and can be done more frequently. It's particularly good for beginners or those with joint issues. Plus, it directly improves cardiovascular health and endurance.\n\nThe best approach? Combine both. Do 2-3 HIIT sessions per week (20-30 minutes each) and 2-3 steady-state sessions (30-45 minutes). This provides the metabolic benefits of HIIT while building the aerobic base from steady-state work. Remember: the best cardio is the one you'll actually do consistently. If you hate one style, focus on the other.",
                    'image' => 'https://images.unsplash.com/photo-1476480862126-209bfaa8edc8?w=800&h=600&fit=crop',
                    'author' => 'Cardio Coach Emma Davis',
                ],
                [
                    'title' => 'The Complete Guide to Gym Etiquette: Be a Respectful Lifter',
                    'content' => "Good gym etiquette makes the training environment better for everyone. First rule: always re-rack your weights. Nothing is more frustrating than finding dumbbells scattered everywhere or a loaded barbell left on a squat rack. It's disrespectful and potentially dangerous.\n\nRespect personal space and don't hog equipment. If someone is waiting for a machine or rack you're using, offer to let them work in between your sets. Limit phone use—nobody wants to wait while you scroll social media between sets. Keep rest periods reasonable, especially during peak hours.\n\nWipe down equipment after use. Your sweat is gross to others, even if it doesn't bother you. Don't offer unsolicited advice unless someone is doing something dangerous. Keep noise to a reasonable level—grunting during a max lift is fine, but screaming during every rep of bicep curls is excessive.\n\nFinally, put your ego aside. Don't judge others for their fitness level, and don't show off or try to intimidate. The gym is for everyone, from total beginners to advanced athletes. Creating a welcoming environment benefits the entire fitness community.",
                    'image' => 'https://images.unsplash.com/photo-1599058917212-d750089bc07e?w=800&h=600&fit=crop',
                    'author' => 'FitLife Community Team',
                ],
            ];

            $apiNews = collect($gymPosts)
                ->shuffle()
                ->take(10)
                ->map(function (array $post, $index) {
                    return (object) [
                        'id' => 1000 + $index,
                        'title' => $post['title'],
                        'content' => $post['content'],
                        'image_url' => $post['image'],
                        'published_at' => now()->subDays(rand(1, 30)),
                        'source_url' => null,
                        'author' => $post['author'],
                    ];
                })
                ->sortByDesc('published_at')
                ->values();
        }

        return view('news.index', compact('news', 'apiNews'));
    }

    // PUBLIC: detail
    public function show(News $news)
    {
        $news->load(['user', 'comments.user']);
        return view('news.show', compact('news'));
    }


    // ADMIN: create form
    public function create()
    {
        return view('news.create');
    }

    // ADMIN: store
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'published_at' => 'nullable|date',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = [
            'user_id' => $request->user()->id,
            'title' => $validated['title'],
            'content' => $validated['content'],
            'published_at' => $validated['published_at'] ?? now(),
        ];

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('news', 'public');
        }

        $news = News::create($data);

        return redirect()->route('news.show', $news)->with('success', 'News created.');
    }

    // ADMIN: edit form
    public function edit(News $news)
    {
        return view('news.edit', compact('news'));
    }

    // ADMIN: update
    public function update(Request $request, News $news)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'published_at' => 'nullable|date',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = [
            'title' => $validated['title'],
            'content' => $validated['content'],
            'published_at' => $validated['published_at'] ?? $news->published_at,
        ];

        if ($request->hasFile('image')) {
            if ($news->image_path) {
                Storage::disk('public')->delete($news->image_path);
            }
            $data['image_path'] = $request->file('image')->store('news', 'public');
        }

        $news->update($data);

        return redirect()->route('news.show', $news)->with('success', 'News updated.');
    }

    // ADMIN: delete
    public function destroy(News $news)
    {
        if ($news->image_path) {
            Storage::disk('public')->delete($news->image_path);
        }

        $news->delete();

        return redirect()->route('news.index')->with('success', 'News deleted.');
    }
}
