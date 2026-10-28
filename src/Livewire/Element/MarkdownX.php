<?php

namespace Componist\Core\Livewire\Element;

use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;

class MarkdownX extends Component
{
    public string $content = '';

    public string $contentPreview = '';

    public string $name = '';

    public string $key = '';

    /** @var array<string, string>|null */
    public ?array $style = null;

    public string $section = 'write';

    /**
     * Laravel livewire listeners, learn more at https://laravel-livewire.com/docs/events#event-listeners
     *
     * 'markdown-x-image-upload' => uploads image files from the editor
     *
     * @var array<string, string>
     */
    protected $listeners = [
        'markdown-x-image-upload' => 'upload',
        'markdown-x-giphy-load' => 'getGiphyTrendingImages',
        'markdown-x-giphy-search' => 'getGiphySearchImages',
    ];

    /**
     * Mount the MarkdownX component, you can pass the current content, the name for the textarea field,
     * and a generic Key. This key can be specified so that way you can include multiple MarkdownX
     * editors in a single page.
     */
    public function mount(?string $content = '', string $name = '', string $key = ''): void
    {
        $this->content = $content ?? '';
        $this->name = $name;
        $this->key = $key;
        $this->updateContentPreview();
    }

    /**
     * Anytime the editor is blurred, this function will be triggered and it will updated the $content,
     * this will also emit an event to the parent component with the updated content.
     *
     * @param  array{content: string}  $data
     */
    public function update(array $data): void
    {
        $content = $data['content'];
        $this->content = $content;
        $this->dispatch('markdown-x:update', $this->content);
    }

    /**
     * When the content changes this function will fire an event with the updatedPmark
     * content is being emitted to the parent component.
     */
    public function updatedContent(): void
    {
        $this->dispatch('markdown-x:update', $this->content);
    }

    /**
     * This function will update the Content Preview when user clicks on the Preview tab in the
     * Markdown editor toolbar.
     *
     * Note: This function can be overwritten with your customer Markdown parser. This is the
     * only function that will/can be changed when you upgrade to the latest version of the
     * MarkdownX editor.
     */
    public function updateContentPreview(): void
    {
        $this->contentPreview = Str::markdown($this->content);
    }

    /**
     * This function is called from the markdown-x view when the image file input has changed
     * The following data is sent with the payload:
     * {
     *      image: reader.result,
     *      name: file.name,
     *      key: key,
     *      text: "![" + file.name + "](Uploading...)"
     * }
     *
     * @param  mixed  $payload
     * @return void
     */
    public function upload($payload)
    {
        if (! is_array($payload) || ! isset($payload['image'], $payload['name'], $payload['key'], $payload['text'])) {
            abort(422);
        }

        $payload = (object) $payload;

        $path = 'images/'.strtolower(date('FY')).'/';
        $fullPath = '';

        try {
            $original_filename = pathinfo($payload->name, PATHINFO_FILENAME);
            $filename = $original_filename;
            $mimeType = mime_content_type($payload->image);
            if ($mimeType === false) {
                throw new Exception('Unknown mime type.');
            }
            $extension = explode('/', $mimeType)[1];
            $filename_counter = 1;

            // Make sure the filename does not exist, if it does make sure to add a number to the end 1, 2, 3, etc...
            while (Storage::disk(config('markdownx.storage.disk'))->exists($path.$filename.'.'.$extension)) {
                $filename = Str::slug($original_filename).(string) ($filename_counter++);
            }

            $fullPath = $path.$filename.'.'.$extension;

            // Get the Base64 string to store
            @[$type, $file_data] = explode(';', (string) $payload->image);
            @[, $file_data] = explode(',', (string) $file_data);
            $type = explode('/', $type)[1];

            if (! in_array($type, config('markdownx.image.allowed_file_types'))) {
                $this->dispatch('markdown-x-image-uploaded', [
                    'status' => 400,
                    'message' => 'File type not supported. Must be of type '.implode(', ', config('markdownx.image.allowed_file_types')),
                    'key' => $payload->key,
                    'text' => $payload->text,
                ]);

                return;
            }

            $decoded = base64_decode((string) $file_data, true);
            if ($decoded === false) {
                throw new Exception('Invalid base64 payload.');
            }

            $maxFileSizeInBytes = ((int) config('markdownx.image.max_file_size', 5000)) * 1024;
            if (strlen($decoded) > $maxFileSizeInBytes) {
                $this->dispatch('markdown-x-image-uploaded', [
                    'status' => 400,
                    'message' => 'Datei ist zu gross. Maximal '.(int) config('markdownx.image.max_file_size', 5000).' KB erlaubt.',
                    'key' => $payload->key,
                    'text' => $payload->text,
                ]);

                return;
            }

            Storage::disk(config('markdownx.storage.disk'))->put($fullPath, $decoded, 'public');

            $this->dispatch('markdown-x-image-uploaded', [
                'status' => 200,
                'message' => 'Successfully uploaded image.',
                'path' => str_replace(' ', '%20', Storage::url($fullPath)),
                'key' => $payload->key,
                'text' => $payload->text,
                'name' => $payload->name,
            ]);
        } catch (Exception $e) {
            $this->dispatch('markdown-x-image-uploaded', [
                'status' => 400,
                'message' => 'Error when trying to upload.',
                'key' => $payload->key,
                'text' => $payload->text,
            ]);
        }
    }

    /**
     * @param  array{key: string}  $payload
     */
    public function getGiphyImages(array $payload): void
    {
        $this->getGiphyTrendingImages($payload);
    }

    /**
     * @param  array{key: string}  $payload
     */
    public function getGiphyTrendingImages(array $payload): void
    {
        $api_key = config('markdownx.integrations.giphy.api_key');

        $response = Http::timeout(10)->get('https://api.giphy.com/v1/gifs/trending', [
            'api_key' => $api_key,
            'limit' => 30,
            'rating' => 'pg',
        ]);

        if ($response->ok()) {
            $this->sendResultsToView($response, $payload['key']);
        }
    }

    /**
     * @param  array{key: string, search: string}  $payload
     */
    public function getGiphySearchImages(array $payload): void
    {
        $api_key = config('markdownx.integrations.giphy.api_key');

        $response = Http::timeout(10)->get('https://api.giphy.com/v1/gifs/search', [
            'api_key' => $api_key,
            'q' => $payload['search'],
            'limit' => 30,
            'rating' => 'pg',
        ]);

        if ($response->ok()) {
            $this->sendResultsToView($response, $payload['key']);
        }
    }

    protected function sendResultsToView(Response $response, string $key): void
    {
        $parse_giphy_results = [];
        foreach ($response->json()['data'] as $result) {
            array_push(
                $parse_giphy_results,
                [
                    'image' => $result['images']['fixed_height_small']['url'],
                    'embed' => $result['embed_url'],
                ]
            );
        }

        $this->dispatch('markdown-x-giphy-results', [
            'status' => 200,
            'message' => 'Successfully returned results.',
            'results' => $parse_giphy_results,
            'key' => $key,
        ]);
    }

    /**
     * Render the markdown-x view. Hazah!
     */
    public function render(): View
    {
        return view('component::livewire.element.markdown-x');
    }
}
