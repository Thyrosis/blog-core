<?php

namespace Tests\Feature;

use App\Category;
use App\Comment;
use App\Post;
use App\Tag;
use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;
use Illuminate\Support\Facades\Queue;
use App\Notifications\NewComment;
use Illuminate\Support\Facades\Notification;
use App\Subscription;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function aCommentCanBePosted()
    {
        $comment = factory(Comment::class)->make();

        $result = $this->post(route('comment.store'), $comment->toArray());

        $result->assertStatus(302)->assertSessionHas('success');
        $this->assertEquals(1, Comment::count());
    }

    /**
     * @notatestyet
     */
    public function aNotificationIsSentToAdminUponComment()
    {
        // Queue::fake();
        Notification::fake();

        $user = factory(User::class)->create();
        $comment = factory(Comment::class)->make();

        $result = $this->post(route('comment.store'), $comment->toArray());

        // Assert a notification was sent to the given users...
        Notification::assertSentTo(
            [$user], NewComment::class
        );

        // Queue::assertPushedOn('default', NewComment::class);

    }

    /**
     * @test
     */
    public function aNewCommentByUnknonwPosterNeedsApproval()
    {
        // When a new comment is posted
        $comment = factory(Comment::class)->make();
        $result = $this->post(route('comment.store'), $comment->toArray());

        // The comment needs a approved status of false to be manually approved
        $this->assertEquals(0, Comment::first()->approved);
    }

    /**
     * @test
     */
    public function aNewCommentByAlreadyApprovedPosterIsAutomaticallyApproved()
    {
        // Given the poster has already one approved comment
        $comment = factory(Comment::class)->create(['approved' => 1]);
        $this->assertEquals(1, Comment::first()->approved);

        // A new comment posted by the same poster by name will be pre approved
        $comment2 = factory(Comment::class)->make(['name' => $comment->name]);
        $this->post(route('comment.store'), $comment->toArray());
        $this->assertEquals(1, Comment::latest()->limit(1)->first()->approved);

        // And a new comment posted by the same poster by email will be pre approved
        $comment3 = factory(Comment::class)->make(['emailaddress' => $comment->emailaddress]);
        $this->post(route('comment.store'), $comment->toArray());
        $this->assertEquals(1, Comment::latest()->limit(1)->first()->approved);
    }

    /**
     * @test
     */
    public function anEmptyCommentCanBeCreatedForTrackingPurposes()
    {
        $post = factory(Post::class)->create();

        $comment = factory(Comment::class)->make(['name' => 'Anonymous', 'emailaddress' => 'email@address.ext', 'body' => 'Subscription', 'post_id' => $post->id, 'notify' => 1]);
        $this->post(route('comment.store'), $comment->toArray());

        $this->assertEquals(1, Comment::count());
    }

    /**
     * @test
     */
    public function whenNotifyIsEnabledASubscriptionIsGenerated()
    {
        $comment = factory(Comment::class)->make(['notify' => 1]);
        $result = $this->post(route('comment.store'), $comment->toArray());

        $result->assertStatus(302)->assertSessionHas('success');
        $this->assertEquals(1, Comment::count());

        $this->assertCount(1, Subscription::all());
        $this->assertEquals($comment->emailaddress, Subscription::first()->emailaddress);
    }

    /**
     * @test
     */
    public function anExistingCommentCanBeModified()
    {
        $this->signIn();

        $comment = factory(Comment::class)->create(['approved' => 0, 'body' => 'Comment body']);

        $this->assertCount(1, Comment::all());

        $response = $this->patch(route('admin.comment.update', $comment), ['approved' => 1, 'body' => 'Changed body']);
        $response->assertStatus(302);
        $response->assertSessionHas('success');

        $this->assertCount(1, Comment::where('approved', 1)->where('body', 'Changed body')->get());
    }
}
