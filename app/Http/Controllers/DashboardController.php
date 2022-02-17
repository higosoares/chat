<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $users = User::with(['sentMessages' => function($query) use ($request) {
            $query->where('is_read', '=', 0)->where('receiver_id', '=', $request->user()->id);
        }])
        ->where('id', '!=', $request->user()->id)
        ->get();

        return view('dashboard', compact('users'));
    }

    public function create(Request $request)
    {
        $message = new Message();
        $message->sender_id = $request->user()->id;
        $message->receiver_id = $request->input('receiver_id');
        $message->text = $request->input('text');
        $message->is_read = false;
        $message->save();

        return response()->json($message->only('id'), 201);
    }

    public function get(Request $request, User $user)
    {
        Message::where(['sender_id' => $user->id, 'receiver_id' => $request->user()->id])
        ->update(['is_read' => true]);

        $messages = Message::where(['sender_id' => $user->id, 'receiver_id' => $request->user()->id])
        ->orWhere('sender_id', '=', $request->user()->id)
        ->where('receiver_id', '=', $user->id)
        ->get();

        return response()->json(['messages' => $messages], 200);
    }
}
