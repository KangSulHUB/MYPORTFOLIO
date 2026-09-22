<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_default_admin_account_can_login_when_missing(): void
    {
        User::query()->delete();

        $response = $this->post('/login', [
            'email' => 'admin@portfolio.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs(User::where('email', 'admin@portfolio.com')->first());
    }
}
