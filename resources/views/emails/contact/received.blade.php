@component('mail::message')
    # New Contact Message

    **Name:** {{ $contact->name ?? 'N/A' }}
    **Email:** {{ $contact->email }}
    **Subject:** {{ $contact->subject ?? 'N/A' }}

    **Message:**

    {{ $contact->message }}

@endcomponent
