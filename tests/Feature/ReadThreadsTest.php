<?php

namespace Tests\Feature;

use Database\Factories\ReplyFactory;
use Database\Factories\ThreadFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReadThreadsTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        $this->thread = ThreadFactory::new()->create();
    }

    /** @test */
    public function a_user_can_view_all_threads()
    {

        $response = $this->get('/threads');

        $response
            ->assertStatus(200)
            ->assertSee($this->thread->title);
    }

    /** @test*/
    public function a_user_can_read_a_single_thread()
    {
        $response = $this->get($this->thread->path());

        $response
            ->assertStatus(200)
            ->assertSee($this->thread->title);
    }

    /** @test*/
    public function a_user_can_read_replies_that_are_associated_with_a_thread()
    {
        $reply = ReplyFactory::new(['thread_id' => $this->thread->id])->create();

        $response = $this->get($this->thread->path());

        $response->assertSee($reply->body);
    }
}
