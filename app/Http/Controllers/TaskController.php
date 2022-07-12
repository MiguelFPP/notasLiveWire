<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __invoke()
    {
        return view('task.index');
    }
}
