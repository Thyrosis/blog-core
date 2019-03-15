<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function aUserCanCallTheProfileRoute()
    {
        $this->withExceptionHandling();

        $this->signIn();

        $response = $this->get(route('profile.show', auth()->user()));

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function aUserCanEditTheirOwnProfileDetails()
    {
        $this->withExceptionHandling();

        $this->signIn();

        $response = $this->get(route('profile.edit', auth()->user()));

        $response->assertStatus(200);

        $response = $this->patch(route('profile.update', auth()->user()));

        $response->assertStatus(200);
    }
}
