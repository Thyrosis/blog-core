<?php

namespace Tests\Feature;

use App\User;
use App\Meta;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;


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

        $this->signInAdmin();

        $response = $this->get(route('admin.user.index'));
        $response->assertStatus(200);

        foreach ($users as $user) {
            $response->assertSee($user->name);
        }

        ob_end_clean();
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
        $this->signInAdmin();

        $user = factory(User::class)->create();

        $response = $this->get(route('admin.user.edit', $user));

        $response->assertStatus(200);

        $response->assertSee($user->name);
        $response->assertSee($user->email);        

        ob_end_clean();
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
        $meta = factory(Meta::class)->create(['label' => Str::random(32)]);

        $user = factory(User::class)->create();

        $user->updateMeta($meta->code, 'This Value');

        $this->assertEquals($user->meta($meta->code), 'This Value');
    }

    /**
     * @test
     */
    public function nonexistingMetadataReturnsNull() {
        $meta = factory(Meta::class)->create(['label' => 'This is my test label']);

        $user = factory(User::class)->create();

        $user->updateMeta($meta->code, 'This Value');

        $this->assertEquals($user->meta($meta->code), 'This Value');

        $this->assertEquals($user->meta('nonexisting'), null);
    }

    /**
     * @test
     */
    public function metadataDefinesModeratorLevel() {
        $this->signInAdmin();

        $this->assertEquals(auth()->user()->meta('access-level'), 'Admin');
        $this->assertEquals(auth()->user()->isAdmin(), true);
        $this->assertEquals(auth()->user()->canModerate(), true);
    }

    /**
     * @test
     */
    public function aUserWithoutAdminMetadataCantModerate()
    {
        $user = factory(User::class)->create();

        $this->assertEquals($user->meta( 'access-level'), null);
        $this->assertEquals($user->canModerate(), false);
    }
}
