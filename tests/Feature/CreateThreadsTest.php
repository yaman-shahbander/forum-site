<?php

namespace Tests\Feature;

use App\Models\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test*/
    public function guests_may_not_create_threads()
    {
        $thread = make(Thread::class);
        $this->post('/threads', $thread->toArray())
            ->assertRedirect('/login');
    }

    /** @test*/
    public function an_authenticated_user_can_create_new_forum_threads()
    {
        $this->signIn();
        $thread = make(Thread::class);
        $this->post('/threads', $thread->toArray());
        $this->get($thread->path())
                 ->assertSee($thread->title)
                 ->assertSee($thread->body);
    }
}
