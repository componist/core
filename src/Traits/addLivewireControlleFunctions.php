<?php

namespace Componist\Core\Traits;

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

    /**
     * Flash-Benachrichtigung für alle Packages (Standard).
     * Persistiert für Redirects (Session) und zeigt Toast auf der aktuellen Seite (Event).
     *
     * @param  'success'|'danger'|'warning'|'info'  $style
     */
    public function flashMessage(string $style, string $message, ?int $durationMs = null): void
    {
        session()->flash('flash.banner', $message);
        session()->flash('flash.bannerStyle', $style);

        $this->dispatch('toast-message', style: $style, message: $message, duration: $durationMs);
        $this->dispatch('banner-message', style: $style, message: $message, duration: $durationMs);
    }

    public function storeAndIndex()
    {
        $this->store();
        $this->flashMessage('success', 'Eintrag wurde erfolgreich erstellt');

        return redirect()->route($this->routeIndex);
    }

    public function storeAndNew()
    {
        $this->store();
        $this->flashMessage('success', 'Eintrag wurde erfolgreich erstellt');

        return redirect()->route($this->isRoute);
    }

    public function updateAndIndex()
    {
        $this->update();
        $this->flashMessage('success', 'Eintrag wurde erfolgreich aktualisiert');

        return redirect()->route($this->routeIndex);
    }

    public function updateAndNew()
    {
        $this->update();
        $this->flashMessage('success', 'Eintrag wurde erfolgreich aktualisiert');

        return redirect()->route($this->isRoute);
    }

    public function cancel()
    {
        return redirect()->route($this->routeIndex);
    }
}
