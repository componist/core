<?php

declare(strict_types=1);

namespace Componist\Core\Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardRoutesTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_requires_authentication(): void
    {
        $this->get(route('dashboard.index'))->assertRedirect();
    }

    public function test_profile_requires_authentication(): void
    {
        $this->get(route('profile'))->assertRedirect();
    }

    public function test_authenticated_user_can_view_dashboard(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
            'two_factor_code' => null,
            'two_factor_expires_at' => null,
        ]);

        $this->actingAs($user)
            ->get(route('dashboard.index'))
            ->assertOk()
            ->assertSee('Du bist angemeldet.', false);
    }

    public function test_authenticated_user_can_view_profile(): void
    {
        $user = User::factory()->create([
            'name' => 'Max Mustermann',
            'email' => 'max@example.test',
            'email_verified_at' => now(),
            'two_factor_code' => null,
            'two_factor_expires_at' => null,
        ]);

        $this->actingAs($user)
            ->get(route('profile'))
            ->assertOk()
            ->assertSee('Max Mustermann', false)
            ->assertSee('max@example.test', false);
    }
}
