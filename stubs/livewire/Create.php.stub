<?php

namespace Reinholdjesse\Notifications\Livewire\Notification\Message;

use Livewire\Component;
use Reinholdjesse\Core\Traits\addLivewireControlleFunctions;

class Create extends Component
{
    use addLivewireControlleFunctions;

    public string $title = '';

    public ?string $content = null;

    protected $rules = [
        'title' => 'required|string',
        'content' => 'nullable|string',
    ];

    private $routeIndex = '[name].index';

    private $isRoute = '[name].create';

    public function render()
    {
        return view('livewire.[name].create')->layout(config('core.template.dashboard'));
    }

    public function store()
    {
        $this->validate();

        if (Model::insert([
            'title' => $this->title,
            'content' => $this->content,
            'created_at' => date('Y-m-d H:i:s'),
        ])) {
            $this->bannerMessage('success', 'Eintrag wurde erfolgreich gespeichert');
        } else {
            $this->bannerMessage('danger', 'Fehler beim speichern des Eintrags.');
        }
    }
}
