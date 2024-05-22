<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\MessageSent;
use App\Models\User;
use App\Models\Message;

class ChatController extends Controller
{
    public function index(Request $request)
    {
      $user_id = $request->user_id;
        $receiver = User::find($user_id);
        $messages = $receiver ? Message::where(function ($query) use ($user_id) {
            $query->where('sender_id', auth()->id())
                  ->orWhere('receiver_id', auth()->id());
        })->where(function ($query) use ($user_id) {
            $query->where('sender_id', $user_id)
                  ->orWhere('receiver_id', $user_id);
        })->get() : collect();

        $users = User::where('id', '!=', auth()->id())->get();
        
        return view('chatting.index', compact('messages', 'users', 'receiver'));
    }
    // public function fetchMessages($user_id)
    // {
    //     $messages = Message::where(function($query) use ($user_id) {
    //         $query->where('sender_id', Auth::id())
    //               ->where('receiver_id', $user_id);
    //     })->orWhere(function($query) use ($user_id) {
    //         $query->where('sender_id', $user_id)
    //               ->where('receiver_id', Auth::id());
    //     })->get();

    //     return response()->json($messages);
    // }
    public function sendMessage(Request $request)
    {
      $request->validate([
        'message' => 'required|string|max:255',
        'receiver_id' => 'required|integer|exists:users,id'
    ]);
      $message = $request->message;
      $receiver_id = $request->receiver_id;

      $newMessage = Message::create([
          'sender_id' => auth()->id(),
          'receiver_id' => $receiver_id,
          'message' => $message,
      ]);

      broadcast(new MessageSent($message))->toOthers();

      return response()->json(['message' => $message]);
    

    }
    public function Receive(Request $request)
    {
        return "hello";
        return view('chatting/receive', ['message' => $request->get('message')]);
      }
}
