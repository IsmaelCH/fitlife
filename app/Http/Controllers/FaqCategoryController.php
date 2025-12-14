<?php

namespace App\Http\Controllers;

use App\Models\FaqCategory;
use Illuminate\Http\Request;

class FaqCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:admin');
    }

    public function index()
    {
        $categories = FaqCategory::orderBy('name')->paginate(20);
        return view('admin.faq_categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.faq_categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
        ]);

        FaqCategory::create($validated);

        return redirect()->route('faq-categories.index')->with('success', 'Category created.');
    }

    public function show(FaqCategory $faqCategory)
    {
        return redirect()->route('faq-categories.index');
    }

    public function edit(FaqCategory $faqCategory)
    {
        return view('admin.faq_categories.edit', compact('faqCategory'));
    }

    public function update(Request $request, FaqCategory $faqCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
        ]);

        $faqCategory->update($validated);

        return redirect()->route('faq-categories.index')->with('success', 'Category updated.');
    }

    public function destroy(FaqCategory $faqCategory)
    {
        $faqCategory->delete();

        return redirect()->route('faq-categories.index')->with('success', 'Category deleted.');
    }
}
