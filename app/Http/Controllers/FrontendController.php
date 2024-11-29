<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    function subscribeNewsletter(Request $request) : Response
    {
        $request->validate([
            'email' => ['required', 'email', 'max:255', 'unique:subscribers,email']
        ],
            ['email.unique' => 'Email is already subscribed!']);

        $subscriber = new Subscriber();
        $subscriber->email = $request->email;
        $subscriber->save();

        return response(['status' => 'success', 'message' => 'Subscribed Successfully!']);
    }
}
