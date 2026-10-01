<?php

namespace Tests\Integration\Modules\Identity;

use App\Modules\Identity\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that the web guard uses the modular User model.
     */
    public function test_web_guard_uses_modular_user_model(): void
    {
        $provider = Auth::guard('web')->getProvider();
        
        $this->assertInstanceOf(
            \Illuminate\Auth\EloquentUserProvider::class,
            $provider,
            'Web guard should use Eloquent user provider.'
        );
        
        $user = User::factory()->create();
        
        $retrievedUser = $provider->retrieveById($user->id);
        
        $this->assertInstanceOf(
            User::class,
            $retrievedUser,
            'Web guard provider should retrieve App\Modules\Identity\Models\User instances.'
        );
        
        $this->assertEquals(
            'App\Modules\Identity\Models\User',
            get_class($retrievedUser),
            'Retrieved user should be the modular User model, not App\Models\User.'
        );
    }

    /**
     * Test successful authentication with modular User model.
     */
    public function test_user_can_authenticate_with_modular_model(): void
    {
        $password = 'secure-password-123';
        
        $user = User::factory()->create([
            'email' => 'auth@example.com',
            'password' => $password,
        ]);

        $credentials = [
            'email' => 'auth@example.com',
            'password' => $password,
        ];

        $this->assertTrue(
            Auth::guard('web')->attempt($credentials),
            'Authentication should succeed with valid credentials.'
        );

        $this->assertTrue(
            Auth::guard('web')->check(),
            'User should be authenticated after successful attempt.'
        );

        $authenticatedUser = Auth::guard('web')->user();
        
        $this->assertInstanceOf(
            User::class,
            $authenticatedUser,
            'Authenticated user should be instance of modular User model.'
        );
        
        $this->assertEquals(
            $user->id,
            $authenticatedUser->id,
            'Authenticated user should match the created user.'
        );
    }

    /**
     * Test failed authentication with wrong password.
     */
    public function test_authentication_fails_with_wrong_password(): void
    {
        $user = User::factory()->create([
            'email' => 'auth@example.com',
            'password' => 'correct-password',
        ]);

        $credentials = [
            'email' => 'auth@example.com',
            'password' => 'wrong-password',
        ];

        $this->assertFalse(
            Auth::guard('web')->attempt($credentials),
            'Authentication should fail with wrong password.'
        );

        $this->assertFalse(
            Auth::guard('web')->check(),
            'User should not be authenticated after failed attempt.'
        );
    }

    /**
     * Test user can logout successfully.
     */
    public function test_user_can_logout(): void
    {
        $user = User::factory()->create([
            'password' => 'test-password',
        ]);

        Auth::guard('web')->login($user);
        
        $this->assertTrue(
            Auth::guard('web')->check(),
            'User should be authenticated after login.'
        );

        Auth::guard('web')->logout();
        
        $this->assertFalse(
            Auth::guard('web')->check(),
            'User should not be authenticated after logout.'
        );
        
        $this->assertNull(
            Auth::guard('web')->user(),
            'Authenticated user should be null after logout.'
        );
    }

    /**
     * Test that authenticated user has access to HasRoles trait methods.
     */
    public function test_authenticated_user_has_roles_trait(): void
    {
        $user = User::factory()->create([
            'password' => 'test-password',
        ]);

        Auth::guard('web')->login($user);
        
        $authenticatedUser = Auth::guard('web')->user();
        
        $this->assertTrue(
            method_exists($authenticatedUser, 'hasRole'),
            'Authenticated user should have hasRole method from HasRoles trait.'
        );
        
        $this->assertTrue(
            method_exists($authenticatedUser, 'givePermissionTo'),
            'Authenticated user should have givePermissionTo method from HasRoles trait.'
        );
    }
}