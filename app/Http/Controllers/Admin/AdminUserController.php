<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index()
    {
        return User::where('role', 'user')->latest()->get();
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();

        return response()->json([
            'message' => 'User deleted'
        ]);
    }

    public function countUser()
    {
        $totalUsers = User::where('role', 'user')->count();

        return response()->json([
            'total_users' => $totalUsers
        ]);
    }
}
