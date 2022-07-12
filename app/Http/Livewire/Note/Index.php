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

    public function notePinged(Note $note)
    {
        $note->pinged = !$note->pinged;
        $note->save();
    }

    public function render()
    {
        $notes = Note::where('user_id', auth()->id())
            ->orderBy('pinged', 'desc')
            ->orderBy('id', 'desc')
            ->get();
        return view('livewire.note.index', [
            'notes' => $notes
        ]);
    }
}
