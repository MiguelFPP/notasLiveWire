<?php

namespace Tests\Feature;

use App\Http\Livewire\Note\Create;
use App\Http\Livewire\Note\Edit;
use App\Http\Livewire\Note\Index;
use App\Models\Note;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class NoteTest extends TestCase
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
    public function can_create_notes()
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(Create::class)
            ->set('content', 'algo de mas xd')
            ->call('save');

        $this->assertTrue(Note::where('content', 'algo de mas xd')->exists());
    }

    /**
     * @test
     */
    public function is_redirected_to_notes_page_after_creation()
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(Create::class)
            ->set('content', 'test')
            ->call('save')
            ->assertRedirect('/notas');
    }

    /**
     * @test
     */
    public function can_update_note()
    {
        $user = User::factory()->create();
        $note = Note::factory()->create(['user_id' => $user->id]);
        $this->actingAs($user);

        Livewire::test(Edit::class, ['note' => $note])
            ->set('content', 'test')
            ->call('save');

        $this->assertTrue(Note::where('content', 'test')->where('id', $note->id)->exists());
    }

    /**
     * @test
     */
    public function is_redirected_to_notes_page_after_update()
    {
        $user = User::factory()->create();
        $note = Note::factory()->create(['user_id' => $user->id]);
        $this->actingAs($user);

        Livewire::test(Edit::class, ['note' => $note])
            ->set('content', 'test')
            ->call('save')
            ->assertRedirect('/notas');
    }

    /**
     * @test
     */
    public function can_delete_notes()
    {
        $user = User::factory()->create();
        $note = Note::factory()->create(['user_id' => $user->id]);
        $this->actingAs($user);

        Livewire::test(Index::class)
            ->call('deleteNote', $note->id)
            ->assertDontSee($note->content);
    }

    /**
     * @test
     */
    public function can_ping_notes()
    {
        $user = user::factory()->create();
        $note = Note::factory()->create(['user_id' => $user->id]);
        $this->actingAs($user);

        Livewire::test(Index::class)
            ->call('notePinged', $note->id);

        $this->assertTrue(Note::where('id', $note->id)->where('pinged', true)->exists());
    }
}
