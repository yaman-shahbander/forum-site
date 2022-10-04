<?php

namespace Tests\Feature;

use Database\Factories\ReplyFactory;
use Database\Factories\ThreadFactory;
use Database\Factories\UserFactory;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ParticipateInFormTest extends TestCase
{
    use DatabaseMigrations;
    /** @test*/
    public function an_authenticated_user_may_participate_in_form_threads()
    {
        $this->be(UserFactory::new()->create());
        $thread = ThreadFactory::new()->create();
        $reply = ReplyFactory::new()->make();

        $this->post($thread->path() . '/replies', $reply->toArray());

        $this->get($thread->path())->assertSee($reply->body);
    }
}
