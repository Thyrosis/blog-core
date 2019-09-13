<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Comment;
use App\Post;
use App\Category;
use Illuminate\Support\Carbon;
use App\Tag;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function aLoginPageIsShownToUnauthenticatedUser()
    {
        $this->get(route('login'))->assertStatus(200);
    }

    /**
     * @test
     */
    public function aUserCanResetTheirPassword()
    {
        $this->get(route('password.request'))->assertStatus(200);
    }

    /**
     * @test
     */
    public function anAuthenticatedUserIsRedirectedToHomepage() {
        $this->signIn();

        $this->get(route('login'))->assertStatus(302);
    }

    /**
     * @test
     */
    public function aGuestCannotViewAdminPages() 
    {
        $this->get(route('admin.post.index'))->assertStatus(302);
        $this->get(route('admin.post.create'))->assertStatus(302);
        $this->get(route('admin.post.store'))->assertStatus(405);

        $post = factory(Post::class)->create();
        $this->get(route('admin.post.edit', $post))->assertStatus(302);
        $this->get(route('admin.post.update', $post))->assertStatus(302);

        $this->get(route('admin.comment.index'))->assertStatus(302);

        $this->get(route('admin.category.index'))->assertStatus(302);
        $this->get(route('admin.category.store'))->assertStatus(302);

        $this->get(route('admin.tag.index'))->assertStatus(302);
        $this->get(route('admin.tag.store'))->assertStatus(302);
    }

    /**
     * @test
     */
    public function aGuestCannotCallAdminActions() {
        $post = factory(Post::class)->make();
        $this->post(route('admin.post.store'), $post->toArray())->assertStatus(302);

        $post2 = factory(Post::class)->create();
        $this->patch(route('admin.post.update', $post2))->assertStatus(302);

        $category = factory(Category::class)->make();
        $this->post(route('admin.category.store'), $category->toArray())->assertStatus(302);

        $category2 = factory(Category::class)->create();
        $this->patch(route('admin.category.update', $category2))->assertStatus(302);

        $tag = factory(Tag::class)->make();
        $this->post(route('admin.tag.store'), $tag->toArray())->assertStatus(302);

        $tag2 = factory(Tag::class)->create();
        $this->patch(route('admin.tag.update', $tag2))->assertStatus(302);
    }
}
