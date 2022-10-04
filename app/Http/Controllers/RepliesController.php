<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Thread $thread, Request $request)
    {
        $thread->addReply([
           'body' =>  $request->body,
           'user_id' => Auth::id()
        ]);

        return back();
    }
}
