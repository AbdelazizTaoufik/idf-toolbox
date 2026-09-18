<?php

namespace Tests\Feature;

use App\Models\AdminModule;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AdminModuleAccessTest extends TestCase
{
    use DatabaseTransactions;

    public function test_admin_without_any_module_sees_no_buttons_and_cannot_open_sub_pages()
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->get('/admin');
        $response->assertOk();
        $response->assertSee('noch keine Berechtigungen zugewiesen');
        $response->assertDontSee('Verwalte alle Benutzer und deren Rechte.');

        $this->actingAs($admin)->get('/admin/users')->assertForbidden();
        $this->actingAs($admin)->get('/admin/submissions')->assertForbidden();
        $this->actingAs($admin)->get('/admin/meeting-groups')->assertForbidden();
    }

    public function test_admin_only_sees_and_can_access_the_module_assigned_to_them()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $submissionsModule = AdminModule::where('key', AdminModule::SUBMISSIONS)->firstOrFail();
        $admin->adminModules()->attach($submissionsModule);

        $response = $this->actingAs($admin)->get('/admin');
        $response->assertOk();
        $response->assertSee('Kummerkasteneinträge');
        $response->assertDontSee('Benutzerverwaltung');
        $response->assertDontSee('Sitzungsgruppen');

        $this->actingAs($admin)->get('/admin/submissions')->assertOk();
        $this->actingAs($admin)->get('/admin/users')->assertForbidden();
        $this->actingAs($admin)->get('/admin/meeting-groups')->assertForbidden();
    }

    public function test_non_admin_is_still_blocked_from_admin_area_entirely()
    {
        $user = User::factory()->create(['is_admin' => false]);

        $this->actingAs($user)->get('/admin')->assertForbidden();
    }

    public function test_toggling_a_module_in_user_management_grants_and_revokes_access()
    {
        $manager = User::factory()->create(['is_admin' => true]);
        $manager->adminModules()->attach(AdminModule::where('key', AdminModule::USERS)->firstOrFail());

        $target = User::factory()->create(['is_admin' => true]);
        $usersModule = AdminModule::where('key', AdminModule::USERS)->firstOrFail();

        $this->actingAs($manager)->post("/admin/users/{$target->id}/toggle-module", [
            'module' => $usersModule->key,
        ])->assertRedirect();

        $this->assertTrue($target->fresh()->hasModuleAccess(AdminModule::USERS));

        $this->actingAs($manager)->post("/admin/users/{$target->id}/toggle-module", [
            'module' => $usersModule->key,
        ])->assertRedirect();

        $this->assertFalse($target->fresh()->hasModuleAccess(AdminModule::USERS));
    }
}
