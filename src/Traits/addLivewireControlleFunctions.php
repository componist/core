<?php

namespace Reinholdjesse\Core\Traits;

trait addLivewireControlleFunctions
{
    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function openEditWindow(): void
    {
        $this->openEdit = true;
    }

    public function cloasEditWindow(): void
    {
        $this->openEdit = false;
    }

    public function create(): void
    {
        $this->clearValue();
        $this->openEditWindow();
    }

    public function filter(string $key, string $type): void
    {
        $this->filter[$key] = $type;
    }

    public function removeFilterType(string $key): void
    {
        unset($this->filter[$key]);
    }

    public function bannerMessage(string $type, string $message): void
    {
        $this->dispatch('banner-message', [
            'style' => $type,
            'message' => $message,
        ]);
    }

    public function storeAndIndex()
    {
        $this->store();
        $this->bannerMessage('success', 'Eintrag wurde erfolgreich erstellt');

        return redirect()->route($this->routeIndex);
    }

    public function storeAndNew()
    {
        $this->store();
        $this->bannerMessage('success', 'Eintrag wurde erfolgreich erstellt');

        return redirect()->route($this->isRoute);
    }

    public function updateAndIndex()
    {
        $this->update();
        $this->bannerMessage('success', 'Eintrag wurde erfolgreich aktualisiert');

        return redirect()->route($this->routeIndex);
    }

    public function updateAndNew()
    {
        $this->update();
        $this->bannerMessage('success', 'Eintrag wurde erfolgreich aktualisiert');

        return redirect()->route($this->isRoute);
    }

    public function cancel()
    {
        return redirect()->route($this->routeIndex);
    }
}
