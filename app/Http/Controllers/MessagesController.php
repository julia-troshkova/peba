<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Messages;
class MessagesController extends Controller
{
    public function showChat(){
        return view('pages.messages');
    }
}
