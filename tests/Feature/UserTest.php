<?php

namespace Tests\Feature;

use App\User;
use App\Meta;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function aListOfUsersIsAvailableToAdmins()
    {
        $users = factory(User::class, 4)->create();

        foreach ($users as $user) {
            $this->assertDatabaseHas('users', $user->toArray());
        }

        $this->signIn();

        $response = $this->get(route('admin.user.index'));

        $response->assertStatus(200);

        foreach ($users as $user) {
            $response->assertSee($user->name);
        }
    }

    /**
     * @test
     */
    public function aUserCanBeEdited()
    {
        $this->signIn();

        $user = factory(User::class)->create();

        $this->assertDatabaseHas('users', $user->toArray());

        $response = $this->get(route('admin.user.edit', $user));

        $response->assertStatus(200);

        $response->assertSee($user->name);
        $response->assertSee($user->email);        
    }

    /**
     * @test
     */
    public function anUnauthenticatedUserCantEditAUser()
    {
        $user = factory(User::class)->create();

        $this->assertDatabaseHas('users', $user->toArray());

        $response = $this->get(route('admin.user.edit', $user));

        $response->assertStatus(302);   
    }

    /**
     * @test
     */
    public function aUserHasMetaInformation()
    {
        $meta = factory(Meta::class)->create();

        $user = User::find($meta->user_id);

        $this->assertEquals($meta->user_id, $user->id);
    }

    /**
     * @test
     */
    public function aUserCanCallOnItsOwnMeta() {
        $meta = factory(Meta::class)->create();

        $user = User::find($meta->user_id);

        $this->assertEquals($meta->value, $user->meta('first_name'));
    }

    /**
     * @test
     */
    public function nonexistingMetadataReturnsNull() {
        $meta = factory(Meta::class)->create();

        $user = User::find($meta->user_id);

        $this->assertEquals(null, $user->meta('last_name'));
    }

    /**
     * @test
     */
    public function metadataDefinesModeratorLevel() {
        $user = factory(User::class)->create();

        $meta = Meta::create(['user_id' => $user->id, 'key' => 'role', 'value' => 'admin']);

        $this->assertEquals('admin', $user->meta('role'));
        $this->assertEquals(true, $user->canModerate());
    }

    /**
     * @test
     */
    public function aUserWithoutAdminMetadataCantModerate()
    {
        $user = factory(User::class)->create();

        $this->assertEquals(null, $user->meta('role'));
        $this->assertEquals(false, $user->canModerate());
    }
}
