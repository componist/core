<?php

declare(strict_types=1);

namespace Componist\Core\Tests\Feature;

use Componist\Core\Livewire\Element\MarkdownX;
use Illuminate\Support\Facades\Http;
use Livewire\Livewire;
use Tests\TestCase;

class MarkdownXGiphyTest extends TestCase
{
    public function test_giphy_results_are_dispatched_with_editor_key_and_never_the_api_key(): void
    {
        config(['markdownx.integrations.giphy.api_key' => 'secret-giphy-key']);

        Http::fake([
            'api.giphy.com/*' => Http::response([
                'data' => [
                    [
                        'images' => ['fixed_height_small' => ['url' => 'https://media.giphy.com/a.gif']],
                        'embed_url' => 'https://giphy.com/embed/a',
                    ],
                ],
            ]),
        ]);

        Livewire::test(MarkdownX::class, ['key' => 'editor-1'])
            ->call('getGiphyImages', ['key' => 'editor-1'])
            ->assertDispatched('markdown-x-giphy-results', fn (string $event, array $params): bool => $params[0]['key'] === 'editor-1')
            ->assertNotDispatched('markdown-x-giphy-results', fn (string $event, array $params): bool => str_contains((string) json_encode($params), 'secret-giphy-key'));
    }
}
