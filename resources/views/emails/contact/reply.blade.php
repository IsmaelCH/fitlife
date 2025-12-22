<h2>FitLife - Reply</h2>

<p>Hi {{ $contact->name ?? 'there' }},</p>

<p>{{ $replyMessage }}</p>

<hr>
<p><strong>Your original message:</strong></p>
<p><strong>Subject:</strong> {{ $contact->subject ?? '-' }}</p>
<p>{{ $contact->message }}</p>
