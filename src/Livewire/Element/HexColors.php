<?php

namespace Reinholdjesse\Core\Livewire\Element;

use Livewire\Component;

class HexColors extends Component
{
    public string $event = 'hexColor';

    public array $colorListe = [];

    public ?string $selectedColor = null;

    public ?int $rowId = null;

    public function mount(?string $selectedColor = null, ?int $rowId = null, ?string $event = null): void
    {
        $this->selectedColor = $selectedColor;

        if (isset($rowId)) {
            $this->rowId = $rowId;
        }

        if (isset($event)) {
            $this->event = $event;
        }

        $this->colorListe = $this->colorsList();
    }

    public function render()
    {
        return view('component::livewire.element.hex-colors');
    }

    public function setColor(string $color): void
    {
        $this->selectedColor = $color;
        $this->emit($this->event, $color, $this->rowId);
    }

    private function colorsList(): array
    {
        // tailwindcss color
        // 200, 300, 400, 500, 600, 700
        return [
            'red' => ['#fecaca', '#fca5a5', '#f87171', '#ef4444', '#dc2626', '#b91c1c'],
            'orange' => ['#fed7aa', '#fdba74', '#fb923c', '#f97316', '#ea580c', '#c2410c'],
            'amber' => ['#fde68a', '#fcd34d', '#fbbf24', '#f59e0b', '#d97706', '#b45309'],
            'yellow' => ['#fef08a', '#fde047', '#facc15', '#eab308', '#ca8a04', '#a16207'],
            'lime' => ['#d9f99d', '#bef264', '#a3e635', '#84cc16', '#65a30d', '#4d7c0f'],
            'green' => ['#bbf7d0', '#86efac', '#4ade80', '#22c55e', '#16a34a', '#15803d'],
            'emerald' => ['#a7f3d0', '#6ee7b7', '#34d399', '#10b981', '#059669', '#047857'],
            'teal' => ['#99f6e4', '#5eead4', '#2dd4bf', '#14b8a6', '#0d9488', '#0f766e'],
            'cyan' => ['#a5f3fc', '#67e8f9', '#22d3ee', '#06b6d4', '#0891b2', '#0e7490'],
            'sky' => ['#bae6fd', '#7dd3fc', '#38bdf8', '#0ea5e9', '#0284c7', '#0369a1'],
            'blue' => ['#bfdbfe', '#93c5fd', '#60a5fa', '#3b82f6', '#2563eb', '#1d4ed8'],
            'indigo' => ['#c7d2fe', '#a5b4fc', '#818cf8', '#6366f1', '#4f46e5', '#4338ca'],
            'violet' => ['#ddd6fe', '#c4b5fd', '#a78bfa', '#8b5cf6', '#7c3aed', '#6d28d9'],
            'purple' => ['#e9d5ff', '#d8b4fe', '#c084fc', '#a855f7', '#9333ea', '#7e22ce'],
            'fuchsia' => ['#f5d0fe', '#f0abfc', '#e879f9', '#d946ef', '#c026d3', '#a21caf'],
            'pink' => ['#fbcfe8', '#f9a8d4', '#f472b6', '#ec4899', '#db2777', '#be185d'],
            'rose' => ['#fecdd3', '#fda4af', '#fb7185', '#f43f5e', '#e11d48', '#be123c'],
            'gray' => ['#ffffff', '#eeeeee', '#8a9597', '#7f7f7f', '#333333', '#000000'],
        ];
    }
}
