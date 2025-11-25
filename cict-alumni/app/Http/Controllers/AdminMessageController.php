<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminMessageController extends Controller
{
    public function index()
    {
        return view('admin.messages.index'); // create this view if needed
    }
}
