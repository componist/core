{{-- @php
dd($attributes);
@endphp --}}
<div x-data="app()" x-init="[initDate($wire.{{ $model }}), getNoOfDays()]" x-cloak class="relative">

    <div x-on:click="showDatepicker = !showDatepicker" x-on:keyup.tab="showDatepicker = !showDatepicker"
        class="relative">
        <input type="hidden" name="date" x-ref="date" :value="$wire.set('{{ $model }}', datepickerValue, true)" />

        <div
            class="{{ \Componist\Core\Support\Ui::FIELD }} mt-0 flex cursor-pointer items-center justify-between">
            <div class="flex min-w-0 items-center gap-1.5">
                <span class="truncate" x-text="dateView || 'Datum wählen'" :class="{ 'text-slate-400 dark:text-slate-500': !dateView }"></span>
                <template x-if="dateView">
                    <button @click.prevent="clear()" type="button"
                        class="relative z-10 flex h-6 w-6 shrink-0 items-center justify-center rounded-md text-slate-400 transition-colors hover:bg-slate-100 hover:text-slate-700 dark:text-slate-500 dark:hover:bg-slate-700 dark:hover:text-slate-200">
                        <x:component::icon.close class="h-4 w-4" />
                    </button>
                </template>
            </div>
            <x:component::icon.calendar class="h-5 w-5 shrink-0 text-slate-400 dark:text-slate-500" />
        </div>
    </div>

    <div x-show.transition="showDatepicker" @click.away="showDatepicker = false" x-cloak
        x-transition:enter="transition ease-out duration-100 transform" x-transition:enter-start="opacity-0 scale-30"
        x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75 transform"
        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
        class="fixed top-0 bottom-0 left-0 right-0 z-50 flex items-center justify-center px-5 bg-slate-500/70 backdrop-blur-sm">

        <div @click.outside="showDatepicker = false"
            class="mt-12 w-[22rem] rounded-lg border border-slate-200 bg-white p-4 shadow-lg dark:border-slate-700 dark:bg-slate-900">
            <div class="mb-2 flex items-center justify-between">
                <div>
                    <span x-text="MONTH_NAMES[month]"
                        class="text-lg font-bold text-slate-800 dark:text-slate-100"></span>
                    <span x-text="year"
                        class="ml-1 text-lg font-normal text-slate-600 dark:text-slate-300"></span>
                </div>
                <div>
                    <button type="button"
                        class="inline-flex cursor-pointer rounded-full p-1 transition duration-100 ease-in-out hover:bg-slate-200 focus:outline-none dark:hover:bg-slate-700"
                        @click.prevent="if (month == 0) {
                        year--;
                        month = 12;
                    } month--; getNoOfDays()">
                        <svg class="inline-flex h-6 w-6 text-slate-400 dark:text-slate-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button type="button"
                        class="inline-flex cursor-pointer rounded-full p-1 transition duration-100 ease-in-out hover:bg-slate-200 focus:outline-none dark:hover:bg-slate-700"
                        @click.prevent="if (month == 11) {
                            month = 0;
                            year++;
                        } else {
                            month++;
                        } getNoOfDays()">
                        <svg class="inline-flex h-6 w-6 text-slate-400 dark:text-slate-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="my-5 grid grid-cols-7 gap-1">
                <template x-for="(day, index) in DAYS" :key="index">
                    <div x-text="day"
                        class="text-center text-xs font-semibold text-slate-800 dark:text-slate-200"></div>
                </template>
            </div>

            <div class="grid grid-cols-7 gap-1">
                <template x-for="blankday in blankdays">
                    <div class="h-[42px] w-full border border-transparent p-1 text-center text-sm"></div>
                </template>

                <template x-for="(date, dateIndex) in no_of_days" :key="dateIndex">
                    <div @click.prevent="getDateValue(date)" x-text="date"
                        class="text-md flex h-[42px] w-full cursor-pointer items-center justify-center rounded text-center leading-loose shadow-sm default-transition"
                        :class="{
                            'bg-teal-700 text-white': isToday(date) == true,
                            'bg-slate-200 text-slate-600 hover:bg-teal-500 hover:text-white dark:bg-slate-700 dark:text-slate-300': isToday(date) ==
                                false &&
                                isSelectedDate(date) == false,
                            'bg-teal-500 text-white hover:bg-teal-600': isSelectedDate(date) == true
                        }">
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>

