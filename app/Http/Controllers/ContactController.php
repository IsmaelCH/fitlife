<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Mail\ContactReceived;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function showForm()
    {
        return view('contact.form');
    }

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'required|email',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        $contact = Contact::create($validated);

        $adminEmail = config('mail.admin_address', env('ADMIN_EMAIL', 'admin@ehb.be'));
        Mail::to($adminEmail)->send(new ContactReceived($contact));

        return redirect()->route('contact.form')->with('success', 'Message sent.');
    }
}
