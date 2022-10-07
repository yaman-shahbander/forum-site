<?php

namespace Tests\Feature;

use Database\Factories\ThreadFactory;
use Database\Factories\UserFactory;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test*/
    public function guests_may_not_create_threads()
    {
//        $this->expectException(AuthenticationException::class);
        $thread = ThreadFactory::new()->make();
        $this->post('/threads', $thread->toArray())
            ->assertRedirect('/login');
    }

    /** @test*/
    public function an_authenticated_user_can_create_new_forum_threads()
    {
        $this->actingAs(UserFactory::new()->create());
        $thread = ThreadFactory::new()->make();
        $this->post('/threads', $thread->toArray());
        $this->get($thread->path())
                 ->assertSee($thread->title)
                 ->assertSee($thread->body);
    }
}
