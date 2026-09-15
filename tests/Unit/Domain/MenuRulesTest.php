<?php

declare(strict_types=1);

namespace Componist\Core\Tests\Unit\Domain;

use Componist\Core\Domain\MenuRules;
use PHPUnit\Framework\TestCase;

class MenuRulesTest extends TestCase
{
    public function test_admin_menu_cannot_be_deleted(): void
    {
        $this->assertFalse(MenuRules::canDelete('admin'));
        $this->assertFalse(MenuRules::canDelete('Admin'));
    }

    public function test_other_menus_can_be_deleted(): void
    {
        $this->assertTrue(MenuRules::canDelete('dashboard'));
    }
}
