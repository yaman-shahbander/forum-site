<?php

namespace Tests\Feature;

use App\Models\Reply;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class FavoritesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function an_authenticated_user_can_favorite_any_reply()
    {
        $this->signIn();
        $reply = create(Reply::class);
        $this->post("replies/{$reply->id}/favorites");
        $this->assertCount(1, $reply->favorites);
    }

    /** @test */
    public function an_authenticated_user_may_only_favorite_a_reply_once()
    {
        $this->signIn();
        $reply = create(Reply::class);
        try {
            $this->post("replies/{$reply->id}/favorites");
            $this->post("replies/{$reply->id}/favorites");
        } catch(\Exception $e) {
            $this->fail('Did not expect to insert the same record set twice!');
        }

        $this->assertCount(1, $reply->favorites);
    }
}
