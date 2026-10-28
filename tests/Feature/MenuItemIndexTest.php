<?php

declare(strict_types=1);

namespace Componist\Core\Tests\Feature;

use App\Models\User;
use Componist\Core\Livewire\MenuItem\Index;
use Componist\Core\Models\Menu;
use Componist\Core\Models\MenuItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Livewire\Livewire;
use Tests\TestCase;

class MenuItemIndexTest extends TestCase
{
    use RefreshDatabase;

    private Menu $menu;

    protected function setUp(): void
    {
        parent::setUp();

        Gate::define('componist.core.manage', fn (): bool => true);

        $this->actingAs(User::factory()->create());
        $this->menu = Menu::forceCreate(['name' => 'test-menu']);
    }

    public function test_reorder_updates_the_order_of_each_item(): void
    {
        $first = $this->createItem('Erster', 1);
        $second = $this->createItem('Zweiter', 2);

        Livewire::test(Index::class, ['id' => $this->menu])
            ->call('reorder', [
                ['value' => $first->id, 'order' => 2],
                ['value' => $second->id, 'order' => 1],
            ]);

        $this->assertSame(2, $first->fresh()?->order);
        $this->assertSame(1, $second->fresh()?->order);
    }

    public function test_update_with_unknown_edit_id_returns_not_found(): void
    {
        Livewire::test(Index::class, ['id' => $this->menu])
            ->set('editId', 999999)
            ->set('title', 'Unbekannt')
            ->set('order', 1)
            ->call('update')
            ->assertNotFound();

        $this->assertSame(0, MenuItem::query()->count());
    }

    private function createItem(string $title, int $order): MenuItem
    {
        return MenuItem::forceCreate([
            'menu_id' => $this->menu->id,
            'title' => $title,
            'type' => 'url',
            'order' => $order,
        ]);
    }
}
