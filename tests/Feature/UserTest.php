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

        $admin = factory(User::class)->create();
        $meta = factory(Meta::class)->create(['key' => 'level']);
        $admin->updateMeta($meta->key, 'Admin');

        $this->signIn($admin);

        $response = $this->get(route('admin.user.index'));
        $response->assertStatus(200);

        foreach ($users as $user) {
            $response->assertSee($user->name);
        }
    }

    /**
     * @test
     */
    public function aListOfUsersIsNotAvailableToNonAdmins()
    {
        $users = factory(User::class, 4)->create();

        foreach ($users as $user) {
            $this->assertDatabaseHas('users', $user->toArray());
        }

        $this->signIn();

        $response = $this->get(route('admin.user.index'));
        $response->assertStatus(302);
    }

    /**
     * @test
     */
    public function aUserCanBeEdited()
    {
        $admin = factory(User::class)->create();
        $meta = factory(Meta::class)->create(['key' => 'level']);
        $admin->updateMeta($meta->key, 'Admin');

        $this->signIn($admin);

        $user = factory(User::class)->create();

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

        $user = factory(User::class)->create();

        $user->updateMeta($meta->key, 'This Value');

        $this->assertEquals($user->meta($meta->key), 'This Value');
    }

    /**
     * @test
     */
    public function nonexistingMetadataReturnsNull() {
        $meta = factory(Meta::class)->create();

        $user = factory(User::class)->create();

        $user->updateMeta($meta->key, 'This Value');
        $this->assertEquals($user->meta($meta->key), 'This Value');

        $this->assertEquals($user->meta('nonexisting'), null);
    }

    /**
     * @test
     */
    public function metadataDefinesModeratorLevel() {
        $user = factory(User::class)->create();
        $meta = factory(Meta::class)->create(['key' => 'level']);
        $user->updateMeta($meta->key, 'Admin');

        $this->assertEquals($user->meta('level'), 'Admin');
        $this->assertEquals($user->isAdmin(), true);
        $this->assertEquals($user->canModerate(), true);
    }

    /**
     * @test
     */
    public function aUserWithoutAdminMetadataCantModerate()
    {
        $user = factory(User::class)->create();

        $this->assertEquals($user->meta('level'), null);
        $this->assertEquals($user->canModerate(), false);
    }
}
