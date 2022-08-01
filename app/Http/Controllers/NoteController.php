<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function index()
    {
        return view('note.index');
    }

    public function create(){
        return view('note.create');
    }

    public function edit(Note $note){
        $this->authorize('update', $note);
        return view('note.edit', compact('note'));
    }
}
