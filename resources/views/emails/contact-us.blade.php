<x-mail::message>
# New Contact Inquiry

You have received a new message from the Zeraay landing page contact form.

**Name:** {{ $name }}<br>
**Email:** {{ $email }}

**Message:**
<x-mail::panel>
{{ $message }}
</x-mail::panel>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
