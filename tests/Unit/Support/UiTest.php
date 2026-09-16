<?php

declare(strict_types=1);

namespace Componist\Core\Tests\Unit\Support;

use Componist\Core\Support\Ui;
use ReflectionClass;
use Tests\TestCase;

class UiTest extends TestCase
{
    public function test_field_and_textarea_share_base_tokens(): void
    {
        $this->assertStringContainsString('rounded-md', Ui::FIELD);
        $this->assertStringContainsString('border-slate-300', Ui::FIELD);
        $this->assertStringContainsString('focus:ring-teal-500/30', Ui::FIELD);
        $this->assertStringContainsString('dark:bg-slate-800', Ui::FIELD);
        $this->assertStringContainsString('aria-invalid:border-red-500', Ui::FIELD);

        $this->assertStringStartsWith(Ui::FIELD, Ui::TEXTAREA);
        $this->assertStringContainsString('resize-y', Ui::TEXTAREA);
    }

    public function test_buttons_use_consistent_radius_and_focus(): void
    {
        $this->assertStringContainsString('rounded-md', Ui::BUTTON_PRIMARY);
        $this->assertStringContainsString('bg-teal-500', Ui::BUTTON_PRIMARY);
        $this->assertStringContainsString('rounded-md', Ui::BUTTON_SECONDARY);
        $this->assertStringContainsString('focus:ring-teal-500', Ui::BUTTON_SECONDARY);
        $this->assertStringContainsString('bg-red-500', Ui::BUTTON_DANGER);
        $this->assertStringContainsString('h-9 w-9', Ui::BUTTON_ICON_TEAL);
        $this->assertStringContainsString('border-red-500', Ui::BUTTON_ICON_DANGER);
        $this->assertStringContainsString('border-slate-300', Ui::BUTTON_ICON_NEUTRAL);
        $this->assertStringContainsString('rounded-full', Ui::BUTTON_FAB);
        $this->assertStringContainsString('bg-teal-500', Ui::BUTTON_FAB);
        $this->assertStringContainsString('rounded-md', Ui::TAB);
        $this->assertStringContainsString('bg-teal-500', Ui::TAB_ACTIVE);
        $this->assertStringContainsString('bg-slate-200', Ui::TAB_INACTIVE);
    }

    public function test_ui_class_is_final_and_not_instantiable(): void
    {
        $reflection = new ReflectionClass(Ui::class);

        $this->assertTrue($reflection->isFinal());
        $this->assertTrue($reflection->getConstructor()->isPrivate());
    }
}
