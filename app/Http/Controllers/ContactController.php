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
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'message' => 'required|string',
        ]);

        // Send email to admin
        Mail::to(config('mail.admin_email'))
            ->send(new ContactReceived($validated));

        return redirect()
            ->route('contact.form')
            ->with('success', 'Your message has been sent.');
    }
}
