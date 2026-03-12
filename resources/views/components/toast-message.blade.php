{{--
    Zentrales Toast-Flash für alle Packages (ein Toast zur Zeit, ohne x-for für Alpine/Livewire-Kompatibilität).
    Event: toast-message (oder banner-message für Abwärtskompatibilität)
    Payload: { style: 'success'|'danger'|'warning'|'info', message: string }
    Verwendung in Livewire: $this->dispatch('toast-message', ['style' => 'success', 'message' => 'Gespeichert.']);
    Oder Trait: $this->toastMessage('success', 'Gespeichert.');
--}}
@props([
    'style' => session('flash.bannerStyle', 'success'),
    'message' => session('flash.banner'),
])

<div
    x-data="{
        current: null,
        timeoutId: null,
        show(payload) {
            if (this.timeoutId) clearTimeout(this.timeoutId);
            this.current = {
                style: payload.style || 'success',
                message: payload.message || ''
            };
            const duration = typeof payload.duration === 'number' ? payload.duration : 4500;
            this.timeoutId = setTimeout(() => { this.current = null; }, duration);
        },
        close() {
            this.current = null;
            if (this.timeoutId) clearTimeout(this.timeoutId);
        }
    }"
    x-on:toast-message.window="show($event.detail && $event.detail.style !== undefined ? $event.detail : ($event.detail && $event.detail[0] ? $event.detail[0] : {}))"
    x-on:banner-message.window="show($event.detail && $event.detail.style !== undefined ? $event.detail : ($event.detail && $event.detail[0] ? $event.detail[0] : {}))"
    x-init="@if(session('flash.banner')) show({ style: @js($style), message: @js($message) }); @endif"
    class="fixed top-0 right-0 z-[100] p-4 pt-6 pointer-events-none sm:p-6 sm:pt-7"
    aria-live="polite"
>
    <div
        x-show="current"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-x-full"
        x-transition:enter-end="opacity-100 translate-x-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-x-0"
        x-transition:leave-end="opacity-0 translate-x-full"
        :class="{
            'bg-emerald-600 shadow-emerald-900/50': current && current.style === 'success',
            'bg-red-600 shadow-red-900/50': current && current.style === 'danger',
            'bg-amber-500 shadow-amber-900/50': current && current.style === 'warning',
            'bg-slate-600 shadow-slate-900/50': current && (current.style === 'info' || !['success','danger','warning'].includes(current.style))
        }"
        class="pointer-events-auto flex min-w-[280px] max-w-md items-start gap-3 rounded-lg py-3 pl-4 pr-3 shadow-lg"
    >
        <span class="shrink-0 rounded p-1" :class="{
            'bg-emerald-700': current && current.style === 'success',
            'bg-red-700': current && current.style === 'danger',
            'bg-amber-600': current && current.style === 'warning',
            'bg-slate-700': current && (current.style === 'info' || !['success','danger','warning'].includes(current.style))
        }">
            <svg x-show="current && current.style === 'success'" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <svg x-show="current && current.style === 'danger'" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <svg x-show="current && current.style === 'warning'" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <svg x-show="current && current.style !== 'success' && current.style !== 'danger' && current.style !== 'warning'" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </span>
        <p class="flex-1 min-w-0 text-sm font-medium text-white" x-text="current ? current.message : ''"></p>
        <button
            type="button"
            @click="close()"
            class="shrink-0 rounded p-1 text-white/80 hover:bg-white/20 hover:text-white focus:outline-none focus:ring-2 focus:ring-white/50"
            aria-label="Schließen"
        >
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
</div>
