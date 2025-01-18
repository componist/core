{{-- @php
    dd($attributes);
@endphp --}}
<div x-data="app()" x-init="[initDate($wire.{{ $model }}), getNoOfDays()]" x-cloak class="relative">

    <div x-on:click="showDatepicker = !showDatepicker" x-on:keyup.tab="showDatepicker = !showDatepicker" class="relative">
        <input type="hidden" name="date" x-ref="date"
            :value="$wire.set('{{ $model }}', datepickerValue, true)" />

        <div
            class="flex items-center justify-between w-full h-10 px-3 mt-1 bg-white border border-gray-300 rounded-md shadow-sm cursor-pointer items-centerpx-3 focus:outline-none focus:ring-sky-500 focus:border-sky-500 sm:text-sm">
            <div class="flex items-center gap-1">
                <span x-text="dateView"></span>
                <template x-if="dateView">
                    <button @click.prevent="clear()" type="button"
                        class="relative z-10 flex items-center justify-center w-6 h-6 text-gray-300 hover:text-gray-700">
                        <x:component::icon.close class="h-9 hover:text-dashboard-500" />
                    </button>
                </template>

            </div>
            <x:component::icon.calendar class="text-gray-400 w-7" />
        </div>
    </div>

    <div x-show.transition="showDatepicker" @click.away="showDatepicker = false" x-cloak
        x-transition:enter="transition ease-out duration-100 transform" x-transition:enter-start="opacity-0 scale-30"
        x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75 transform"
        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
        class="fixed top-0 bottom-0 left-0 right-0 z-50 flex items-center justify-center px-5 bg-gray-500 backdrop-blur-sm bg-opacity-70">

        <div @click.outside="showDatepicker = false" class=" p-4 mt-12 bg-gray-200 rounded-lg shadow w-[22rem]">
            <div class="flex items-center justify-between mb-2">
                <div>
                    <span x-text="MONTH_NAMES[month]" class="text-lg font-bold text-gray-800"></span>
                    <span x-text="year" class="ml-1 text-lg font-normal text-gray-600"></span>
                </div>
                <div>
                    <button type="button"
                        class="inline-flex p-1 transition duration-100 ease-in-out rounded-full cursor-pointer focus:outline-none focus:shadow-outline hover:bg-gray-100"
                        @click.prevent="if (month == 0) {
                        year--;
                        month = 12;
                    } month--; getNoOfDays()">
                        <svg class="inline-flex w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button type="button"
                        class="inline-flex p-1 transition duration-100 ease-in-out rounded-full cursor-pointer focus:outline-none focus:shadow-outline hover:bg-gray-100"
                        @click.prevent="if (month == 11) {
                            month = 0;
                            year++;
                        } else {
                            month++;
                        } getNoOfDays()">
                        <svg class="inline-flex w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-7 gap-1 my-5">
                <template x-for="(day, index) in DAYS" :key="index">
                    <div x-text="day" class="text-xs font-semibold text-center text-gray-800"></div>
                </template>
            </div>

            <div class="grid grid-cols-7 gap-1">
                <template x-for="blankday in blankdays">
                    <div class="w-full h-[42px] p-1 text-sm text-center border border-transparent"></div>
                </template>

                <template x-for="(date, dateIndex) in no_of_days" :key="dateIndex">
                    <div @click.prevent="getDateValue(date)" x-text="date"
                        class="w-full h-[42px] flex items-center justify-center text-md leading-loose text-center rounded shadow-sm cursor-pointer default-transition"
                        :class="{
                            'bg-dashboard-700 text-white': isToday(date) == true,
                            'text-gray-600 bg-gray-100 hover:text-white hover:bg-dashboard-500': isToday(date) ==
                                false &&
                                isSelectedDate(date) == false,
                            'bg-dashboard-500 text-white hover:bg-opacity-75': isSelectedDate(date) == true
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
        const MONTH_SHORT_NAMES = ["Jan", "Feb", "Mär", "Apr", "Mai", "Jun", "Jul", "Aug", "Sep", "Okt", "Nov", "Dez", ];
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

                    console.log(date);
                    this.isSelectedDate(date);

                    this.showDatepicker = false;
                },
                getNoOfDays() {
                    let daysInMonth = new Date(this.year, this.month + 1, 0).getDate();
                    let dayOfWeek = new Date(this.year, this.month).getDay();

                    let blankdaysArray = [];
                    let daysArray = [];

                    (dayOfWeek == 0) ?
                    dayOfWeek = 6: --dayOfWeek;

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
