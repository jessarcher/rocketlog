@extends('base', ['bodyClass' => 'spotlight-bg'])

@section('body')
    @if (Route::has('login'))
        <div class="fixed top-0 right-0 px-6 py-4">
            @auth
                <a href="{{ url('/daily-log') }}" class="text-sm text-gray-700 underline">Your Log</a>
            @else
                <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Login</a>

                {{-- @if (Route::has('register')) --}}
                {{--         <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a> --}}
                {{-- @endif --}}
            @endif
        </div>
    @endif

    <div class="p-4 md:p-10 max-w-3xl mx-auto">
        <svg class="h-12" fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 143 32">
            <g clip-path="url(#clip0)">
            <path d="M29.838 2.19l.975.223a1 1 0 00-1.198-1.198l.223.975zM13.13 10.804l-.644-.765a1.044 1.044 0 00-.063.058l.707.707zm8.094 8.094l.707.707c.02-.02.04-.041.058-.063l-.765-.644zm-7.046 5.154l-.707.707a1 1 0 001.149.19l-.442-.897zM7.976 17.85l-.897-.442a1 1 0 00.19 1.149l.707-.707zm8.822 4.694l-.551-.834a1 1 0 00-.436.674l.987.16zm-.969 5.978l-.987-.16a1 1 0 001.694.867l-.707-.707zm5.668-5.668l.707.707a1 1 0 00.28-.549l-.987-.158zm.859-5.36l.987.157a1 1 0 00-1.779-.769l.792.611zM14.59 9.628l.61.792a1 1 0 00-.769-1.78l.159.988zm-5.082 5.563l.16.987a1 1 0 00.673-.434l-.833-.553zm-6.031.979l-.708-.707a1 1 0 00.868 1.694l-.16-.987zm5.668-5.668l-.159-.988a1 1 0 00-.548.28l.707.708zm13.626-.377a.595.595 0 01-.842 0l-1.414 1.414a2.595 2.595 0 003.67 0l-1.414-1.414zm-.842 0a.595.595 0 010-.842L20.516 7.87a2.595 2.595 0 000 3.67l1.414-1.414zm0-.842a.595.595 0 01.842 0l1.414-1.414a2.595 2.595 0 00-3.67 0l1.414 1.414zm.842 0a.595.595 0 010 .842l1.414 1.414a2.595 2.595 0 000-3.67l-1.414 1.414zM18.6 14.3a.595.595 0 01-.842 0l-1.414 1.415a2.595 2.595 0 003.67 0l-1.414-1.415zm-.842 0a.595.595 0 010-.841l-1.414-1.415a2.595 2.595 0 000 3.67l1.414-1.414zm0-.841a.595.595 0 01.842 0l1.414-1.415a2.595 2.595 0 00-3.67 0l1.414 1.415zm.842 0a.595.595 0 010 .841l1.414 1.415a2.595 2.595 0 000-3.67l-1.414 1.414zm-4.174 5.015a.595.595 0 01-.842 0l-1.414 1.414a2.595 2.595 0 003.67 0l-1.414-1.414zm-.842 0a.595.595 0 010-.842l-1.414-1.414a2.595 2.595 0 000 3.67l1.414-1.414zm0-.842a.595.595 0 01.842 0l1.414-1.414a2.595 2.595 0 00-3.67 0l1.414 1.414zm.842 0a.595.595 0 010 .842l1.414 1.414a2.595 2.595 0 000-3.67l-1.414 1.414zm15.19-16.416C23.738 2.56 17.53 5.793 12.486 10.039l1.289 1.53c4.83-4.067 10.757-7.139 16.286-8.404l-.446-1.95zM21.99 19.542c4.246-5.043 7.48-11.252 8.824-17.13l-1.95-.445c-1.265 5.529-4.337 11.456-8.404 16.287l1.53 1.288zm-7.37 5.407c2.506-1.232 4.973-3.005 7.312-5.344l-1.414-1.415c-2.2 2.2-4.49 3.838-6.78 4.964l.883 1.795zm-7.35-6.392l6.202 6.202 1.415-1.414-6.203-6.202-1.414 1.414zm5.154-8.46c-2.339 2.34-4.112 4.806-5.344 7.311l1.795.883c1.126-2.29 2.764-4.58 4.963-6.78l-1.414-1.414zm3.388 12.287l-.97 5.978 1.975.32.97-5.978-1.975-.32zm.725 6.845l5.668-5.668-1.414-1.414-5.668 5.668 1.414 1.414zm5.948-6.217l.86-5.36-1.976-.317-.858 5.361 1.974.316zm-.92-6.13c-.36.466-.728.924-1.105 1.371l1.53 1.289a43.3 43.3 0 001.159-1.438l-1.584-1.222zm-1.047 1.308a27.609 27.609 0 01-4.27 3.52l1.103 1.668a29.6 29.6 0 004.58-3.773l-1.413-1.415zm-6.742-6.62c.465-.393.94-.776 1.426-1.149l-1.22-1.585c-.508.391-1.006.792-1.495 1.203l1.289 1.53zm-3.433 4.175a27.64 27.64 0 013.495-4.234l-1.414-1.414a29.642 29.642 0 00-3.747 4.542l1.666 1.106zm-.993-1.54l-6.032.979.32 1.974 6.032-.979-.32-1.974zm-5.164 2.673l5.668-5.668-1.414-1.414-5.669 5.668 1.415 1.414zm5.12-5.388l5.444-.874-.317-1.975-5.445.874.317 1.975z" fill="url(#paint0_linear)"/>
            <path d="M7.575 24.425l-4.4 4.4m8.63-3.554l-4.4 4.4m-.676-9.476l-4.4 4.4" stroke="#FF5C00" stroke-width="2" stroke-linecap="round"/>
            <path d="M37.856 23.968c0 .288-.128.552-.384.792-.256.224-.536.336-.84.336-.288 0-.488-.192-.6-.576a277.794 277.794 0 01-.072-6.312l-.072-6.048c0-1.216.536-2.048 1.608-2.496.864-.4 1.888-.6 3.072-.6.608 0 1.256.152 1.944.456.704.288 1.328.72 1.872 1.296.56.56.84 1.176.84 1.848 0 .656-.304 1.368-.912 2.136a9.856 9.856 0 01-2.256 2.016c-.896.576-1.768 1.008-2.616 1.296 1.488 1.04 2.784 2.16 3.888 3.36 1.104 1.184 1.656 2.104 1.656 2.76 0 .208-.104.408-.312.6a1.148 1.148 0 01-.768.264c-.288 0-.536-.128-.744-.384-.352-.848-1.024-1.736-2.016-2.664-.976-.944-2.12-1.84-3.432-2.688l.144 4.608zm-.096-7.2c1.072-.048 2.272-.496 3.6-1.344 1.344-.848 2.016-1.608 2.016-2.28 0-.688-.336-1.216-1.008-1.584-.672-.368-1.472-.552-2.4-.552-.912 0-1.64.112-2.184.336a366 366 0 00-.024 5.424zM53.242 9.04c1.12 0 2.072.36 2.856 1.08 1.536 1.376 2.304 3.552 2.304 6.528 0 2.96-.848 5.288-2.544 6.984-.88.848-1.896 1.312-3.048 1.392-1.52 0-2.704-.52-3.552-1.56a9.69 9.69 0 01-1.824-3.48c-.352-1.296-.528-2.544-.528-3.744 0-2.048.488-3.736 1.464-5.064 1.024-1.424 2.648-2.136 4.872-2.136zm-.168 1.992c-2.144 0-3.48 1.016-4.008 3.048-.16.544-.24 1.24-.24 2.088 0 .848.16 1.832.48 2.952.432 1.504 1.072 2.56 1.92 3.168.496.384 1.096.576 1.8.576s1.336-.312 1.896-.936c.56-.64.944-1.448 1.152-2.424.208-.976.312-1.96.312-2.952 0-1.76-.256-3.12-.768-4.08-.496-.96-1.344-1.44-2.544-1.44zM67.298 9.304c1.072 0 2.256.208 3.552.624.288.224.432.472.432.744 0 .256-.136.488-.408.696a1.44 1.44 0 01-.888.288c-.864-.224-1.672-.336-2.424-.336-1.728 0-3.04.512-3.936 1.536-.896 1.024-1.344 2.544-1.344 4.56 0 2.016.528 3.592 1.584 4.728.544.592 1.192.888 1.944.888s1.952-.4 3.6-1.2c.576-.272.96-.408 1.152-.408.416 0 .624.216.624.648 0 .432-.2.792-.6 1.08-1.376.72-2.448 1.208-3.216 1.464-.768.24-1.432.36-1.992.36-1.152 0-2.136-.424-2.952-1.272-1.456-1.568-2.184-3.704-2.184-6.408 0-2.72.688-4.728 2.064-6.024 1.392-1.312 3.056-1.968 4.992-1.968zM74.135 22.264c0-1.232-.08-3.312-.24-6.24-.144-2.944-.272-4.808-.384-5.592 0-.352.12-.656.36-.912.24-.272.512-.408.816-.408.384 0 .64.24.768.72.256 1.6.416 3.904.48 6.912 1.44-1.328 2.552-2.464 3.336-3.408.8-.944 1.64-2.152 2.52-3.624.256-.432.632-.648 1.128-.648.256 0 .464.072.624.216.176.128.264.288.264.48 0 .512-.456 1.4-1.368 2.664a56.078 56.078 0 01-2.856 3.648 20.248 20.248 0 013.456 4.656c.128.224.296.504.504.84.208.336.368.6.48.792.304.528.456.976.456 1.344 0 .368-.096.672-.288.912a.819.819 0 01-.672.336c-.272 0-.624-.352-1.056-1.056-.432-.72-1.056-1.728-1.872-3.024-.8-1.312-1.648-2.464-2.544-3.456-.896.864-1.568 1.464-2.016 1.8a56.5 56.5 0 01.072 2.568c0 .672-.016 1.216-.048 1.632-.096 1.04-.52 1.56-1.272 1.56-.464 0-.68-.28-.648-.84v-1.872zM86.265 16.744a.697.697 0 01-.336-.624c0-.272.088-.52.264-.744-.064-1.6-.096-3.288-.096-5.064.096-.384.24-.664.432-.84.208-.176.504-.288.888-.336 2.112.096 4.4.144 6.864.144.608.128.912.392.912.792 0 .672-.656 1.064-1.968 1.176-.352.016-.736.024-1.152.024h-1.56c-.304 0-1.144-.064-2.52-.192 0 2 .032 3.376.096 4.128.848.016 2.48.024 4.896.024.576.112.864.376.864.792 0 .4-.232.712-.696.936a.929.929 0 01-.264.096l-4.152-.072a3.29 3.29 0 00-.624.048l.096 4.128c0 .928-.024 1.592-.072 1.992l5.568-.072c.512.08.768.296.768.648 0 .24-.112.48-.336.72-.208.24-.456.392-.744.456L87.25 25c-.368 0-.624-.064-.768-.192-.144-.144-.216-.376-.216-.696.064-.448.096-1.168.096-2.16v-1.68l-.096-3.528zM96.618 9.424l9.72-.144c.464.144.696.376.696.696 0 .8-.328 1.2-.984 1.2-1.2 0-2.472.032-3.816.096-.08 1.376-.12 2.416-.12 3.12v1.32l.096 8.424c0 .496-.128.784-.384.864a2.306 2.306 0 01-.72.096c-.464 0-.72-.264-.768-.792-.096-1.232-.144-3.528-.144-6.888 0-3.376.048-5.408.144-6.096-.336.016-.832.024-1.488.024s-1.472-.008-2.448-.024c-.256 0-.456-.08-.6-.24a.831.831 0 01-.216-.576c0-.24.096-.472.288-.696.208-.224.456-.352.744-.384zM107.437 21.664l.024-1.872.216-10.032c0-.192.104-.344.312-.456.208-.112.472-.168.792-.168.768 0 1.152.272 1.152.816 0 .176-.096 1.52-.288 4.032-.176 2.512-.264 4.016-.264 4.512v2.544c0 1.2.08 1.856.24 1.968.24.08.52.12.84.12l3.456-.24c.752 0 1.128.272 1.128.816 0 .432-.208.752-.624.96-.4.192-.8.304-1.2.336-.4.016-.888.024-1.464.024-2.512 0-3.872-.08-4.08-.24-.112-.096-.176-.456-.192-1.08a41.976 41.976 0 00-.048-1.344v-.696zM123.063 9.04c1.12 0 2.072.36 2.856 1.08 1.536 1.376 2.304 3.552 2.304 6.528 0 2.96-.848 5.288-2.544 6.984-.88.848-1.896 1.312-3.048 1.392-1.52 0-2.704-.52-3.552-1.56a9.69 9.69 0 01-1.824-3.48c-.352-1.296-.528-2.544-.528-3.744 0-2.048.488-3.736 1.464-5.064 1.024-1.424 2.648-2.136 4.872-2.136zm-.168 1.992c-2.144 0-3.48 1.016-4.008 3.048-.16.544-.24 1.24-.24 2.088 0 .848.16 1.832.48 2.952.432 1.504 1.072 2.56 1.92 3.168.496.384 1.096.576 1.8.576s1.336-.312 1.896-.936c.56-.64.944-1.448 1.152-2.424.208-.976.312-1.96.312-2.952 0-1.76-.256-3.12-.768-4.08-.496-.96-1.344-1.44-2.544-1.44zM136.999 9.064c.768 0 1.528.192 2.28.576.768.384 1.152.816 1.152 1.296 0 .736-.304 1.104-.912 1.104-.224 0-.616-.144-1.176-.432-.56-.288-1.032-.432-1.416-.432-1.376 0-2.528.616-3.456 1.848-.912 1.232-1.368 2.8-1.368 4.704 0 1.424.312 2.672.936 3.744.624 1.072 1.36 1.608 2.208 1.608.864 0 1.536-.28 2.016-.84.496-.576.744-1.224.744-1.944 0-.4-.032-.728-.096-.984a1.27 1.27 0 00-.408-.72c-.224-.224-.52-.336-.888-.336s-.72-.08-1.056-.24c-.32-.16-.48-.376-.48-.648s.08-.528.24-.768a.953.953 0 01.648-.432c1.088 0 1.816.112 2.184.336.384.224.672.408.864.552.192.144.352.384.48.72.128.336.224.616.288.84.08.224.136.584.168 1.08.032.832.048 1.808.048 2.928 0 1.104-.08 1.784-.24 2.04-.144.208-.384.32-.72.336-.336 0-.568-.072-.696-.216-.128-.144-.208-.464-.24-.96-.384.336-.872.624-1.464.864-.576.224-1.088.336-1.536.336-1.408 0-2.592-.744-3.552-2.232-.96-1.504-1.44-3.312-1.44-5.424 0-1.12.184-2.216.552-3.288.368-1.088.864-2 1.488-2.736 1.312-1.52 2.928-2.28 4.848-2.28z" fill="#374151"/>
            </g>
            <defs>
            <linearGradient id="paint0_linear" x1="10" y1="2" x2="20.5" y2="33" gradientUnits="userSpaceOnUse">
            <stop stop-color="#D326C2"/>
            <stop offset="1" stop-color="#4E19BD"/>
            </linearGradient>
            <clipPath id="clip0">
            <path fill="#fff" d="M0 0h143v32H0z"/>
            </clipPath>
            </defs>
        </svg>

        <h2 class="mt-10 font-bold text-3xl leading-snug text-gray-900">Is your todo list a guilt-trip of things you thought were important but haven't done?</h2>
        <p class="mt-6 text-lg text-gray-500">We've been there too. You have lots of things you want to get done. You store them so you won't forget. But now you're facing a seemingly-insurmountable list of varying priorities that just causes more stress.</p>

        <h2 class="mt-10 font-bold text-2xl leading-snug text-gray-900">RocketLog helps you focus on the things you actually care about so your mind is free for creativity and deep work.</h2>

        <p class="mt-6 text-lg text-gray-500">By following the well-established practices of <a href="https://bulletjournal.com/pages/learn" class="text-gray-900 underline font-medium" target="_blank" rel="noopener">rapid logging and migration</a>, you will always know what your priorities are, while the unimportant things just fade away, guilt-free.</p>

        <img class="mt-10 w-48 mx-auto" src="/images/to-the-stars.svg" />

        <div class="mt-4 max-w-xl mx-auto text-center">
            <a href="{{ route('register') }}" class="px-6 py-3 inline-block bg-gradient-to-br from-pink-500 to-purple-700 text-xl font-bold text-white rounded-lg shadow-lg hover:from-pink-600 hover:to-purple-800">Unburden your mind</a>
            <p class="mt-6 text-base text-gray-500">RocketLog is privacy-respecting open-source software with a premium hosted option for your convenience.</p>
            <p class="mt-6 text-base text-gray-500"><strong>Start your free 7 day trial with no upfront credit card.</strong></p>
        </div>

        <div class="mt-10 flex items-center px-4 py-6 border shadow-md rounded-md">
            <img src="/images/jess-archer.jpg" class="flex-shrink-0 block h-16 w-16 rounded-full" />
            <div class="ml-4 text-base text-gray-500">
            <p><strong>Created by <a class="underline font-medium text-gray-900" href="https://jessarcher.com" target="_blank">Jess Archer</a></strong></p>
            <p>Digital maker, podcaster, speaker, and fan of bullet journalling.</p>
            </div>
        </div>

        <div class="mt-10 prose prose-lg text-gray-500">
            <h3>Why another todo list?</h3>
            <p><strong>RocketLog is not your average todo list. It's a fan-letter to bullet-journalling, rapid-logging, and task migration.</strong></p>
            <p>Many of the limitations of a paper journal are what make them so good for focus and prioritisation.</p>
            <p>The process of <a href="https://bulletjournal.com/pages/learn" class="text-gray-900 underline font-medium" target="_blank" rel="noopener">bullet journalling</a> gives you an organisation system to manage this.</p>
            <p>RocketLog makes this digital, while also providing conveniences that aren't possible with paper.</p>
        </div>
    </div>

    <div class="px-4 md:p-10 max-w-3xl lg:max-w-5xl mx-auto">
        <div class="lg:flex">
            <div class="lg:w-3/5 lg:pr-10 prose prose-lg text-gray-500">
                <h3>How does it work?</h3>
                <p>As you add new tasks to your todo list, the older incomplete tasks naturally fall out of view, unless you migrate them forward.</p>
                <p><strong>This naturally causes you to reassess what's still important versus what only felt important at the time.</strong></p>
                <p>If you don't complete or migrate a task forward, it will start fading away.</p>
                <p>This gives you a more organic and truer representation of what is important to you. No arbitrary priority rankings, and no "smart" automated prioritisation.</p>
            </div>

            <div class="mt-10 lg:mt-0 lg:flex-1">
                <div class="p-4 max-w-md mx-auto sm:p-6 md:p-12 bg-white darkx:bg-gray-800 overflow-hidden sm:rounded-lg md:shadow-xl">
                    <div
                        x-data="{
                            date: '{{ date('D, M j') }}',
                            days: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                            months: ['Jan', 'Feb', 'Mar', 'Apr', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                            setCurrentDate() {
                                let date = new Date
                                let day = date.getDay()
                                let month = date.getMonth()
                                this.date = this.days[day] + ', ' + this.months[month] + ' ' + date.getDate()
                            }
                        }"
                        x-init="setCurrentDate"
                        class="pb-3 font-bold border-b border-gray-200 darkx:border-gray-700 text-gray-800 darkx:text-gray-200"
                    >
                        <span x-text="date">{{ date('D, M j') }}</span>
                    </div>

                    <div class="py-1 md:py-2 border-b border-gray-200 darkx:border-gray-700 flex">
                        <div class="relative flex-shrink-0 opacity-50">
                            <div class="border border-transparent">
                                <div class="h-10 w-10 md:h-8 md:w-8 flex items-center justify-center rounded-full border border-transparent text-gray-900 darkx:text-gray-100">
                                    <svg class="h-6 w-6 md:h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="w-full p-2 md:p-1 overflow-hidden bg-transparent border-none disabled:opacity-75 text-gray-900 darkx:text-gray-100 opacity-50">
                            Be awesome
                        </div>
                    </div>

                    <div class="py-1 md:py-2 border-b border-gray-200 darkx:border-gray-700 flex">
                        <div class="relative flex-shrink-0 opacity-50">
                            <div class="border border-transparent">
                                <div class="h-10 w-10 md:h-8 md:w-8 flex items-center justify-center rounded-full border border-transparent text-gray-900 darkx:text-gray-100">
                                    <svg class="h-6 w-6 md:h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="w-full p-2 md:p-1 overflow-hidden bg-transparent border-none disabled:opacity-75 text-gray-900 darkx:text-gray-100 opacity-50">
                            Read about a cool new app
                        </div>
                    </div>

                    <div class="py-1 md:py-2 border-b border-gray-200 darkx:border-gray-700 flex">
                        <div x-data="{ menu: false }" class="relative flex-shrink-0">
                            <div class="border border-transparent">
                                <button
                                    class="h-10 w-10 md:h-8 md:w-8 flex items-center justify-center rounded-full border border-transparent text-gray-900 darkx:text-gray-100 hover:border-gray-200 darkx:hover:border-gray-600 hover:shadow focus:outline-none focus:border-gray-200 darkx:focus:border-gray-600 focus:shadow-inner disabled:opacity-50"
                                    @click="menu = true"
                                >
                                    <svg class="h-6 w-6 md:h-5" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path d="M7.8 10a2.2 2.2 0 0 0 4.4 0 2.2 2.2 0 0 0-4.4 0z"></path>
                                    </svg>
                                </button>
                            </div>

                            <div
                                x-show.transition.opacity="menu"
                                class="absolute top-0 left-0 -ml-2 inline-flex px-2 rounded-full text-gray-700 darkx:text-gray-300 border border-gray-200 darkx:border-gray-500 bg-white darkx:bg-gray-700 shadow-xl z-50 overflow-hidden"
                                @click.away="menu = false"
                            >
                                <button @click="menu = false" class="h-10 w-10 md:h-8 md:w-8 flex items-center justify-center focus:bg-gray-100 darkx:focus:bg-gray-800 focus:outline-none">
                                    <svg class="h-6 w-6 md:h-5" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path d="M7.8 10a2.2 2.2 0 0 0 4.4 0 2.2 2.2 0 0 0-4.4 0z"></path>
                                    </svg>
                                </button>
                                <div class="h-10 md:h-8 pr-4 flex items-center font-medium text-gray-800 whitespace-nowrap">10% off code: <code class="px-1 text-pink-600 font-semibold">IFOUNDIT</code></div>
                            </div>
                        </div>
                        <div class="w-full p-2 md:p-1 overflow-hidden bg-transparent border-none disabled:opacity-75 text-gray-900 darkx:text-gray-100">
                            Check out RocketLog
                        </div>
                    </div>

