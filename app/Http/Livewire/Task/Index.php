<?php

namespace App\Http\Livewire\Task;

use App\Models\Task;
use Livewire\Component;

class Index extends Component
{
    public $complete;
    public $content;

    protected $rules = [
        'content' => 'max:255',
    ];

    public function taskCompleted($id)
    {
        $task = Task::find($id);
        $task->complete = !$task->complete;
        $task->save();
    }

    public function delete($id)
    {
        $task = Task::find($id);
        $task->delete();
    }

    public function taskSave()
    {
        $this->validate();

        $task = new Task();
        $task->content = $this->content;
        $task->user_id = auth()->user()->id;

        $task->save();
        
        $this->content = '';
    }

    public function render()
    {
        $tasks = Task::where('user_id', auth()->id())
            ->orderBy('id', 'desc')
            ->get();
        return view('livewire.task.index', [
            'tasks' => $tasks
        ]);
    }
}
