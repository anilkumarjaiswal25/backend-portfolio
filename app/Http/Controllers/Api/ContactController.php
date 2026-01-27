<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class ContactController extends Controller
{
   public function store(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'email' => 'required|email',
            'subject' => 'required'
        ]);

        Message::create($request->all());

        return response()->json([
            'message' => 'Message sent successfully'
        ]);
    }
}
