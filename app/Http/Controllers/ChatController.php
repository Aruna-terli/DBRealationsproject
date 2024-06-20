<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\MessageSent;
use App\Models\User;
use App\Models\Message;
use App\Models\Group;
use App\Models\GroupMessages;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
  public function index(Request $request)
  {
    $user_id = $request->user_id;
   $user_name = @$request->user_name;
      $receiver = User::find($user_id);
      $messages = $receiver ? Message::where(function ($query) use ($user_id) {
          $query->where('sender_id', auth()->id())
                ->orWhere('receiver_id', auth()->id());
      })->where(function ($query) use ($user_id) {
          $query->where('sender_id', $user_id)
                ->orWhere('receiver_id', $user_id);
      })->get() : collect();
    
 

      if ($receiver) {
          $update_unread = Message::where('sender_id', $user_id)
                                  ->where('is_read','0')
                                  ->update(['is_read' => '1']);
      
       
       
      }
   
  //   $message_count =  Message::where(function ($query)  {
  //     $query->where('receiver_id', auth()->id())->where('is_read','=','0');
    
  // })->count();
  //   $sender_id = Message::where('is_read','=','0')->select('sender_id')->get();


$sender_ids = Message::where('is_read', '0')
                     ->where('receiver_id', auth()->id())
                     ->select('sender_id')
                     ->get()
                     ->pluck('sender_id')
                     ->unique();
 $users = User::where('id', '!=', auth()->id())->get();

 foreach ($sender_ids as $sender_id) {
        foreach($users as $key=>$user)
                      {
                     
                      if($user->id == $sender_id)
                      {
                      $user->count = Message::where('is_read', '0')
                             ->where('receiver_id', auth()->id())
                             ->where('sender_id', $sender_id)
                           
                            ->count();

                             break;  
                      }
                      else {
                        $user->count = 0;
                      }
                     }
                    }
             
    
      $groups = Group::get();
      
      return view('chatting.index', compact('messages','users', 'receiver','groups','user_name'));
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
      $message['name'] = auth()->user()->name;
     

      $newMessage = Message::create([
        
          'sender_id' => auth()->id(),
          
         'receiver_id' => $message['receiver_id'],
          'message' => $message['message'],
          'is_read'=>0,
      ]);
      broadcast(new MessageSent($message))->toOthers();

      return response()->json(['message' => $message]);
    

    }
    public function show(Request $request)
    {
      $group_id = $request->group_id;
      $group_name = $request->group_name;
      $users = User::where('id', '!=', auth()->id())->get();
      $groups = Group::get();
      $group_messages =  GroupMessages::get();
    
      foreach ($groups as $group){
        $i= 0;
        foreach($group_messages as $message)
        { 
          
         if($message->group_id == $group->id && $message->is_read == "0")
          {
           
            $i = $i+1;
           
          }
        
        }
       $group->count = $i;
      }
      if ($group_id) {
        $update_unread = GroupMessages::where('group_id', $group_id)
                                ->where('is_read','0')
                                ->update(['is_read' => '1']);
    
     
     
    }
      $messages = GroupMessages::where('group_id', $group_id)->orderBy('created_at', 'asc')->get();
      
      return view('chatting/groups/showgroups', compact('messages', 'users','groups','group_id','group_name'));
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
          'name'=> $message['name'],
        
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
