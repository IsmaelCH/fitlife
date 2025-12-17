<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\FaqCategory;

class PageController extends Controller
{
    public function home()
    {
        $latestNews = News::latest('published_at')->take(3)->get();
        $faqCategories = FaqCategory::with('faqs')->orderBy('name')->get();

        return view('home', compact('latestNews', 'faqCategories'));
    }

    public function dashboard()
    {
        return view('dashboard');
    }
}
