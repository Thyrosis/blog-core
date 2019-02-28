<?php

namespace Tests\Feature;

use App\Category;
use App\Post;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
Use Illuminate\Support\Str;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function aPostCanBelongToACategory()
    {
        $this->withoutExceptionHandling();

        $this->signIn();
        
        $category = factory(Category::class)->create();

        $this->assertDatabaseHas('categories', $category->toArray());

        $post = factory(Post::class)->states('publishing')->make(['categories' => [$category->id]]);

        try {
            $this->post(route('admin.post.store'), $post->toArray());
        } catch (ValidationException $e) {
            dd($e);
        }        

        $this->assertDatabaseHas('posts', ['title' => $post->title]);

        $this->assertEquals(1, Post::first()->categories->count());
    }

    /**
     * @test
     */
    public function aCategoryCanHaveAPost()
    {
        $category = factory(Category::class)->create();

        $this->assertDatabaseHas('categories', $category->toArray());

        $post = factory(Post::class)->create();

        $this->assertDatabaseHas('posts', $post->toArray());

        $category->posts()->sync([$post->id]);

        $this->assertEquals(1, $category->fresh()->posts->count());
    }

    /**
     * @test
     */
    public function aCategoryCanBeCreated()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $category = factory(Category::class)->make();

        $this->post(route('admin.category.store'), $category->toArray());

        $this->assertDatabaseHas('categories', $category->toArray());

        $dbCategory = Category::first();

        $this->assertEquals(Str::slug($category->name), $dbCategory->slug);
    }

    /**
     * @test
     */
    public function aCategoryCanBeEdited()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $category = factory(Category::class)->make();

        $this->post(route('admin.category.store'), $category->toArray());

        $this->assertDatabaseHas('categories', $category->toArray());

        $category->name = "New Title";
        $category->description = "New description";

        $this->patch(route('admin.category.update', $category), $category->toArray());

        $this->assertDatabaseHas('categories', $category->toArray());
    }

    /**
     * @test
     */
    public function aCategoryCanBeDeleted()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $category = factory(Category::class)->make();

        $this->post(route('admin.category.store'), $category->toArray());

        $this->assertDatabaseHas('categories', $category->toArray());

        $this->delete(route('admin.category.destroy', $category));

        $this->assertDatabaseMissing('categories', $category->toArray());
    }

    /**
     * @test
     */
    public function whenACategoryIsDeletedExistingPostsRemain()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $category = factory(Category::class)->create();
        $post = factory(Post::class)->create();
        $category->posts()->sync([$post->id]);

        $this->assertEquals(1, Post::count());
        $this->assertEquals(1, $post->categories()->count());

        $this->delete(route('admin.category.destroy', $category));

        $this->assertEquals(1, Post::count());
        $this->assertEquals(0, Category::count());
        $this->assertEquals(0, $post->fresh()->categories()->count());
    }

}
