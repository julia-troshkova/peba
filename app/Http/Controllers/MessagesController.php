<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Messages;
class MessagesController extends Controller
{
    public function showChat(){
        $senderUser = auth()->user()->getAuthIdentifier();
        $recipientUser = 1;
        $messages = Messages::where('sender_id', $senderUser)->orWhere('recipient_id', $recipientUser);
        return view('pages.messages', ['messages'=>$messages]);
    }

    public function saveMessage(Request $request){
        $msg = $request->msg;
        $senderUser = auth()->user()->getAuthIdentifier();
        $recipientUser = 1;
        $message = new Messages();
        $message->sender_id = $senderUser;
        $message->recipient_id = $recipientUser;
        $message->msg = $msg;
        $message->save();
        return redirect()->intended('/messages');
    }

}
