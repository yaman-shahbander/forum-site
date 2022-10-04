<?php

namespace Tests\Unit;

use App\Models\User;
use Database\Factories\ThreadFactory;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        $this->thread = ThreadFactory::new()->create();
    }

    /** @test*/
    public function a_thread_has_replies()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->thread->replies);
    }

    /** @test*/
    public function a_thread_has_creator()
    {
        $this->assertInstanceOf(User::class, $this->thread->creator);
    }

    /** @test*/
    public function a_thread_can_add_a_reply()
    {
        $this->thread->addReply([
           'body' => 'Foobar',
           'user_id' => 1
        ]);

        $this->assertCount(1, $this->thread->replies);
    }
}
