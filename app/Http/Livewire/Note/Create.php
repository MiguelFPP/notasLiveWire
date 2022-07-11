<?php

namespace App\Http\Livewire\Note;

use App\Models\Note;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Create extends Component
{

    public $title;
    public $content;
    public $images = [];

    public function addImage($image)
    {
        $this->images[] = $image;
    }

    /* public function removeImage($image)
    {
        $this->images = array_diff($this->images, [$image]);
    } */

    public function save()
    {
        $note = Note::create([
            'title' => $this->title,
            'content' => $this->content,
            'user_id' => auth()->user()->id,
        ]);

        foreach ($this->images as $image) {
            $img = Image::where('path', $image)->first();

            if (strpos($note->content, $image)) {
                $img->update([
                    'imageable_id' => $note->id,
                    'imageable_type' => Note::class,
                ]);
            } else {
                Storage::delete('public/' . $image);
                $img->delete();
            }
        }

        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.note.create');
    }
}
