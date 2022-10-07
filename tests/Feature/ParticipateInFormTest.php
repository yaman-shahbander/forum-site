<?php

namespace Tests\Feature;

use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ParticipateInFormTest extends TestCase
{
    use DatabaseMigrations;
    /** @test*/
    public function an_authenticated_user_may_participate_in_form_threads()
    {
        $this->signIn();
        $thread = create(Thread::class);
        $reply = create(Reply::class);

        $this->post($thread->path() . '/replies', $reply->toArray());

        $this->get($thread->path())->assertSee($reply->body);
    }
}