{{--                     <div class="py-1 md:py-2 border-b border-gray-200 darkx:border-gray-700 flex"> --}}
{{--                         <div class="relative flex-shrink-0"> --}}
{{--                             <a href="{{ route('register') }}" class="h-10 w-10 md:h-8 md:w-8 flex items-center justify-center rounded-full border border-transparent text-gray-200 darkx:text-gray-700 hover:border-gray-200 darkx:hover:border-gray-600 hover:shadow focus:outline-none focus:border-gray-200 darkx:focus:border-gray-600 focus:shadow-inner disabled:opacity-50"> --}}
{{--                                 <svg class="h-6 w-6 md:h-5" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"> --}}
{{--                                     <path d="M7.8 10a2.2 2.2 0 0 0 4.4 0 2.2 2.2 0 0 0-4.4 0z"></path> --}}
{{--                                 </svg> --}}
{{--                             </a> --}}
{{--                         </div> --}}
{{--                         <div class="w-full p-2 md:p-1 overflow-hidden bg-transparent border-none disabled:opacity-75 text-gray-300 darkx:text-gray-600"> --}}
{{--                             Unburden your mind... --}}
{{--                         </div> --}}
{{--                     </div> --}}

                    <div class="mt-12 pb-3 font-bold border-b border-gray-200 darkx:border-gray-700 text-gray-800 darkx:text-gray-200 opacity-25">
                        {{ date('D, M j', strtotime('5 days ago')) }}
                    </div>

                    <div class="py-1 md:py-2 border-b border-gray-200 darkx:border-gray-700 flex opacity-25">
                        <div class="relative flex-shrink-0">
                            <div class="border border-transparent">
                                <div class="h-10 w-10 md:h-8 md:w-8 flex items-center justify-center rounded-full border border-transparent text-gray-900 darkx:text-gray-100">
                                    <svg class="h-6 w-6 md:h-5" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path d="M7.8 10a2.2 2.2 0 0 0 4.4 0 2.2 2.2 0 0 0-4.4 0z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="w-full p-2 md:p-1 overflow-hidden bg-transparent border-none disabled:opacity-75 text-gray-900 darkx:text-gray-100">
                            Paint the bike shed
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="p-4 md:p-10 max-w-3xl mx-auto">
        <h3 class="mt-10 text-2xl font-semibold text-gray-900">One simple plan. All of the features.</h3>
        <div class="mt-10 grid sm:grid-cols-2 gap-6 max-w-xs sm:max-w-none mx-auto">
            <div class="p-6 border rounded-md shadow-md text-center">
                <p class="tracking-tight">
                    <span class="font-semibold text-indigo-600"><sup class="text-4xl">$</sup><span class="text-7xl">9</span></span> <span class="text-lg font-semibold text-gray-500">/month</span>
                </p>
                <p class="mt-4">
                    <a href="{{ route('register') }}" class="px-4 py-2 inline-block bg-gradient-to-br from-pink-500 to-purple-700 font-bold text-white rounded-lg shadow-lg hover:from-pink-600 hover:to-purple-800">Start free trial</a>
                </p>
                <p class="mt-2 text-gray-700"><small>No credit card required</small></p>
            </div>

            <div class="p-6 border rounded-md shadow-md text-center">
                <p class="tracking-tight">
                    <span class="font-semibold text-indigo-600"><sup class="text-4xl">$</sup><span class="text-7xl">90</span></span> <span class="text-lg font-semibold text-gray-500">/year</span>
                </p>
                <p class="mt-4">
                    <a href="{{ route('register') }}" class="px-4 py-2 inline-block bg-gradient-to-br from-pink-500 to-purple-700 font-bold text-white rounded-lg shadow-lg hover:from-pink-600 hover:to-purple-800">Start free trial</a>
                </p>
                <p class="mt-2 text-gray-700"><small>No credit card required</small></p>
            </div>
        </div>

        <h3 class="mt-10 text-2xl font-semibold text-gray-900">Features</h3>
        <ul class="mt-6 flex-wrap text-lg text-gray-500">
            <li class="mt-0 flex">
                <svg class="mr-2 h-6 flex-shrink-0 text-pink-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Daily Log - the heart of your system.
            </li>
            <li class="mt-4 flex">
                <svg class="mr-2 h-6 flex-shrink-0 text-pink-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Collections - create fixed lists to manage projects, book recommendations, menu planning, and more!
            </li>
            <li class="mt-4 flex">
                <svg class="mr-2 h-6 flex-shrink-0 text-pink-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Share your collections with others - great for collaborative projects and family shopping lists.
            </li>
            <li class="mt-4 flex">
                <svg class="mr-2 h-6 flex-shrink-0 text-pink-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Show or hide complete items - sometimes you want to see how much you've done, and sometimes you just want to focus on what's left.
            </li>
            <li class="mt-4 flex">
                <svg class="mr-2 h-6 flex-shrink-0 text-pink-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Access your RocketLog from any device with a web browser
            </li>
            <li class="mt-4 flex">
                <svg class="mr-2 h-6 flex-shrink-0 text-pink-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Dark Mode - Because why not?
            </li>
        </ul>

        <div class="mt-10 prose prose-lg text-gray-500">
            <h3>RocketLog respects your privacy and freedom</h3>
            <p>The RocketLog software project is open-source and free to self-host. We believe in maintaining the privacy of <em>your</em> data. We believe that you should be free to see "under the hood" of the software you use, and be able modify it if you see fit.</p>

            {{-- <h3>What if I can't or don't want to host it myself?</h3> --}}
            <p>While RocketLog is completely free to host yourself, we understand that not everyone has the time or knowledge to manage software hosting themselves.</p>
            <p>That's why we offer a premium hosted option for your convenience. We'd be honoured to take care of your data for you and do not take that trust lightly. We won't share anything with third parties and we don't include any of the invasive tracking code that is prevalent on so many services these days.</p>
            <p>You will also be helping to support the ongoing development of the project.</p>
        </div>


        <div class="mt-10 text-center">
            <a href="{{ route('register') }}" class="px-6 py-3 inline-block bg-gradient-to-br from-pink-500 to-purple-700 text-xl font-bold text-white rounded-lg shadow-lg hover:from-pink-600 hover:to-purple-800">Unburden your mind</a>
        </div>

        <p class="mt-6 text-center">
            <a href="https://github.com/jessarcher/rocketlog" class="text-gray-700 hover:underline"><svg class="w-5 h-5 inline-block text-gray-500 mr-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512"><path d="M165.9 397.4c0 2-2.3 3.6-5.2 3.6-3.3.3-5.6-1.3-5.6-3.6 0-2 2.3-3.6 5.2-3.6 3-.3 5.6 1.3 5.6 3.6zm-31.1-4.5c-.7 2 1.3 4.3 4.3 4.9 2.6 1 5.6 0 6.2-2s-1.3-4.3-4.3-5.2c-2.6-.7-5.5.3-6.2 2.3zm44.2-1.7c-2.9.7-4.9 2.6-4.6 4.9.3 2 2.9 3.3 5.9 2.6 2.9-.7 4.9-2.6 4.6-4.6-.3-1.9-3-3.2-5.9-2.9zM244.8 8C106.1 8 0 113.3 0 252c0 110.9 69.8 205.8 169.5 239.2 12.8 2.3 17.3-5.6 17.3-12.1 0-6.2-.3-40.4-.3-61.4 0 0-70 15-84.7-29.8 0 0-11.4-29.1-27.8-36.6 0 0-22.9-15.7 1.6-15.4 0 0 24.9 2 38.6 25.8 21.9 38.6 58.6 27.5 72.9 20.9 2.3-16 8.8-27.1 16-33.7-55.9-6.2-112.3-14.3-112.3-110.5 0-27.5 7.6-41.3 23.6-58.9-2.6-6.5-11.1-33.3 2.6-67.9 20.9-6.5 69 27 69 27 20-5.6 41.5-8.5 62.8-8.5s42.8 2.9 62.8 8.5c0 0 48.1-33.6 69-27 13.7 34.7 5.2 61.4 2.6 67.9 16 17.7 25.8 31.5 25.8 58.9 0 96.5-58.9 104.2-114.8 110.5 9.2 7.9 17 22.9 17 46.4 0 33.7-.3 75.4-.3 83.6 0 6.5 4.6 14.4 17.3 12.1C428.2 457.8 496 362.9 496 252 496 113.3 383.5 8 244.8 8zM97.2 352.9c-1.3 1-1 3.3.7 5.2 1.6 1.6 3.9 2.3 5.2 1 1.3-1 1-3.3-.7-5.2-1.6-1.6-3.9-2.3-5.2-1zm-10.8-8.1c-.7 1.3.3 2.9 2.3 3.9 1.6 1 3.6.7 4.3-.7.7-1.3-.3-2.9-2.3-3.9-2-.6-3.6-.3-4.3.7zm32.4 35.6c-1.6 1.3-1 4.3 1.3 6.2 2.3 2.3 5.2 2.6 6.5 1 1.3-1.3.7-4.3-1.3-6.2-2.2-2.3-5.2-2.6-6.5-1zm-11.4-14.7c-1.6 1-1.6 3.6 0 5.9 1.6 2.3 4.3 3.3 5.6 2.3 1.6-1.3 1.6-3.9 0-6.2-1.4-2.3-4-3.3-5.6-2z"></path></svg>Get the source code on GitHub</a>
        </p>

        <div class="mt-10 prose prose-sm text-center mx-auto">
            <p>
                <a href="{{ route('terms.show') }}">Terms of Service</a>&nbsp;&nbsp;
                <a href="{{ route('policy.show') }}">Privacy policy</a>
            </p>
            <p>RocketLog is not affiliated with Bullet Journal, just a big fan 🤩</p>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.1/dist/alpine.min.js" defer></script>
@endpush
