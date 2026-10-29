<?php

declare(strict_types=1);

namespace Componist\Core\Tests\Feature;

use App\Models\User;
use Componist\Core\Livewire\Notification\ComponistCoreNotificationBell;
use Componist\Core\Models\ComponistCoreNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class NotificationBellTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_render_does_not_fail_when_session_expired(): void
    {
        Livewire::test(ComponistCoreNotificationBell::class)
            ->assertOk()
            ->assertViewHas('content', 0);
    }

    public function test_authenticated_user_sees_unread_notification_count(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
            'two_factor_code' => null,
            'two_factor_expires_at' => null,
        ]);

        ComponistCoreNotification::query()->create([
            'user_id' => $user->id,
            'title' => 'Test',
            'message' => 'Unread',
        ]);

        $readNotification = ComponistCoreNotification::query()->create([
            'user_id' => $user->id,
            'title' => 'Test read',
            'message' => 'Read',
        ]);
        $readNotification->forceFill(['read' => 1])->save();

        Livewire::actingAs($user)
            ->test(ComponistCoreNotificationBell::class)
            ->assertOk()
            ->assertViewHas('content', 1);
    }
}
