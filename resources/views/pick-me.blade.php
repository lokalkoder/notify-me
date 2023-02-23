<x-notify-me-layout>
    <x-slot:content-header>
        {{ config('notify-me.header') }}
    </x-slot:content-header>
    <x-slot:content-summary>
        {!! $notifier['summary'] !!}
    </x-slot:content-summary>

    @php
        $cssInput = 'block p-3 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 shadow-sm focus:ring-primary-500 focus:border-gray-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 dark:shadow-sm-light';
        $cssSelect = 'p-3  shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 dark:shadow-sm-light';
    @endphp

    <div class="mx-auto max-w-screen-md">
        <form action="{{ route('notify.post') }}" method="post" class="space-y-8 bg-white dark:bg-gray-700 p-4">
                @csrf
                <input type="hidden" value="{{ request()->get('model') }}" name="model">
                <input type="hidden" value="{{ request()->get('id') }}" name="id">
                <input type="hidden" value="{{ $back }}" name="back">
                @if ($errors->any())
                    <div class="w-full text-xs">
                        <div class="box-content px-2 py-4 border-2 border-red-900 bg-red-100 text-red-900 rounded-lg">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
                @if (session()->has('status'))
                    <div class="w-full text-xs">
                        <div class="box-content px-2 py-4 border-2 border-green-900 bg-green-100 text-green-900 rounded-lg">
                            <ul class="list-disc list-inside">
                                <li>{{ session()->get('status') }}</li>
                            </ul>
                        </div>
                    </div>
                @endif
                <div>
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">
                        {{ __('notify-me::pickme.recipient') }}
                    </label>
                    <select class="recipients-multiple {{$cssSelect}}"
                            name="email[]"
                            multiple="multiple">
                        @php
                            $email = config('notify-me.pick-me.recipient.field.email');
                        @endphp
                        @foreach($recipients as $recipient)
                            <option {{ in_array($recipient[$email], old('email') ?? []) ? 'selected' : '' }}
                                value="{{ $recipient[$email] }}">
                                {{ $recipient[$email] }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="subject" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">
                        {{ __('notify-me::pickme.subject') }}
                    </label>
                    <input type="text"
                           id="subject"
                           name="subject"
                           value="{!! old('subject', $notifier['subject']) !!}"
                           class="flex-1 {{ $cssInput }}"
                           placeholder="{{ __('notify-me::pickme.subject') }}"
                           required>
                </div>
                <div class="sm:col-span-2">
                    <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">
                        {{ __('notify-me::pickme.content') }}
                    </label>
                    <textarea id="message"
                              name="message"
                              rows="6"
                              class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg shadow-sm border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                              placeholder="{{ __('notify-me::pickme.content') }}">{!! old('message', $notifier['content']) !!}
                        </textarea>
                </div>
                <div>
                    <label for="subject" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">
                        {{ __('notify-me::pickme.date') }}
                    </label>
                    <div class="w-full flex">
                        <input type="text"
                               id="datepicker"
                               value="{{ old('date', \Carbon\Carbon::parse($notifier['date'])->format('m/d/Y')) }}"
                               name="date"
                               class="flex-1 {{ $cssInput }}"
                               placeholder="{{ __('notify-me::pickme.date') }}"
                               required>
                        <div class="flex-1">
                            <div class="flex px-2">
                                <select name="hours"
                                        value="{{ old('hours') }}"
                                        class="{{$cssSelect}} rounded-none rounded-l-lg">
                                    <option value="00" class="px-2"> {{ __('notify-me::pickme.time.hour') }}  </option>
                                    @foreach(range(0,12) as $hour)
                                        <option value="{{ $hour }}" class="px-2"> {{$hour}} </option>
                                    @endforeach
                                </select>
                                <select name="minutes"
                                        value="{{ old('minutes') }}"
                                        class="{{$cssSelect}} px-2  rounded-none ">
                                    <option value="00" class="px-2"> {{ __('notify-me::pickme.time.minute') }}  </option>
                                    @foreach(range(0,60,5) as $hour)
                                        <option value="{{ $hour }}" class="px-2"> {{$hour}} </option>
                                    @endforeach
                                </select>
                                <select name="ampm"
                                        value="{{ old('ampm') }}"
                                        class="{{$cssSelect}} px-2 rounded-none rounded-r-lg">
                                    <option value="" class="px-2"> {{ __('notify-me::pickme.time.ampm') }}  </option>
                                    <option value="am">AM</option>
                                    <option value="pm">PM</option>
                                </select>
                            </div>
                        </div>
                        <div class="flex-initial">
                            <div class="inline-flex {{ $cssInput }}">
                                <input type="checkbox"
                                       name="recur"
                                       :value="true">
                                <span class="text-gray-900 dark:text-white ml-2">
                                    {{ __('notify-me::pickme.recur') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-full text-right">
                    <button type="submit"
                            class="inline-flex py-3 px-5 text-sm text-gray-900 bg-gray-300 font-medium text-center rounded-lg sm:w-fit hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-400 dark:bg-gray-700 dark:hover:bg-gray-500 dark:focus:ring-gray-800 dark:text-white">
                        {{ __('notify-me::pickme.submit') }}
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                             fill="currentColor"
                             class="w-5 h-5 ml-2">
                            <path d="M5.25 12a.75.75 0 01.75-.75h.01a.75.75 0 01.75.75v.01a.75.75 0 01-.75.75H6a.75.75 0 01-.75-.75V12zM6 13.25a.75.75 0 00-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 00.75-.75V14a.75.75 0 00-.75-.75H6zM7.25 12a.75.75 0 01.75-.75h.01a.75.75 0 01.75.75v.01a.75.75 0 01-.75.75H8a.75.75 0 01-.75-.75V12zM8 13.25a.75.75 0 00-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 00.75-.75V14a.75.75 0 00-.75-.75H8zM9.25 10a.75.75 0 01.75-.75h.01a.75.75 0 01.75.75v.01a.75.75 0 01-.75.75H10a.75.75 0 01-.75-.75V10zM10 11.25a.75.75 0 00-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 00.75-.75V12a.75.75 0 00-.75-.75H10zM9.25 14a.75.75 0 01.75-.75h.01a.75.75 0 01.75.75v.01a.75.75 0 01-.75.75H10a.75.75 0 01-.75-.75V14zM12 9.25a.75.75 0 00-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 00.75-.75V10a.75.75 0 00-.75-.75H12zM11.25 12a.75.75 0 01.75-.75h.01a.75.75 0 01.75.75v.01a.75.75 0 01-.75.75H12a.75.75 0 01-.75-.75V12zM12 13.25a.75.75 0 00-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 00.75-.75V14a.75.75 0 00-.75-.75H12zM13.25 10a.75.75 0 01.75-.75h.01a.75.75 0 01.75.75v.01a.75.75 0 01-.75.75H14a.75.75 0 01-.75-.75V10zM14 11.25a.75.75 0 00-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 00.75-.75V12a.75.75 0 00-.75-.75H14z" />
                            <path fill-rule="evenodd" d="M5.75 2a.75.75 0 01.75.75V4h7V2.75a.75.75 0 011.5 0V4h.25A2.75 2.75 0 0118 6.75v8.5A2.75 2.75 0 0115.25 18H4.75A2.75 2.75 0 012 15.25v-8.5A2.75 2.75 0 014.75 4H5V2.75A.75.75 0 015.75 2zm-1 5.5c-.69 0-1.25.56-1.25 1.25v6.5c0 .69.56 1.25 1.25 1.25h10.5c.69 0 1.25-.56 1.25-1.25v-6.5c0-.69-.56-1.25-1.25-1.25H4.75z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </form>
    </div>
    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    @endpush

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
        <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>

        <script>
            $(document).ready(function () {
                $('.recipients-multiple').select2({
                    tags: true,
                    allowClear: true
                });

                $("#datepicker").datepicker();

                ClassicEditor.create(document.getElementById("message"), {
                    // https://ckeditor.com/docs/ckeditor5/latest/features/toolbar/toolbar.html#extended-toolbar-configuration-format
                    toolbar: {
                        items: [
                            'selectAll', '|',
                            'heading',
                            'bold', 'italic',
                            'bulletedList', 'numberedList',
                            'outdent', 'indent',
                            'undo', 'redo',
                            'link', 'blockQuote', 'insertTable', 'mediaEmbed'
                        ],
                        shouldNotGroupWhenFull: true
                    },
                    // Changing the language of the interface requires loading the language file using the <script> tag.
                    // language: 'es',
                    list: {
                        properties: {
                            styles: true,
                            startIndex: true,
                            reversed: true
                        }
                    },
                    // https://ckeditor.com/docs/ckeditor5/latest/features/headings.html#configuration
                    heading: {
                        options: [
                            { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                            { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                            { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                            { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                            { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                            { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
                            { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
                        ]
                    },
                    // https://ckeditor.com/docs/ckeditor5/latest/features/editor-placeholder.html#using-the-editor-configuration
                    placeholder: 'Welcome to CKEditor 5!',
                    // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-family-feature
                    fontFamily: {
                        options: [
                            'default',
                            'Arial, Helvetica, sans-serif',
                            'Courier New, Courier, monospace',
                            'Georgia, serif',
                            'Lucida Sans Unicode, Lucida Grande, sans-serif',
                            'Tahoma, Geneva, sans-serif',
                            'Times New Roman, Times, serif',
                            'Trebuchet MS, Helvetica, sans-serif',
                            'Verdana, Geneva, sans-serif'
                        ],
                        supportAllValues: true
                    },
                    // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-size-feature
                    fontSize: {
                        options: [ 10, 12, 14, 'default', 18, 20, 22 ],
                        supportAllValues: true
                    },
                    // Be careful with the setting below. It instructs CKEditor to accept ALL HTML markup.
                    // https://ckeditor.com/docs/ckeditor5/latest/features/general-html-support.html#enabling-all-html-features
                    htmlSupport: {
                        allow: [
                            {
                                name: /.*/,
                                attributes: true,
                                classes: true,
                                styles: true
                            }
                        ]
                    },
                    // Be careful with enabling previews
                    // https://ckeditor.com/docs/ckeditor5/latest/features/html-embed.html#content-previews
                    htmlEmbed: {
                        showPreviews: true
                    },
                    // https://ckeditor.com/docs/ckeditor5/latest/features/link.html#custom-link-attributes-decorators
                    link: {
                        decorators: {
                            addTargetToExternalLinks: true,
                            defaultProtocol: 'https://',
                            toggleDownloadable: {
                                mode: 'manual',
                                label: 'Downloadable',
                                attributes: {
                                    download: 'file'
                                }
                            }
                        }
                    },
                    // The "super-build" contains more premium features that require additional configuration, disable them below.
                    // Do not turn them on unless you read the documentation and know how to configure them and setup the editor.
                    removePlugins: [
                        // These two are commercial, but you can try them out without registering to a trial.
                        // 'ExportPdf',
                        // 'ExportWord',
                        'CKBox',
                        'CKFinder',
                        'EasyImage',
                        // This sample uses the Base64UploadAdapter to handle image uploads as it requires no configuration.
                        // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/base64-upload-adapter.html
                        // Storing images as Base64 is usually a very bad idea.
                        // Replace it on production website with other solutions:
                        // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/image-upload.html
                        // 'Base64UploadAdapter',
                        'RealTimeCollaborativeComments',
                        'RealTimeCollaborativeTrackChanges',
                        'RealTimeCollaborativeRevisionHistory',
                        'PresenceList',
                        'Comments',
                        'TrackChanges',
                        'TrackChangesData',
                        'RevisionHistory',
                        'Pagination',
                        'WProofreader',
                        // Careful, with the Mathtype plugin CKEditor will not load when loading this sample
                        // from a local file system (file://) - load this site via HTTP server if you enable MathType
                        'MathType'
                    ]
                });
            });
        </script>
    @endpush
</x-notify-me-layout>
