<?php

namespace App\Http\Controllers;

use App\Mail\NewsletterSubscriptionMail;
use App\Models\NewsletterSubscription;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email',
            'name' => 'nullable|string',
        ]);

        $validatedData['name'] = $validatedData['name'] ?? 'footer_ref';

        try {
            $subscription = NewsletterSubscription::create($validatedData);

        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if($errorCode == 1062){
                return response()->json(['error' => 'Duplicate Entry']);
            }
        }

        Mail::to('sbswag9@gmail.com')->send(new NewsletterSubscriptionMail($subscription));

        return response()->json([
            'message' => 'Subscription created successfully', 
            'status' => "success"
        ]);
    }
}
