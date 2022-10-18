<?php

namespace Tests\Feature;

use App\Models\Channel;
use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test*/
    public function guests_may_not_create_threads()
    {
        $this->post('/threads', [])
            ->assertRedirect('/login');

        $this->get('/threads/create')
            ->assertRedirect('/login');
    }


    /** @test*/
    public function an_authenticated_user_can_create_new_forum_threads()
    {
        $this->signIn();
        $thread = make(Thread::class);
        $response = $this->post('/threads', $thread->toArray());
        $this->get($response->headers->get('Location'))
                 ->assertSee($thread->title)
                 ->assertSee($thread->body);
    }

    /** @test */
    public function a_thread_require_a_title()
    {
        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_thread_require_a_body()
    {
        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }

    /** @test */
    public function a_thread_require_a_valid_channel()
    {
        createMany(Channel::class);

        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id' => 999])
            ->assertSessionHasErrors('channel_id');
    }

    function publishThread($overrides = [])
    {
        $this->signIn();
        $thread = make(Thread::class, $overrides);
        return $this->post('threads', $thread->toArray());
    }

//    /** @test */
//    public function guests_can_not_delete_threads()
//    {
//        $thread = create(Thread::class);
//        $response = $this->delete($thread->path());
//        $response->assertRedirect('/login');
//    }

    /** @test */
    public function unauthorized_users_may_not_delete_threads()
    {
        $thread = create(Thread::class);
        $this->delete($thread->path())->assertRedirect('/login');
        $this->signIn();
        $this->delete($thread->path())->assertStatus(403);
    }

    /** @test */
    public function authorized_users_can_delete_threads()
    {
        $this->signIn();
        $thread = create(Thread::class, ['user_id' => \Auth::user()->id]);
        $reply = create(Reply::class, ['thread_id' => $thread->id]);
        $response = $this->json('DELETE', $thread->path());
        $response->assertStatus(204);
        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }
}
