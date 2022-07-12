<?php

namespace App\Http\Livewire\Note;

use App\Models\Note;
use App\Models\Image;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;

class Edit extends Component
{
    public $note;
    public $title;
    public $content;
    public $images = [];

    public function mount(Note $note)
    {
        $this->title = $note->title;
        $this->content = $note->content;
        /* toma el pack de las imagenes y lo inserta en el array */
        $this->images = $note->images->pluck('path')->toArray();
    }

    public function addImage($image)
    {
        $this->images[] = $image;
    }

    public function save()
    {
        $this->note->update([
            'title' => $this->title,
            'content' => $this->content,
        ]);

        foreach ($this->images as $image) {
            $img = Image::where('path', $image)->first();

            if (strpos($this->note->content, $image)) {
                $img->update([
                    'imageable_id' => $this->note->id,
                    'imageable_type' => Note::class,
                ]);
            } else {
                Storage::delete('public/' . $image);
                $img->delete();
            }
        }

        $this->emit('noteUpdated');
        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.note.edit');
    }
}
