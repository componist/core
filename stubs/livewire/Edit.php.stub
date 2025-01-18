<?php

namespace Reinholdjesse\Notifications\Livewire\Notification\Message;

use Livewire\Component;
use Reinholdjesse\Core\Traits\addLivewireControlleFunctions;

class Edit extends Component
{
    use addLivewireControlleFunctions;

    public int $editId = 0;

    public string $title = '';

    public ?string $content;

    protected $rules = [
        'title' => 'required|string',
        'content' => 'nullable|string',
    ];

    private $routeIndex = '[name].index';

    private $isRoute = '[name].create';

    public function mount(Model $id)
    {
        $this->editId = $id->id;
        $this->title = $id->title;
        $this->content = $id->content;
    }

    public function render()
    {
        return view('livewire.[name].edit')->layout(config('core.template.dashboard'));
    }

    public function update()
    {
        $this->validate();

        if (Model::where('id', $this->editId)->update([
            'title' => $this->title,
            'content' => $this->content,
            'updated_at' => date('Y-m-d H:i:s'),
        ])) {
            $this->bannerMessage('success', 'Eintrag wurde gespeichert');
        } else {
            $this->bannerMessage('danger', 'Fehler beim speichern des Eintrags.');
        }
    }
}
