<?php

namespace Tests\Feature;

use App\User;
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

}
