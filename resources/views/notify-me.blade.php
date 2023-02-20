<x-notify-me-layout>
    <x-slot:content-header>
        {{ config('notify-me.header') }}
    </x-slot:content-header>
    <x-slot:content-summary>
        Notification Calendar for {{ config('app.name') }}
    </x-slot:content-summary>
    <div class="antialiased sans-serif bg-transparent">
        <div x-data="app()" x-init="[initDate(), getNoOfDays(), getNotificationList()]" x-cloak>
            <div class="container mx-auto">
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="flex bg-gray-100 items-center justify-between py-2 px-6">
                        <div>
                            <span x-text="MONTH_NAMES[month]" class="text-lg font-bold text-gray-800"></span>
                            <span x-text="year" class="ml-1 text-lg text-gray-600 font-normal"></span>
                        </div>
                        <div class="bg-white border rounded-lg px-1" style="padding-top: 2px;">
                            <button
                                type="button"
                                class="leading-none rounded-lg transition ease-in-out duration-100 inline-flex cursor-pointer hover:bg-gray-200 p-1 items-center"
                                :class="{'cursor-not-allowed opacity-25': month == 0 }"
                                :disabled="month == 0 ? true : false"
                                @click="month--; getNoOfDays()">
                                <svg class="h-6 w-6 text-gray-500 inline-flex leading-none"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                            </button>
                            <div class="border-r inline-flex h-6"></div>
                            <button
                                type="button"
                                class="leading-none rounded-lg transition ease-in-out duration-100 inline-flex items-center cursor-pointer hover:bg-gray-200 p-1"
                                :class="{'cursor-not-allowed opacity-25': month == 11 }"
                                :disabled="month == 11 ? true : false"
                                @click="month++; getNoOfDays()">
                                <svg class="h-6 w-6 text-gray-500 inline-flex leading-none"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="-mx-1 -mb-1">
                        <div class="flex flex-wrap bg-gray-100 border-t-2 border-gray-800 border-dotted">
                            <template x-for="(day, index) in DAYS" :key="index">
                                <div style="width: 14.26%" class="px-2 py-2">
                                    <div
                                        x-text="day"
                                        class="text-gray-600 text-sm uppercase tracking-wide font-bold text-center"></div>
                                </div>
                            </template>
                        </div>

                        <div class="flex flex-wrap border-t border-l">
                            <template x-for="blankday in blankdays">
                                <div
                                    style="width: 14.26%; height: 160px"
                                    class="text-center border-r border-b px-4 pt-2"
                                ></div>
                            </template>
                            <template x-for="(date, dateIndex) in no_of_days" :key="dateIndex">
                                <div style="width: 14.26%; height: 160px" class="px-1 pt-2 border-r border-b relative">
                                    <div
                                        x-text="date"
                                        class="inline-flex p-2 w-6 h-6 items-center justify-center text-center leading-none rounded-full transition ease-in-out duration-100"
                                        :class="{'bg-gray-500 text-white': isToday(date) == true, 'text-gray-700 hover:bg-gray-200': isToday(date) == false }"
                                    ></div>
                                    <div style="height: 120px;" class="overflow-ellipsis overflow-y-auto mt-1">
                                        <div class="absolute top-0 right-0 mt-2 mr-2 inline-flex items-center justify-center rounded-full text-sm w-6 h-6 bg-gray-700 text-white leading-none"
                                            x-show="events.filter(e => e.notify_date === new Date(year, month, date).toDateString()).length"
                                            x-text="events.filter(e => e.notify_date === new Date(year, month, date).toDateString()).length"></div>

                                        <template x-for="event in events.filter(e => new Date(e.notify_date).toDateString() ===  new Date(year, month, date).toDateString() )">
                                            <div
                                                @click="showEventModal(event)"
                                                class="px-2 py-1 rounded-lg mt-1 overflow-hidden border cursor-pointer"
                                                :class="{
												'border-blue-200 text-green-800 bg-green-100': event.notify_notified,
												'border-red-200 text-red-800 bg-red-100': ! event.notify_notified,
											}"
                                            >
                                                <p x-text="event.notify_title" class="text-xs truncate leading-tight">
                                                </p>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div style="background-color: rgba(0, 0, 0, 0.8)"
                 class="py-12 lg:py-16 fixed z-40 top-0 right-0 left-0 bottom-0 h-screen w-full"
                 x-show.transition.opacity="openEventModal">
                <div class="p-4 max-w-xl mx-auto relative absolute left-0 right-0 overflow-hidden mt-24">
                    <div class="shadow absolute right-0 top-0 w-10 h-10 rounded-full bg-white text-gray-500 hover:text-gray-800 inline-flex items-center justify-center cursor-pointer"
                         x-on:click="openEventModal = !openEventModal">
                        <svg class="fill-current w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path
                                d="M16.192 6.344L11.949 10.586 7.707 6.344 6.293 7.758 10.535 12 6.293 16.242 7.707 17.656 11.949 13.414 16.192 17.656 17.606 16.242 13.364 12 17.606 7.758z" />
                        </svg>
                    </div>

                    <div class="shadow w-full rounded-lg overflow-hidden w-full block p-8"
                         :class="{ 'bg-green-50': notify_notified,
                          'bg-red-50': !notify_notified }">

                        <h2 class="font-bold text-2xl mb-6 text-gray-800 border-b pb-2" x-html="notify_title" x-cloak></h2>

                        <div class="mb-4">
                            <label class="text-gray-800 block mb-1 font-bold text-sm tracking-wide">{{ __('notify-me::pickme.recipient') }}</label>
                            <div class="bg-gray-200 appearance-none border-2 border-gray-200 rounded-lg w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500"
                                 type="text"
                                 x-html="notify_recipients" x-cloak></div>
                        </div>

                        <div class="mb-4">
                            <label class="text-gray-800 block mb-1 font-bold text-sm tracking-wide">{{ __('notify-me::pickme.content') }}</label>
                            <div class="bg-gray-200 appearance-none border-2 border-gray-200 rounded-lg w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500"
                                 type="text"
                                 x-html="notify_message" x-cloak></div>
                        </div>

                        <div class="mb-4">
                            <label class="text-gray-800 block mb-1 font-bold text-sm tracking-wide">{{ __('notify-me::pickme.date') }}</label>
                            <div class="flex gap-x-2">
                                <div class="bg-gray-200 appearance-none border-2 border-gray-200 rounded-lg w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500"
                                     type="text"
                                     x-html="notify_date" x-cloak>

                                </div>
                                <div class="inline-flex bg-gray-200 appearance-none border-2 border-gray-200 rounded-lg w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         viewBox="0 0 20 20"
                                         x-show="notify_recur"
                                         fill="currentColor"
                                         class="w-5 h-5 text-green-600">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         viewBox="0 0 20 20"
                                         fill="currentColor"
                                         x-show="!notify_recur"
                                         class="w-5 h-5 text-red-600">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                                    </svg>

                                    <span class="text-gray-800 dark:text-white text-sm font-semibold tracking-wide ml-2">
                                        {{ __('notify-me::pickme.recur') }}
                                    </span>
                                </div>
                            </div>
                        </div>