@once
    <script>
        const MONTH_NAMES = ["Januar", "Februar", "März", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober",
            "November", "Dezember",
        ];
        const MONTH_SHORT_NAMES = ["Jan", "Feb", "Mär", "Apr", "Mai", "Jun", "Jul", "Aug", "Sep", "Okt", "Nov", "Dez",];
        const DAYS = ["Mo", "Di", "Mi", "Do", "Fr", "Sa", "So"];

        function app() {
            return {
                showDatepicker: false,
                dateView: "",
                datepickerValue: "",
                selectedDate: "",
                month: "",
                year: "",
                no_of_days: [],
                blankdays: [],
                initDate(selectedDate = null) {
                    let today;
                    if (selectedDate) {
                        today = new Date(Date.parse(selectedDate));
                        this.dateView = this.formatForDateView(today);
                        this.datepickerValue = this.formatDateForDisplay(today);
                    } else {
                        today = new Date();
                    }

                    this.month = today.getMonth();
                    this.year = today.getFullYear();

                    //set default day
                    //this.datepickerValue = this.formatDateForDisplay(today);

                },

                formatForDateView(date) {
                    let formattedDay = DAYS[date.getDay()];
                    let formattedDate = ("0" + date.getDate()).slice(
                        -2
                    ); // appends 0 (zero) in single digit date
                    let formattedMonth = MONTH_NAMES[date.getMonth()];
                    let formattedMonthShortName =
                        MONTH_SHORT_NAMES[date.getMonth()];
                    let formattedMonthInNumber = (
                        "0" +
                        (parseInt(date.getMonth()) + 1)
                    ).slice(-2);
                    let formattedYear = date.getFullYear();

                    return `${formattedDate}.${formattedMonthInNumber}.${formattedYear}`;
                },
                formatDateForDisplay(date) {
                    let formattedDay = DAYS[date.getDay()];
                    let formattedDate = ("0" + date.getDate()).slice(
                        -2
                    ); // appends 0 (zero) in single digit date
                    let formattedMonth = MONTH_NAMES[date.getMonth()];
                    let formattedMonthShortName =
                        MONTH_SHORT_NAMES[date.getMonth()];
                    let formattedMonthInNumber = (
                        "0" +
                        (parseInt(date.getMonth()) + 1)
                    ).slice(-2);
                    let formattedYear = date.getFullYear();

                    return `${formattedYear}-${formattedMonthInNumber}-${formattedDate}`;
                },
                isSelectedDate(date) {
                    const d = new Date(this.year, this.month, date);
                    return this.datepickerValue === this.formatDateForDisplay(d) ?
                        true :
                        false;
                },
                isToday(date) {
                    const today = new Date();
                    const d = new Date(this.year, this.month, date);
                    return today.toDateString() === d.toDateString() ?
                        true :
                        false;
                },
                getDateValue(date) {
                    let selectedDate = new Date(this.year, this.month, date);

                    this.datepickerValue = this.formatDateForDisplay(selectedDate);
                    this.dateView = this.formatForDateView(selectedDate);
                    this.isSelectedDate(date);

                    this.showDatepicker = false;
                },
                getNoOfDays() {
                    let daysInMonth = new Date(this.year, this.month + 1, 0).getDate();
                    let dayOfWeek = new Date(this.year, this.month).getDay();

                    let blankdaysArray = [];
                    let daysArray = [];

                    (dayOfWeek == 0) ?
                        dayOfWeek = 6 : --dayOfWeek;

                    for (var i = 1; i <= dayOfWeek; i++) {
                        blankdaysArray.push(i);
                    }

                    for (var i = 1; i <= daysInMonth; i++) {
                        daysArray.push(i);
                    }

                    this.blankdays = blankdaysArray;
                    this.no_of_days = daysArray;
                },

                clear() {
                    this.dateView = null;
                    this.datepickerValue = null;
                },
            };
        }
    </script>
@endonce
