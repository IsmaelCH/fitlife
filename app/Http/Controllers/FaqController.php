<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\FaqCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FaqController extends Controller
{
    public function __construct()
    {
        // Public can see index only
        $this->middleware('auth')->except(['index']);
        $this->middleware('can:admin')->except(['index']);
    }

    // PUBLIC FAQ PAGE
    public function index(Request $request)
    {
        // Search in questions and answers
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            
            // Get categories with only matching FAQs
            $categories = FaqCategory::with(['faqs' => function ($q) use ($search) {
                $q->where('question', 'like', '%' . $search . '%')
                  ->orWhere('answer', 'like', '%' . $search . '%');
            }])
            ->whereHas('faqs', function ($q) use ($search) {
                $q->where('question', 'like', '%' . $search . '%')
                  ->orWhere('answer', 'like', '%' . $search . '%');
            })
            ->orderBy('name')
            ->get();
        } else {
            // Show all categories with all FAQs
            $categories = FaqCategory::with('faqs')->orderBy('name')->get();
        }

        return view('faq.index', compact('categories'));
    }

    // ADMIN CRUD (resource)
    public function create()
    {
        $categories = FaqCategory::orderBy('name')->get();
        return view('admin.faqs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'faq_category_id' => 'required|exists:faq_categories,id',
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
        ]);

        Faq::create($validated);

        return redirect()->route('faq.index')->with('success', 'FAQ created.');
    }

    public function show(Faq $faq)
    {
        // not used
        return redirect()->route('faq.index');
    }

    public function edit(Faq $faq)
    {
        $categories = FaqCategory::orderBy('name')->get();
        return view('admin.faqs.edit', compact('faq', 'categories'));
    }

    public function update(Request $request, Faq $faq)
    {
        $validated = $request->validate([
            'faq_category_id' => 'required|exists:faq_categories,id',
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
        ]);

        $faq->update($validated);

        return redirect()->route('faq.index')->with('success', 'FAQ updated.');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();
        return redirect()->route('faq.index')->with('success', 'FAQ deleted.');
    }
}
