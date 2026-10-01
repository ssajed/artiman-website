<?php

namespace Tests\Unit\Modules\Identity\Models;

use App\Modules\Identity\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that the User model correctly uses the HasRoles trait.
     */
    public function test_user_model_uses_has_roles_trait(): void
    {
        $user = new User();
        
        $this->assertTrue(method_exists($user, 'roles'), 'User model should have roles method from HasRoles trait.');
        $this->assertTrue(method_exists($user, 'givePermissionTo'), 'User model should have givePermissionTo method from HasRoles trait.');
    }

    /**
     * Test that the fillable attributes are correctly defined.
     */
    public function test_user_model_fillable_attributes(): void
    {
        $user = new User();
        $this->assertEquals(['name', 'email', 'password'], $user->getFillable());
    }

    /**
     * Test that sensitive attributes are hidden during serialization.
     */
    public function test_user_model_hidden_attributes(): void
    {
        $user = new User();
        $this->assertContains('password', $user->getHidden());
        $this->assertContains('remember_token', $user->getHidden());
    }

    /**
     * Test that the casts are correctly defined.
     */
    public function test_user_model_casts(): void
    {
        $user = new User();
        $casts = $user->getCasts();
        
        $this->assertEquals('datetime', $casts['email_verified_at']);
        $this->assertEquals('hashed', $casts['password']);
    }

    /**
     * Test that a user can be created via factory and password is hashed.
     */
    public function test_user_can_be_created_and_password_is_hashed(): void
    {
        $plainPassword = 'super-secret-password';
        
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => $plainPassword,
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
        ]);
        
        // Ensure password is not stored in plain text
        $this->assertNotEquals($plainPassword, $user->password);
        
        // Ensure password can be verified
        $this->assertTrue(password_verify($plainPassword, $user->password));
    }
}
