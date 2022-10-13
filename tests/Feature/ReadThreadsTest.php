<?php

namespace Tests\Feature;

use App\Models\Channel;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReadThreadsTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        $this->thread = create(Thread::class);
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
        $reply = create(Reply::class, ['thread_id' => $this->thread->id]);

        $response = $this->get($this->thread->path());

        $response->assertSee($reply->body);
    }

    /** @test */
    public function a_user_can_filter_threads_according_to_a_channel()
    {
        $channel = create(Channel::class);
        $threadInChannel = create(Thread::class, ['channel_id' => $channel->id]);
        $threadNotInChannel = create(Thread::class);

        $this->get("/threads/{$channel->slug}")
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }

    /** @test */
    public function a_user_can_filter_threads_by_any_username()
    {
        $this->signIn(create(User::class, ['name' => 'YamanShahbandar']));
        $threadByYaman = create(Thread::class, ['user_id' => \Auth::user()->id]);
        $threadNotByYaman = create(Thread::class);
        $this->get('/threads?by=YamanShahbandar')
            ->assertSee($threadByYaman->title)
            ->assertDontSee($threadNotByYaman->title);
    }
}
