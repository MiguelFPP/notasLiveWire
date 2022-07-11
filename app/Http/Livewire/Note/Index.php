<?php

namespace App\Http\Livewire\Note;

use App\Models\Note;
use App\Models\Image;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;

class Index extends Component
{
    protected $listeners = [
        'deleteNote' => 'deleteNote',
    ];

    public function deleteNote(Note $note)
    {
        $images = Image::where('imageable_id', $note->id)->get();
        foreach ($images as $image) {
            Storage::delete('public/' . $image->path);
            $image->delete();
        }
        $note->delete();
    }

    public function render()
    {
        $notes = Note::where('user_id', auth()->id())->get();
        return view('livewire.note.index', [
            'notes' => $notes
        ]);
    }
}
