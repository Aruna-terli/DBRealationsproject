<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\MessageSent;
use App\Models\User;
use App\Models\Message;
use App\Models\Group;
use App\Models\GroupMessages;

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
      $groups = Group::get();
      
      return view('chatting.index', compact('messages', 'users', 'receiver','groups'));
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
      $message['message'] = $request->message;
      $message['receiver_id' ]= $request->receiver_id;
      $message['sender_id'] = auth()->id();

      $newMessage = Message::create([
        
          'sender_id' => auth()->id(),
          
         'receiver_id' => $message['receiver_id'],
          'message' => $message['message'],
      ]);
      broadcast(new MessageSent($message))->toOthers();

      return response()->json(['message' => $message]);
    

    }
    public function show(Request $request)
    {
      $group_id = $request->group_id;
      $users = User::where('id', '!=', auth()->id())->get();
      $groups = Group::get();
      $messages = GroupMessages::where('group_id', $group_id)->orderBy('created_at', 'asc')->get();
      
      return view('chatting/groups/showgroups', compact('messages', 'users','groups','group_id'));
    }
    public function sendGroupMessage(Request $request)
    {
    
      // try{
      $request->validate([
        'message' => 'required|string|max:255',
  
        'name'=>'required',
        'group_id'=>'required'
    ]);
      $message['message'] = $request['message'];
    
      $message['name']= $request['name'];
      $message['sender_id'] = auth()->id();
      $message['receiver_id'] = $request['group_id'];

      $newMessage = GroupMessages::create([
          
          'user_id' => auth()->id(),
          'group_id'=>$message['receiver_id'],
          'name'=> $message['sender_id'],
          'from'=>auth()->user()->name,
          'is_read'=>0,
        
          'message' => $message['message'],
      ]);

      broadcast(new MessageSent($message))->toOthers();

      return response()->json(['message' => $message], 200);
    // } catch (\Exception $e) {
    //     return response()->json(['error'=>'error unable to create']);
    // }
    

    }
}
