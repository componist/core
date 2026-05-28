<?php

declare(strict_types=1);

namespace Componist\Core\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CoreHelpersTest extends TestCase
{
    use RefreshDatabase;

    public function test_menu_helper_returns_null_when_menu_does_not_exist(): void
    {
        $this->assertNull(menu('site'));
    }

    public function test_componist_menu_href_resolves_plain_url_items(): void
    {
        $item = (object) [
            'type' => 'url',
            'name' => 'dashboard',
            'view_path' => null,
        ];

        $this->assertSame(url('dashboard'), componist_menu_href($item));
    }

    public function test_html_minifier_removes_line_breaks_tabs_and_multiple_spaces(): void
    {
        $input = "  <div>\n\t Hallo   Welt \r\n </div>  ";

        $this->assertSame(' <div> Hallo Welt </div> ', HTML_Minifier($input));
    }
}
