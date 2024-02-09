<x-mail::message>
<!-- resources/views/emails/booking/review.blade.php -->

# Interested in event booking

Here are the details for event booking:

- Name: {{ $booking->firstName }} {{ $booking->lastName }}
- Email: {{ $booking->email }}
- Phone: {{ $booking->phone }}
- Event Type: {{ $booking->eventType }}
- Guest Count: {{ $booking->guestCount }}
- Event Date: {{ $booking->eventDate }}
- Event Start Time: {{ $booking->eventStartTime }}

Stay tuned,<br> Thanks,<br>

</x-mail::message>
