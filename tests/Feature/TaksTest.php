<?php

namespace Tests\Feature;

use App\Http\Livewire\Task\Index;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class TaksTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function can_create_tasks()
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(Index::class)
            ->set('content', 'algo de mas xd')
            ->call('taskSave');

        /* $this->assertDatabaseMissing('tasks', [
            'content' => 'algo de mas xd',
        ]); */

        $this->assertTrue(Task::where('content', 'algo de mas xd')->exists());
    }

    /**
     * @test
     */
    public function can_set_initial_content()
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(Index::class, ['content' => 'test'])->assertSet('content', 'test');
    }

    /**
     * @test
     */
    public function can_delete_tasks()
    {
        /* $this->actingAs(User::factory()->create()); */
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);
        $this->actingAs($user);


        Livewire::test(Index::class)
            ->call('delete', $task->id)
            ->assertDontSee($task->content);
    }

    /**
     * @test
     */
    public function can_mark_tasks_as_completed()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);
        $this->actingAs($user);

        Livewire::test(Index::class)
            ->call('taskCompleted', $task->id);
    }
}
