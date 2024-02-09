<x-mail::message>
<!-- resources/views/emails/sponsorship/review.blade.php -->

# Interested in Sponsorship 

Here is your sponsorship details:

- Name: {{ $sponsorship->name }}
- Email: {{ $sponsorship->email }}
- Phone: {{ $sponsorship->phone }}
- Company: {{ $sponsorship->company }}
- Info: {{ $sponsorship->info }}

Stay tuned, ,<br>Thanks,<br>

</x-mail::message>
