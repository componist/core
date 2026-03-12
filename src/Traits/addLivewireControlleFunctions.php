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
     * Zentrale Toast-Meldung (für alle Packages).
     * Zeigt eine Toast-Notification über die Komponente component::toast-message.
     */
    public function toastMessage(string $style, string $message, ?int $durationMs = null): void
    {
        $this->dispatch('toast-message', style: $style, message: $message, duration: $durationMs);
        $this->dispatch('banner-message', style: $style, message: $message, duration: $durationMs);
    }

    /**
     * @deprecated Bitte toastMessage() verwenden. Bleibt als Alias erhalten.
     */
    public function bannerMessage(string $type, string $message): void
    {
        $this->toastMessage($type, $message);
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