{{--                        <div class="inline-block w-64 mb-4">--}}
{{--                            <label class="text-gray-800 block mb-1 font-bold text-sm tracking-wide">Select a theme</label>--}}
{{--                            <div class="relative">--}}
{{--                                <select @change="notify_theme = $event.target.value;" x-model="notify_theme" class="block appearance-none w-full bg-gray-200 border-2 border-gray-200 hover:border-gray-500 px-4 py-2 pr-8 rounded-lg leading-tight focus:outline-none focus:bg-white focus:border-blue-500 text-gray-700">--}}
{{--                                    <template x-for="(theme, index) in themes">--}}
{{--                                        <option :value="theme.value" x-text="theme.label"></option>--}}
{{--                                    </template>--}}

{{--                                </select>--}}
{{--                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">--}}
{{--                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

                        <div class="hidden mt-8 border-t">
                            <form action="{{ route('notify.me') }}" method="post" class="pt-4 bg-transparent dark:bg-gray-700">
                                @csrf
                                <div class="w-full flex">
                                    <div class="flex-1 cursor-pointer bg-white text-sm text-gray-900 font-semibold appearance-none py-2 px-2.5 border border-gray-800 rounded-lg shadow-sm mr-2 hover:bg-gray-50"
                                            @click="openEventModal = !openEventModal">
                                        Cancel
                                    </div>
                                    <div class="flex-1 cursor-pointer text-sm inline-flex appearance-none border-2 rounded-lg w-full py-2 px-4 leading-tight focus:outline-none"
                                         @click="stopRecur()"
                                         :class="{'text-red-700 hover:text-white hover:bg-red-500 border-red-800 bg-red-50': notify_recur,
                                                'text-green-800 hover:text-white hover:bg-green-800 border-green-900 bg-green-50 ': notify_recur == false
                                                }">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             viewBox="0 0 20 20"
                                             x-show="!notify_recur"
                                             fill="currentColor"
                                             class="w-5 h-5 mr-2">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                        </svg>
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             viewBox="0 0 20 20"
                                             fill="currentColor"
                                             x-show="notify_recur"
                                             class="w-5 h-5 mr-2">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                                        </svg>
                                        <span>
                                            {{ __('notify-me::pickme.recur') }}
                                        </span>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
            <!-- /Modal -->
        </div>
    </div>
    @push('scripts')
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.11.1/dist/cdn.min.js"></script>
        <script>
            const MONTH_NAMES = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            const DAYS = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

            function app() {
                return {
                    month: '',
                    year: '',
                    no_of_days: [],
                    blankdays: [],
                    days: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                    events: [],
                    notify: null,
                    notify_title: null,
                    notify_date: null,
                    notify_message: null,
                    notify_recipients: null,
                    notify_recur: false,
                    notify_notified: false,
                    notify_theme: 'blue',

                    themes: [
                        {
                            value: "blue",
                            label: "Blue Theme"
                        },
                        {
                            value: "red",
                            label: "Red Theme"
                        },
                        {
                            value: "yellow",
                            label: "Yellow Theme"
                        },
                        {
                            value: "green",
                            label: "Green Theme"
                        },
                        {
                            value: "purple",
                            label: "Purple Theme"
                        }
                    ],

                    openEventModal: false,

                    initDate() {
                        let today = new Date();
                        this.month = today.getMonth();
                        this.year = today.getFullYear();
                        this.datepickerValue = new Date(this.year, this.month, today.getDate()).toDateString();
                    },

                    isToday(date) {
                        const today = new Date();
                        const d = new Date(this.year, this.month, date);

                        return today.toDateString() === d.toDateString() ? true : false;
                    },

                    showEventModal(event) {
                        // open the modal
                        this.openEventModal = true;

                        this.notify = event.notify_uuid;
                        this.notify_title = event.notify_title;
                        this.notify_date = new Date(event.notify_date).toLocaleDateString('en-US') + ' ' + new Date(event.notify_date).toLocaleTimeString('en-US');
                        this.notify_message = event.notify_message;
                        this.notify_recipients = event.notify_recipients;
                        this.notify_recur = event.notify_recur;
                        this.notify_notified = event.notify_notified;

                        console.log(this.notify)
                    },

                    async stopRecur() {
                        const csrf = "{{ csrf_token() }}";
                        const data = {
                            _token: csrf,
                            notify: this.notify,
                            is_recur: ! this.notify_recur
                        };

                        await fetch('/notify-update', {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify(data),
                        })
                            .then(result => {
                                this.getNotificationList()
                            })
                            .catch(error => {
                                console.error('Error:', error);
                            })

                        this.notify_recur = data.is_recur;

                        this.openEventModal = false;
                    },

                    getNoOfDays() {
                        let daysInMonth = new Date(this.year, this.month + 1, 0).getDate();

                        // find where to start calendar day of week
                        let dayOfWeek = new Date(this.year, this.month).getDay();
                        let blankdaysArray = [];
                        for ( var i=1; i <= dayOfWeek; i++) {
                            blankdaysArray.push(i);
                        }

                        let daysArray = [];
                        for ( var i=1; i <= daysInMonth; i++) {
                            daysArray.push(i);
                        }

                        this.blankdays = blankdaysArray;
                        this.no_of_days = daysArray;
                    },

                    async getNotificationList() {
                        const csrf = "{{ csrf_token() }}";
                        const data = {
                            _token: csrf,
                            year: this.year,
                            month: this.month,
                        };

                        await fetch('/notififications', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify(data),
                        })
                            .then(response => response.json())
                            .then(data => {
                                this.events = data
                            })
                    }
                }
            }
        </script>
    @endpush
</x-notify-me-layout>
