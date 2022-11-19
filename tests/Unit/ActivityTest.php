<?php

namespace Tests\Unit;

use App\Models\Activity;
use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Carbon;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;

class ActivityTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_records_activity_when_a_thread_is_created()
    {
        $this->signIn();
        $thread = create(Thread::class);
        $this->assertDatabaseHas('activities', [
            'type' => 'created_thread',
            'user_id' => Auth::user()->id,
            'subject_id' => $thread->id,
            'subject_type' => get_class($thread)
        ]);
        $activity = Activity::first();
        $this->assertEquals($activity->subject->id, $thread->id);
    }

    /** @test */
    public function it_records_activity_when_a_reply_is_created()
    {
        $this->signIn();
        $reply = create(Reply::class);
        $this->assertEquals(2, Activity::count());
    }

    /** @test */
    public function it_fetches_a_feed_for_any_user()
    {
        $this->signIn();
        createMany(Thread::class, 2, ['user_id' => Auth::user()->id]);
        $feed = Activity::feed(Auth::user(), 50);
        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->format('Y-m-d')
        ));
    }
}
