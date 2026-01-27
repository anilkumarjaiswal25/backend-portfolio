<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function stats()
    {
        return response()->json([
            'users' => User::where('role', 'user')->count(),
            'messages' => Message::count(),
            'projects' => 8 // agar DB nahi hai to static
        ]);
    }
}
