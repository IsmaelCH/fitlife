<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactReply;

class AdminContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::orderByDesc('created_at')->paginate(15);
        return view('admin.contacts.index', compact('contacts'));
    }

    public function show(\App\Models\Contact $contact)
    {
        $contact->load('repliedBy');
        return view('admin.contacts.show', compact('contact'));
    }


    public function reply(Request $request, Contact $contact)
    {
        $validated = $request->validate([
            'reply_message' => 'required|string|max:3000',
        ]);

        Mail::to($contact->email)->send(new ContactReply($contact, $validated['reply_message']));

        $contact->update([
            'reply_message' => $validated['reply_message'],
            'replied_at' => now(),
            'replied_by_user_id' => $request->user()->id,
        ]);

        return redirect()->route('admin.contacts.show', $contact)->with('success', 'Reply sent.');
    }
}
