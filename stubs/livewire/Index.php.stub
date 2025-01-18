<?php

namespace Reinholdjesse\Notifications\Livewire\Notification\Message;

use Livewire\Component;
use Livewire\WithPagination;
use Reinholdjesse\Core\Traits\addLivewireControlleFunctions;

class Index extends Component
{
    use addLivewireControlleFunctions;
    use WithPagination;

    public ?string $search = null;

    public function render()
    {
        $content = Model::where(function ($query) {
            $query->where('title', 'LIKE', '%'.trim($this->search).'%');
        })->orderBy('created_at', 'desc')->paginate(25);

        return view('livewire.[name].index', compact('content'))->layout(config('core.template.dashboard'));
    }

    public function toggle(int $id): void
    {
        $temp = Model::findOrFail($id);
        $temp['status'] = ! $temp['status'];
        $temp->save();
    }

    public function delete(int $id)
    {
        if (Model::find($id)->delete()) {
            $this->bannerMessage('success', 'Eintrag wurde erfolgreich gelöscht');
        } else {
            $this->bannerMessage('danger', 'Fehler beim löschen des Eintrags.');
        }
    }
}
