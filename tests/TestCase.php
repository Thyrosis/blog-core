<?php

namespace Tests;

use App\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    
    protected function signIn($user = null, $overrides = [])
    {
        $user = $user ?: factory(User::class)->create($overrides);

        // $user = $user ?: User::factory()->create($overrides);

        $this->actingAs($user);

        return $user;
    }

    protected function signInAdmin($user = null, $overrides = [])
    {
        $user = $user ?: factory(User::class)->create($overrides);
        
        $meta = \App\Meta::where('code', 'access-level')->first();

        if (!$meta) {
            \App\Meta::create([
                'code' => 'access-level',
                'label' => "Access level",
                'system' => 1,
                'updateable' => 1,
            ]);
        }

        $user->updateMeta('access-level', 'Admin');

        $this->actingAs($user);

        return $user;
    }

    protected function setUp(): void
    {
        parent::setUp();
        
        shell_exec('php artisan db:seed --database=sqlite');
    }
}
