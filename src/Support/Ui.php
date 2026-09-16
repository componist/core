<?php

namespace Componist\Core\Support;

/**
 * Zentrale Tailwind-Klassen für Core-UI (Form, Buttons, Surfaces).
 * Alle Blade-Primitives sollen diese Tokens nutzen – keine abweichenden Border/Focus/Radii.
 */
final class Ui
{
    /**
     * Einzeilige Form-Controls: input, select, datepicker-trigger, select2-trigger.
     */
    public const FIELD = 'block w-full rounded-md border border-slate-300 bg-white px-3.5 py-2.5 text-sm leading-5 text-slate-900 shadow-sm shadow-black/5 outline-none transition-[color,box-shadow,border-color] duration-200 placeholder:text-slate-400 focus:border-teal-500 focus:ring-2 focus:ring-teal-500/30 disabled:cursor-not-allowed disabled:bg-slate-50 disabled:opacity-60 aria-invalid:border-red-500 aria-invalid:focus:border-red-500 aria-invalid:focus:ring-red-500/30 dark:border-slate-600 dark:bg-slate-800 dark:text-white dark:shadow-none dark:placeholder:text-slate-500 dark:focus:border-teal-500 dark:disabled:bg-slate-900/60';

    /**
     * Mehrzeilige Controls: textarea (inkl. TinyMCE-Fallback).
     */
    public const TEXTAREA = self::FIELD.' min-h-[7.5rem] resize-y';

    public const LABEL = 'mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-200';

    public const HINT = 'mt-1.5 text-xs text-slate-500 dark:text-slate-400';

    public const ERROR = 'mt-1.5 text-sm text-red-600 dark:text-red-400';

    public const CHECKBOX = 'h-4 w-4 shrink-0 cursor-pointer rounded border-slate-300 text-teal-500 shadow-sm focus:ring-2 focus:ring-teal-500/40 focus:ring-offset-0 disabled:cursor-not-allowed disabled:opacity-60 dark:border-slate-600 dark:bg-slate-800 dark:checked:bg-teal-500';

    public const BUTTON_PRIMARY = 'inline-flex shrink-0 cursor-pointer items-center justify-center gap-2 whitespace-nowrap rounded-md bg-teal-500 px-4 py-2 text-sm font-medium text-white shadow-sm shadow-black/5 transition-colors duration-200 hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-60 dark:shadow-none dark:focus:ring-offset-slate-900';

    public const BUTTON_SECONDARY = 'inline-flex shrink-0 cursor-pointer items-center justify-center gap-2 whitespace-nowrap rounded-md border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm shadow-black/5 transition-colors duration-200 hover:bg-slate-50 hover:text-slate-900 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-60 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-200 dark:shadow-none dark:hover:bg-slate-700 dark:hover:text-white dark:focus:ring-offset-slate-900';

    public const BUTTON_DANGER = 'inline-flex shrink-0 cursor-pointer items-center justify-center gap-2 whitespace-nowrap rounded-md bg-red-500 px-4 py-2 text-sm font-medium text-white shadow-sm shadow-black/5 transition-colors duration-200 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-60 dark:shadow-none dark:focus:ring-offset-slate-900';

    public const BUTTON_ICON = 'inline-flex h-9 w-9 shrink-0 cursor-pointer items-center justify-center rounded-md border shadow-sm shadow-black/5 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-60 dark:shadow-none dark:focus:ring-offset-slate-900';

    public const BUTTON_ICON_NEUTRAL = self::BUTTON_ICON.' border-slate-300 bg-white text-slate-500 hover:border-teal-500 hover:text-teal-500 focus:ring-teal-500 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-400 dark:hover:border-teal-500 dark:hover:text-teal-400';

    public const BUTTON_ICON_TEAL = self::BUTTON_ICON.' border-teal-500 text-teal-500 hover:bg-teal-500 hover:text-white focus:ring-teal-500';

    public const BUTTON_ICON_DANGER = self::BUTTON_ICON.' border-red-500 text-red-500 hover:bg-red-500 hover:text-white focus:ring-red-500';

    public const BUTTON_FAB = 'fixed bottom-5 right-5 z-30 inline-flex h-14 w-14 cursor-pointer items-center justify-center rounded-full bg-teal-500 text-white shadow-lg shadow-black/10 transition-colors duration-150 hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 dark:shadow-none dark:focus:ring-offset-slate-900';

    public const TAB = 'inline-flex cursor-pointer items-center justify-center rounded-md px-7 py-2 text-sm font-medium transition-colors duration-200 hover:bg-teal-600 hover:text-white focus:outline-none focus:ring-2 focus:ring-teal-500/40';

    public const TAB_ACTIVE = 'bg-teal-500 text-white';

    public const TAB_INACTIVE = 'bg-slate-200 text-slate-700 dark:bg-slate-800 dark:text-slate-200';

    public const SURFACE = 'overflow-hidden rounded-lg border border-slate-200 bg-white dark:border-slate-700 dark:bg-slate-900';

    public const DROPDOWN = 'rounded-md border border-slate-200 bg-white shadow-lg ring-1 ring-black/5 dark:border-slate-700 dark:bg-slate-800';

    public const CHIP = 'inline-flex items-center gap-1.5 rounded-full bg-teal-500 px-3 py-1 text-sm font-medium text-white shadow-sm transition-colors duration-200 hover:bg-teal-600';

    private function __construct() {}
}
