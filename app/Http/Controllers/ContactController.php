<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactReceived;

class ContactController extends Controller
{
    // Show contact form (public)
    public function showForm()
    {
        return view('contact.form');
    }

    // Handle form submit
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'required|email',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        // Save in DB
        $contact = \App\Models\Contact::create($validated);

        // Email to admin
        \Illuminate\Support\Facades\Mail::to(config('mail.admin_email'))
            ->send(new \App\Mail\ContactReceived($validated));

        return redirect()
            ->route('contact.form')
            ->with('success', 'Your message has been sent.');
    }
}
