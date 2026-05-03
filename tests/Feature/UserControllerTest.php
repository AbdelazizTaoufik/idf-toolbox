<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Http\Middleware\VerifyCsrfToken;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_user_management()
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->get(route('admin.users.index'));

        $response->assertStatus(200);
        $response->assertSee('Benutzerverwaltung');
    }

    public function test_non_admin_cannot_access_user_management()
    {
        $user = User::factory()->create(['is_admin' => false]);

        $response = $this->actingAs($user)->get(route('admin.users.index'));

        $response->assertStatus(403);
    }

    public function test_admin_can_search_users()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        User::factory()->create(['name' => 'John Doe', 'email' => 'john@example.com']);
        User::factory()->create(['name' => 'Jane Smith', 'email' => 'jane@example.com']);

        $response = $this->actingAs($admin)->get(route('admin.users.index', ['search' => 'John']));

        $response->assertStatus(200);
        $response->assertSee('John Doe');
        $response->assertDontSee('Jane Smith');
    }

    public function test_admin_can_toggle_admin_status_for_verified_user()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $targetUser = User::factory()->create([
            'is_admin' => false,
            'email_verified_at' => now(),
        ]);

        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->actingAs($admin)
            ->from(route('admin.users.index'))
            ->post(route('admin.users.toggle-admin', $targetUser));

        $response->assertRedirect(route('admin.users.index'));
        $this->assertTrue($targetUser->fresh()->is_admin);
    }

    public function test_admin_cannot_toggle_admin_status_for_unverified_user()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $targetUser = User::factory()->create([
            'is_admin' => false,
            'email_verified_at' => null,
        ]);

        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->actingAs($admin)
            ->from(route('admin.users.index'))
            ->post(route('admin.users.toggle-admin', $targetUser));

        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('error', 'Nur aktivierte Benutzer können zum Admin gemacht werden.');
        $this->assertFalse($targetUser->fresh()->is_admin);
    }

    public function test_admin_cannot_toggle_their_own_admin_status()
    {
        $admin = User::factory()->create(['is_admin' => true, 'email_verified_at' => now()]);

        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->actingAs($admin)
            ->from(route('admin.users.index'))
            ->post(route('admin.users.toggle-admin', $admin));

        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('error', 'Sie können sich nicht selbst die Admin-Rechte entziehen.');
        $this->assertTrue($admin->fresh()->is_admin);
    }

    public function test_admin_can_toggle_user_verification()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $targetUser = User::factory()->create(['email_verified_at' => null]);

        // Aktivieren
        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->actingAs($admin)
            ->from(route('admin.users.index'))
            ->post(route('admin.users.toggle-verification', $targetUser));

        $response->assertRedirect(route('admin.users.index'));
        $this->assertNotNull($targetUser->fresh()->email_verified_at);

        // Deaktivieren
        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->actingAs($admin)
            ->from(route('admin.users.index'))
            ->post(route('admin.users.toggle-verification', $targetUser));

        $response->assertRedirect(route('admin.users.index'));
        $this->assertNull($targetUser->fresh()->email_verified_at);
    }

    public function test_admin_can_delete_user()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $targetUser = User::factory()->create();

        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->actingAs($admin)
            ->from(route('admin.users.index'))
            ->delete(route('admin.users.destroy', $targetUser));

        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseMissing('users', ['id' => $targetUser->id]);
    }

    public function test_admin_cannot_delete_themselves()
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->actingAs($admin)
            ->from(route('admin.users.index'))
            ->delete(route('admin.users.destroy', $admin));

        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('error', 'Sie können sich nicht selbst löschen.');
        $this->assertDatabaseHas('users', ['id' => $admin->id]);
    }
}
