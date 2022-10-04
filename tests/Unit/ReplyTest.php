<?php

namespace Tests\Unit;

use App\Models\User;
use Database\Factories\ReplyFactory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ReplyTest extends TestCase
{
    use DatabaseMigrations;

    /** @test*/
    public function it_has_owner()
    {
        $reply = ReplyFactory::new()->create();

        $this->assertInstanceOf(User::class, $reply->owner);
    }
}
