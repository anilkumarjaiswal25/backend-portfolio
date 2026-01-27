<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class AdminMessageController extends Controller
{

    public function index()
    {
        return Message::latest()->get();
    }

    public function show($id)
    {
        return Message::findOrFail($id);
    }

    public function destroy($id)
    {
        Message::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Deleted successfully'
        ]);
    }
}
