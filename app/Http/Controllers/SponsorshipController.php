<?php

namespace App\Http\Controllers;

use App\Mail\SponsorshipReviewMail;
use App\Models\Sponsorship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SponsorshipController extends Controller
{
    public function store(Request $request)
{
    $recaptcha_response = $request->input('g-recaptcha-response');
        $recaptcha_secret = env('RECAPTCHA_SECRET'); // Replace with your Secret Key

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,"https://www.google.com/recaptcha/api/siteverify");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('secret' => $recaptcha_secret, 'response' => $recaptcha_response)));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $recaptcha = curl_exec($ch);

        if ($recaptcha === FALSE) {
            echo 'cURL error: ' . curl_error($ch);
        }

        curl_close ($ch);

        $recaptcha = json_decode($recaptcha);
        if ($recaptcha !== NULL && $recaptcha->success==true && $recaptcha->score >= 0.5) {
        // Verified! Save the subscription.
        $validatedData = $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'company' => 'nullable',
            'email' => 'required|email',
            'info' => 'required',
        ]);
    

        $sponsorship = Sponsorship::create($validatedData);
        Mail::to('sbswag9@gmail.com')->send(new SponsorshipReviewMail($sponsorship));

        return response()->json([
            'message' => 'Sponsorship created successfully', 
            'status' => "success"
        ]);
    }
    else
    {
        return response()->json([
            'message' => 'Failed reCAPTCHA verification', 
            'status' => "error",
            'errors' => $recaptcha !== NULL ? $recaptcha->{"error-codes"} : []
        ]);
    }
}
}
