<x-app-layout>
    @push('search')
        <script>
            $(document).ready(function() {                
                $(".search").click(function(e) {
                    e.preventDefault();
                    $(".searchRec").toggleClass("hidden");
                });
            });
        </script>
        <script>
            $(document).ready(function() {
                $('#search').on('keyup', function() {
                    const query = $(this).val();

                    $.ajax({
                        url: "{{ route('search') }}",
                        type: "GET",
                        data: {
                            query: query
                        },
                        success: function(response) {
                            if (query == "") {
                                $('.dropdown-content').empty();
                                return;
                            }
                            // Hapus elemen sebelum menambahkan yang baru
                            $('.dropdown-content').empty();
                            $('.dropdown-content').removeClass("items-center justify-center");

                            console.log(response);

                            if (response.events.length == 0) {
                                $('.dropdown-content').addClass("items-center justify-center");
                                const listItem =
                                    '<li class="block"><div class="flex items-center gap-6">No Data...</div></li>';
                                $('.dropdown-content').append(listItem);
                            } else {
                                // Loop melalui hasil pencarian dan tambahkan ke dropdown
                                $.each(response.events, function(index, event) {
                                    // Assuming event.id and event.image_url are properties of the event object
                                    const cleanedPosterPath = event.posters.poster_path.replace('public/', '/storage/');
                                    const listItem = '<li><a href="/detail-event/' + event.id +
                                        '" class="flex items-center gap-6"><img src="' +
                                        cleanedPosterPath +
                                        '" alt="" class="bg-gray-400 w-20 h-20">' + event
                                        .title + '</a></li>';
                                    $('.dropdown-content').append(listItem);
                                });
                            }

                        },
                        error: function(response) {
                            $('.dropdown-content').empty();
                            $('.dropdown-content').addClass("items-center justify-center");
                            const listItem =
                                '<li><div class="flex items-center gap-6">No Data...</div></li>';
                            $('.dropdown-content').append(listItem);
                        }
                    });
                });
            });
        </script>
    @endpush

    {{-- Header --}}
    <header class="w-full text-white bg-[#32324A]/90 shadow-sm body-font sticky top-0 z-40">

        {{-- Header Container --}}
        <div class="container flex items-center justify-between p-4 mx-auto flex-row">
            <a class="flex items-center">
                {{-- Logo --}}
                <img class="mx-auto inset-0 h-[52px]" src="Logo.svg" alt="">
            </a>

            {{-- Search --}}
            <div class="absolute inset-x-0">
                <div
                    class="dropdown dropdown-bottom flex flex-wrap items-center justify-center text-base ml-auto mr-auto">
                    <label class="relative search">
                        <input type="text" id="search"
                            class="px-10 w-96 bg-[#FFFFFF]/20 border focus-within:border-white border-[#FFFFFF]/50 rounded-xl"
                            placeholder="Search . . .">

                        {{-- SVG in Placeholder --}}
                        <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5" width="25"
                            height="24" viewBox="0 0 25 24" fill="#fff" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M15.9848 14H15.1948L14.9148 13.73C15.5398 13.0039 15.9965 12.1487 16.2524 11.2256C16.5082 10.3024 16.5569 9.33413 16.3948 8.38998C15.9248 5.60998 13.6048 3.38997 10.8048 3.04997C9.82045 2.92544 8.82063 3.02775 7.88186 3.34906C6.9431 3.67038 6.09028 4.20219 5.38867 4.90381C4.68706 5.60542 4.15524 6.45824 3.83393 7.397C3.51261 8.33576 3.4103 9.33559 3.53484 10.32C3.87484 13.12 6.09484 15.44 8.87484 15.91C9.81899 16.072 10.7873 16.0234 11.7105 15.7675C12.6336 15.5117 13.4888 15.0549 14.2148 14.43L14.4848 14.71V15.5L18.7348 19.75C19.1448 20.16 19.8148 20.16 20.2248 19.75C20.6348 19.34 20.6348 18.67 20.2248 18.26L15.9848 14ZM9.98484 14C7.49484 14 5.48484 11.99 5.48484 9.49997C5.48484 7.00997 7.49484 4.99997 9.98484 4.99997C12.4748 4.99997 14.4848 7.00997 14.4848 9.49997C14.4848 11.99 12.4748 14 9.98484 14Z" />
                        </svg>
                        <div class="serchRec absolute gap-4 overflow-y-auto  w-30 max-h-10 h-10 top-10 rounded-md w-full flex px-10 flex-col py-8">
                            
                        </div>
                    </label>

                    {{-- Dropdown Search - Optional --}}
                    <ul tabindex="0"
                        class="h-32 h-max-28 overflow-y-auto text-black block dropdown-content flex-col z-[1] menu p-2 shadow bg-[#FFFFFF] hover:text-[#fff] focus-within:border-white rounded-box w-1/4">
                        
                    </ul>
                </div>
            </div>
            @if (Route::has('login'))
                <div class="items-center h-full z-10">
                    @auth
                        <div class="hidden sm:flex sm:items-center sm:ms-6">
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                        <div>{{ Auth::user()->name }}</div>

                                        <div class="ms-1">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    <x-dropdown-link :href="route('profile.edit')">
                                        {{ __('Profile') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('myEvent')">
                                        {{ __('My Events') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('eventRequest.index')">
                                        {{ __('My Event Requests') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('eventRequest.create.fromUser')">
                                        {{ __('Make Event Requests') }}
                                    </x-dropdown-link>

                                    <!-- Authentication -->
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf

                                        <x-dropdown-link :href="route('logout')"
                                            onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                            {{ __('Log Out') }}
                                        </x-dropdown-link>
                                    </form>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    @else
                        <a href="{{ route('login') }}"
                            class="px-6 py-2 font-semibold bg-[#fff]/20 rounded-lg mr-4">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="px-4 py-2 font-semibold bg-[#9595D8] rounded-lg">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
    </header>

    {{-- Layout --}}
    <div class="min-h-screen grid grid-cols-6 gap-2 relative overflow-auto mx-auto px-36 pt-16"
        style="background-image: url({{ asset('BG.png') }}); background-size: cover; font-family: 'Montserrat';">

        {{-- Caroousel --}}
        <div class="p-4  col-span-4 shadow-lg rounded-lg">
            <div id="default-carousel" class="relative w-full h-[451px]" data-carousel="slide">
                <!-- Carousel wrapper -->
                <div class="relative overflow-hidden h-full">
                    <!-- Item 1 -->
                    <div style="background-image: url({{ asset('Banner1.png') }});"
                        class="hidden duration-[2000ms] ease-in-out bg-center bg-no-repeat bg-cover shadow-inner rounded-sm"
                        data-carousel-item>
                        <div class="bg-[#000]/70 h-full">
                            <img src="Banner1.png"
                                class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                                alt="...">
                        </div>
                    </div>
                    <!-- Item 2 -->
                    <div style="background-image: url({{ asset('web-banner-pengumuman-kelulusan-jpa-1-tahap-1-telkom-university-2024.jpg') }});"
                        class="hidden duration-[2000ms] ease-in-out bg-center bg-no-repeat bg-cover shadow-inner rounded-sm"
                        data-carousel-item>
                        <div class="bg-[#000]/70 h-full">
                            <img src="web-banner-pengumuman-kelulusan-jpa-1-tahap-1-telkom-university-2024.jpg"
                                class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                                alt="...">
                        </div>
                    </div>
                    <!-- Item 3 -->
                    <div style="background-image: url({{ asset('Banner1.png') }});"
                        class="hidden duration-[2000ms] ease-in-out bg-center bg-no-repeat bg-cover shadow-inner rounded-sm"
                        data-carousel-item>
                        <div class="bg-[#000]/70 h-full">
                            <img src="Banner1.png"
                                class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                                alt="...">
                        </div>
                    </div>
                    <!-- Item 4 -->
                    <div style="background-image: url({{ asset('web-banner-pengumuman-kelulusan-jpa-1-tahap-1-telkom-university-2024.jpg') }});"
                        class="hidden duration-[2000ms] ease-in-out bg-center bg-no-repeat bg-cover shadow-inner rounded-sm"
                        data-carousel-item>
                        <div class="bg-[#000]/70 h-full">
                            <img src="web-banner-pengumuman-kelulusan-jpa-1-tahap-1-telkom-university-2024.jpg"
                                class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                                alt="...">
                        </div>
                    </div>
                    <!-- Item 5 -->
                    <div style="background-image: url({{ asset('Banner1.png') }});"
                        class="hidden duration-[2000ms] ease-in-out bg-center bg-no-repeat bg-cover shadow-inner rounded-sm"
                        data-carousel-item>
                        <div class="bg-[#000]/70 h-full">
                            <img src="Banner1.png"
                                class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                                alt="...">
                        </div>
                    </div>
                    <!-- Item 6 -->
                    <div style="background-image: url({{ asset('web-banner-pengumuman-kelulusan-jpa-1-tahap-1-telkom-university-2024.jpg') }});"
                        class="hidden duration-[2000ms] ease-in-out bg-center bg-no-repeat bg-cover shadow-inner rounded-sm"
                        data-carousel-item>
                        <div class="bg-[#000]/70 h-full">
                            <img src="web-banner-pengumuman-kelulusan-jpa-1-tahap-1-telkom-university-2024.jpg"
                                class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                                alt="...">
                        </div>
                    </div>
                </div>
                <!-- Slider controls -->
                <button type="button"
                    class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                    data-carousel-prev>
                    <span
                        class="inline-flex items-center justify-center w-10 h-10 rounded-md bg-black/30 group-hover:bg-black/50 group-focus:ring-4 group-focus:outline-none">
                        <svg class="w-4 h-4 text-white rtl:rotate-180" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 1 1 5l4 4" />
                        </svg>
                        <span class="sr-only">Previous</span>
                    </span>
                </button>
                <button type="button"
                    class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                    data-carousel-next>
                    <span
                        class="inline-flex items-center justify-center w-10 h-10 rounded-md bg-black/30 group-hover:bg-black/50 group-focus:ring-4 group-focus:outline-none">
                        <svg class="w-4 h-4 text-white rtl:rotate-180" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 9 4-4-4-4" />
                        </svg>
                        <span class="sr-only">Next</span>
                    </span>
                </button>
            </div>

        </div>

        {{-- Event 7 Hari ke depan --}}
        <div class="bg-black/50 h-full col-span-2 shadow-lg rounded-lg text-white">
            <div class="bg-[#32324A]/50 sticky py-2 pl-4  items-center justify-center rounded-t-lg">
                <h1 class="text-3xl pb-2 text-white underline underline-offset-8"><span
                        class="text-[#9595D8] underline underline-offset-8">Event</span> 7 Hari Kedepan</h1>
            </div>
            <div class="overflow-y-auto max-h-[418px] rounded-b-lg p-5 gap-2 hidden-scrol">

                {{-- Looping di sini --}}
                @foreach ($eventsThisWeek as $item)
                    <a href="{{ route('detail-event', $item) }}">
                        <div class="grid grid-cols-2 mb-10">
                            <div>
                                <img class="w-full" src="{{ Storage::url($item->posters->poster_path) }}"
                                    alt="">
                            </div>
                            <div class="pl-3">
                                <h1 class="text-3xl font-bold">{{ $item->name }}</h1>
                                <div class="overflow-y-auto max-h-[100px] hidden-scrol">
                                    <h3 class="">
                                        {{ $item->description }}
                                    </h3>
                                </div>
                                <div class="overflow-y-auto max-h-[300px] hidden-scrol">
                                    <h2 class="text-lg font-semibold pt-1">Penyelenggara</h2>
                                    <h3>{{ $item->user->name }}</h3>
                                    <h2 class="text-lg font-semibold pt-1">Diselenggarkan pada :</h2>
                                    <h3> {{ \Carbon\Carbon::parse($item->start_date)->format('d M Y') }}</h3>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        {{-- Jadwal Event --}}
        <div class="px-4 col-span-6 shadow-lg rounded-lg">
            <div class="w-full mb-1">
                <h1 class="text-5xl text-white underline underline-offset-8 mt-4">Jadwal <span
                        class="text-[#9595D8] underline underline-offset-8">Event</span></h1>
                <div class="flex items-center justify-center w-full mx-auto h-full pt-24 sm:py-8">
                    <div class="w-full relative flex items-center justify-center">
                        <div class="bg-gradient-to-r from-[#000]/40 h-full absolute left-0 z-30 pr-20 rounded-l-xl">
                        </div>
                        <button aria-label="slide backward"
                            class="absolute bg-[#000000]/50 h-12 w-12 p-3 rounded-full flex flex-col justify-center items-center z-30 left-0 ml-5 focus:outline-none focus:bg-[#000]/70 focus:ring-2 focus:ring-offset-2 focus:ring-[#000]/70 hover:[#000]/70 hover:text-white text-white focus:text-white"
                            id="prev">
                            <svg class="" viewBox="0 0 8 14" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M7 1L1 7L7 13" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </button>
                        <div class="w-full h-full mx-auto overflow-x-hidden overflow-y-hidden rounded-xl">
                            <div id="slider"
                                class="h-full flex lg:gap-8 md:gap-6 gap-14 items-center justify-start transition ease-out duration-700">

                                {{-- Looping di sini --}}
                                @foreach ($eventsThisMonth as $item)
                                    <div class="flex flex-shrink-0 relative h-[30rem] w-full sm:w-auto rounded-2xl">
                                        <a href="{{ route('detail-event', $item) }}">
                                            <img src="{{ Storage::url($item->posters->poster_path) }}"
                                                alt="black chair and white table"
                                                class="rounded-2xl object-cover object-center w-80 h-full" />
                                        </a>
                                    </div>
                                @endforeach                                

                            </div>
                        </div>
                        <div class="bg-gradient-to-l from-[#000]/50 h-full absolute z-30 right-0 pl-20 rounded-r-xl">
                        </div>
                        <button aria-label="slide forward"
                            class="absolute z-30 right-0 mr-5 bg-[#000000]/40 h-12 w-12 p-3 rounded-full flex flex-col justify-center items-center focus:outline-none focus:bg-[#000]/70 focus:ring-2 focus:ring-offset-2 focus:ring-[#000]/70 hover:[#000]/70 hover:text-white text-white focus:text-white"
                            id="next">
                            <svg class="" viewBox="0 0 8 14" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 1L7 7L1 13" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Dokumentasi --}}
        <div class="col-span-6 shadow-lg rounded-lg mb-16">
            <h1 class="text-5xl text-white underline underline-offset-8 mb-14">Dokumentasi</h1>

            <div class="grid grid-cols-4 gap-x-12">
                <div>
                    <img class="w-full" src="Frame 37330.png" alt="">
                </div>
                <div>
                    <img class="w-full" src="Frame 37331.png" alt="">
                </div>
                <div>
                    <img class="w-full" src="Frame 37332.png" alt="">
                </div>
                <div>
                    <img class="w-full" src="Frame 37335.png" alt="">
                </div>
            </div>
        </div>


    </div>

    <footer class="w-full bg-[#32324A] p-7">
        <div class="container flex items-center justify-between px-14 mx-auto flex-row">
            <div class="items-center h-full">
                <svg width="148" height="24" viewBox="0 0 148 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M3.5625 8.21875H9.9375V10H3.5625V17.0312H10.9688V18.8125H1.40625V0.53125H10.5V2.3125H3.5625V8.21875ZM21.875 18.8125L17.9375 5.96875H19.9062L22.8125 15.7188H23L25.9062 5.96875H27.875L23.9375 18.8125H21.875ZM34.8438 5.96875H36.9062L40.0938 14.7812H40.1875L42.9062 5.96875H44.9688L40.6562 19.4688C40.0938 21.2188 39.0938 22.0938 37.6562 22.0938C36.9688 22.0938 36.4062 22 35.9688 21.8125V19.9375C36.4688 20.1875 36.9375 20.3125 37.375 20.3125C38.3125 20.3125 38.9688 19.5625 39.3438 18.0625L34.8438 5.96875ZM59.5312 16.9375C58.5312 18.1875 57.25 18.8125 55.6875 18.8125C54.625 18.8125 53.8125 18.5312 53.25 17.9688C52.625 17.3438 52.3125 16.5625 52.3125 15.625V5.96875H54.1875V15.1562C54.1875 15.9062 54.3438 16.4375 54.6562 16.75C54.9688 17.0625 55.5 17.2188 56.25 17.2188C57.125 17.2188 57.875 16.9062 58.5 16.2812C59.1875 15.5938 59.5312 14.7188 59.5312 13.6562V5.96875H61.4062V18.8125H59.5312V16.9375Z"
                        fill="#9595D8" />
                    <path
                        d="M88.4688 2.3125V9.25H90.625C91.75 9.25 92.625 8.9375 93.25 8.3125C93.8125 7.75 94.0938 6.90625 94.0938 5.78125C94.0938 4.65625 93.8125 3.8125 93.25 3.25C92.625 2.625 91.75 2.3125 90.625 2.3125H88.4688ZM91.1875 0.53125C92.6875 0.53125 93.875 0.96875 94.75 1.84375C95.6875 2.78125 96.1562 4.09375 96.1562 5.78125C96.1562 7.46875 95.6875 8.78125 94.75 9.71875C93.875 10.5938 92.6875 11.0312 91.1875 11.0312H88.4688V18.8125H86.3125V0.53125H91.1875ZM108.938 18.8125H107.062V0.53125H108.938V18.8125ZM127.25 11.7812C126.5 12.2188 125.625 12.5938 124.625 12.9062C123.875 13.1562 123.281 13.5 122.844 13.9375C122.531 14.25 122.375 14.6875 122.375 15.25C122.375 15.875 122.531 16.3438 122.844 16.6562C123.156 16.9688 123.656 17.125 124.344 17.125C125.469 17.125 126.438 16.4688 127.25 15.1562V11.7812ZM127.25 17.4062C126.312 18.3438 125.156 18.8125 123.781 18.8125C122.656 18.8125 121.75 18.4688 121.062 17.7812C120.438 17.1562 120.125 16.375 120.125 15.4375C120.125 14.4375 120.469 13.5938 121.156 12.9062C121.781 12.2812 122.5 11.8438 123.312 11.5938C125.438 10.9062 126.594 10.4375 126.781 10.1875C127.094 9.8125 127.25 9.4375 127.25 9.0625C127.25 8.6875 127.062 8.34375 126.688 8.03125C126.375 7.78125 125.812 7.65625 125 7.65625C124.375 7.65625 123.875 7.84375 123.5 8.21875C123 8.71875 122.719 9.375 122.656 10.1875H120.594C120.656 8.9375 121.094 7.90625 121.906 7.09375C122.656 6.34375 123.688 5.96875 125 5.96875C126.5 5.96875 127.562 6.28125 128.188 6.90625C128.812 7.53125 129.125 8.3125 129.125 9.25V16.6562C129.125 17.4062 129.375 18.125 129.875 18.8125H127.625C127.375 18.5625 127.25 18.0938 127.25 17.4062ZM144.719 9.625C144.719 9.0625 144.531 8.59375 144.156 8.21875C143.781 7.84375 143.281 7.65625 142.656 7.65625C141.969 7.65625 141.281 8 140.594 8.6875C139.719 9.5625 139.281 10.6875 139.281 12.0625V18.8125H137.406V5.96875H139.281V8.40625C139.594 7.96875 139.969 7.53125 140.406 7.09375C141.156 6.34375 142.094 5.96875 143.219 5.96875C144.219 5.96875 145.031 6.28125 145.656 6.90625C146.281 7.53125 146.594 8.375 146.594 9.4375V18.8125H144.719V9.625Z"
                        fill="white" />
                    <path d="M0 21.4375H68V23.2188H0V21.4375Z" fill="#9595D8" />
                    <path d="M68 21.4375H148V23.2188H68V21.4375Z" fill="white" />
                </svg>

            </div>

            <div class="items-center h-full">
                <svg width="221" height="62" viewBox="0 0 221 62" fill="none"
                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <rect y="1.83228" width="25" height="25" fill="url(#pattern0)" />
                    <path
                        d="M67.3214 1.98755H47.6786C46.9682 1.98755 46.2869 2.268 45.7845 2.76721C45.2822 3.26642 45 3.94349 45 4.64948V24.1703C45 24.8763 45.2822 25.5534 45.7845 26.0526C46.2869 26.5518 46.9682 26.8323 47.6786 26.8323H55.3376V18.3856H51.822V14.4099H55.3376V11.3797C55.3376 7.93309 57.4023 6.02925 60.5647 6.02925C62.0792 6.02925 63.6629 6.29766 63.6629 6.29766V9.68054H61.918C60.1987 9.68054 59.6624 10.7409 59.6624 11.8284V14.4099H63.5006L62.8867 18.3856H59.6624V26.8323H67.3214C68.0318 26.8323 68.7131 26.5518 69.2155 26.0526C69.7178 25.5534 70 24.8763 70 24.1703V4.64948C70 3.94349 69.7178 3.26642 69.2155 2.76721C68.7131 2.268 68.0318 1.98755 67.3214 1.98755Z"
                        fill="white" />
                    <path
                        d="M114.107 0H92.8929C91.2958 0 90 1.28771 90 2.87489V23.9574C90 25.5446 91.2958 26.8323 92.8929 26.8323H114.107C115.704 26.8323 117 25.5446 117 23.9574V2.87489C117 1.28771 115.704 0 114.107 0ZM111.16 9.51109C111.172 9.67879 111.172 9.85248 111.172 10.0202C111.172 15.213 107.194 21.1963 99.9261 21.1963C97.6842 21.1963 95.6049 20.5495 93.8571 19.4354C94.1766 19.4714 94.4839 19.4834 94.8094 19.4834C96.6596 19.4834 98.3592 18.8605 99.7152 17.8063C97.9795 17.7704 96.521 16.6384 96.0208 15.0812C96.6295 15.171 97.1779 15.171 97.8047 15.0093C95.9967 14.644 94.6406 13.0628 94.6406 11.1522V11.1043C95.165 11.3977 95.7797 11.5774 96.4246 11.6014C95.8824 11.243 95.438 10.7568 95.1309 10.1862C94.8238 9.61557 94.6637 8.97828 94.6647 8.33119C94.6647 7.60049 94.8576 6.92968 95.2011 6.34871C97.1478 8.73248 100.071 10.2897 103.349 10.4574C102.789 7.79215 104.796 5.62999 107.206 5.62999C108.346 5.62999 109.37 6.10315 110.093 6.86979C110.985 6.70209 111.841 6.37267 112.6 5.92347C112.305 6.83385 111.684 7.60049 110.865 8.08563C111.66 8.00177 112.432 7.78017 113.143 7.47471C112.606 8.25932 111.931 8.95408 111.16 9.51109Z"
                        fill="white" />
                    <path
                        d="M150.003 7.28848C146.314 7.28848 143.338 10.2462 143.338 13.9132C143.338 17.5801 146.314 20.5378 150.003 20.5378C153.692 20.5378 156.667 17.5801 156.667 13.9132C156.667 10.2462 153.692 7.28848 150.003 7.28848ZM150.003 18.22C147.619 18.22 145.67 16.2886 145.67 13.9132C145.67 11.5377 147.613 9.60625 150.003 9.60625C152.393 9.60625 154.336 11.5377 154.336 13.9132C154.336 16.2886 152.387 18.22 150.003 18.22ZM158.495 7.0175C158.495 7.87657 157.799 8.56268 156.94 8.56268C156.076 8.56268 155.386 7.87081 155.386 7.0175C155.386 6.16419 156.082 5.47232 156.94 5.47232C157.799 5.47232 158.495 6.16419 158.495 7.0175ZM162.909 8.58574C162.81 6.51589 162.334 4.68244 160.809 3.17185C159.289 1.66126 157.445 1.18849 155.362 1.0847C153.216 0.963627 146.784 0.963627 144.638 1.0847C142.561 1.18272 140.717 1.6555 139.191 3.16608C137.666 4.67667 137.196 6.51013 137.091 8.57998C136.97 10.7132 136.97 17.1073 137.091 19.2406C137.19 21.3104 137.666 23.1439 139.191 24.6545C140.717 26.165 142.555 26.6378 144.638 26.7416C146.784 26.8627 153.216 26.8627 155.362 26.7416C157.445 26.6436 159.289 26.1708 160.809 24.6545C162.329 23.1439 162.804 21.3104 162.909 19.2406C163.03 17.1073 163.03 10.719 162.909 8.58574ZM160.136 21.5295C159.684 22.6596 158.808 23.5302 157.665 23.9856C155.954 24.6602 151.894 24.5045 150.003 24.5045C148.112 24.5045 144.046 24.6545 142.341 23.9856C141.204 23.5359 140.328 22.6653 139.87 21.5295C139.191 19.8286 139.348 15.7927 139.348 13.9132C139.348 12.0336 139.197 7.99189 139.87 6.2968C140.322 5.16674 141.198 4.29614 142.341 3.84066C144.052 3.16608 148.112 3.32175 150.003 3.32175C151.894 3.32175 155.96 3.17185 157.665 3.84066C158.802 4.29037 159.678 5.16098 160.136 6.2968C160.815 7.99765 160.658 12.0336 160.658 13.9132C160.658 15.7927 160.815 19.8344 160.136 21.5295Z"
                        fill="white" />
                    <path
                        d="M184.444 4.84928L194.469 13.5185C194.928 13.9156 195.459 14.1261 196 14.1261C196.541 14.1261 197.072 13.9156 197.531 13.5185L207.556 4.84928M185.889 26.8322H206.111C206.877 26.8322 207.612 26.4111 208.154 25.6615C208.696 24.912 209 23.8953 209 22.8353V6.84772C209 5.78768 208.696 4.77106 208.154 4.02149C207.612 3.27193 206.877 2.85083 206.111 2.85083H185.889C185.123 2.85083 184.388 3.27193 183.846 4.02149C183.304 4.77106 183 5.78768 183 6.84772V22.8353C183 23.8953 183.304 24.912 183.846 25.6615C184.388 26.4111 185.123 26.8322 185.889 26.8322Z"
                        fill="white" />
                    <path
                        d="M184.444 4.84928L194.469 13.5185C194.928 13.9156 195.459 14.1261 196 14.1261C196.541 14.1261 197.072 13.9156 197.531 13.5185L207.556 4.84928M185.889 26.8322H206.111C206.877 26.8322 207.612 26.4111 208.154 25.6615C208.696 24.912 209 23.8953 209 22.8353V6.84772C209 5.78768 208.696 4.77106 208.154 4.02149C207.612 3.27193 206.877 2.85083 206.111 2.85083H185.889C185.123 2.85083 184.388 3.27193 183.846 4.02149C183.304 4.77106 183 5.78768 183 6.84772V22.8353C183 23.8953 183.304 24.912 183.846 25.6615C184.388 26.4111 185.123 26.8322 185.889 26.8322Z"
                        stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path
                        d="M9 45.2385C7.4981 45.2385 6.02993 45.6839 4.78114 46.5183C3.53236 47.3527 2.55905 48.5387 1.98429 49.9263C1.40954 51.3138 1.25916 52.8407 1.55217 54.3137C1.84517 55.7868 2.56841 57.1399 3.63041 58.2019C4.69242 59.2639 6.04549 59.9871 7.51854 60.2801C8.99158 60.5731 10.5184 60.4227 11.906 59.848C13.2936 59.2732 14.4796 58.2999 15.314 57.0511C16.1484 55.8024 16.5938 54.3342 16.5938 52.8323C16.5915 50.819 15.7907 48.8888 14.3671 47.4651C12.9435 46.0415 11.0133 45.2408 9 45.2385ZM9 58.7385C7.83186 58.7385 6.68994 58.3921 5.71867 57.7431C4.74739 57.0942 3.99037 56.1717 3.54334 55.0925C3.09631 54.0133 2.97935 52.8257 3.20724 51.68C3.43513 50.5343 3.99765 49.4819 4.82365 48.6559C5.64966 47.8299 6.70205 47.2674 7.84775 47.0395C8.99345 46.8116 10.181 46.9286 11.2602 47.3756C12.3395 47.8226 13.2619 48.5797 13.9109 49.5509C14.5599 50.5222 14.9063 51.6641 14.9063 52.8323C14.9046 54.3982 14.2818 55.8995 13.1745 57.0068C12.0672 58.114 10.5659 58.7368 9 58.7385ZM11.9243 55.0267C11.4637 55.6404 10.8218 56.0936 10.0893 56.3222C9.35689 56.5507 8.57111 56.5431 7.84326 56.3003C7.1154 56.0576 6.48237 55.592 6.03379 54.9695C5.58522 54.347 5.34384 53.5992 5.34384 52.8319C5.34384 52.0647 5.58522 51.3168 6.03379 50.6943C6.48237 50.0719 7.1154 49.6063 7.84326 49.3635C8.57111 49.1207 9.35689 49.1131 10.0893 49.3417C10.8218 49.5703 11.4637 50.0235 11.9243 50.6371C11.9933 50.7255 12.044 50.8267 12.0734 50.9349C12.1028 51.043 12.1104 51.156 12.0957 51.2671C12.081 51.3782 12.0443 51.4853 11.9877 51.5821C11.9312 51.6789 11.8559 51.7634 11.7663 51.8308C11.6767 51.8981 11.5746 51.947 11.4659 51.9744C11.3572 52.0019 11.2441 52.0074 11.1333 51.9907C11.0224 51.9739 10.916 51.9353 10.8203 51.877C10.7246 51.8186 10.6414 51.7418 10.5757 51.651C10.3278 51.3205 9.98213 51.0763 9.58772 50.9531C9.19331 50.8299 8.77013 50.8339 8.37813 50.9646C7.98613 51.0952 7.64518 51.3459 7.40357 51.6811C7.16197 52.0163 7.03196 52.4191 7.03196 52.8323C7.03196 53.2455 7.16197 53.6482 7.40357 53.9834C7.64518 54.3186 7.98613 54.5693 8.37813 54.7C8.77013 54.8307 9.19331 54.8347 9.58772 54.7115C9.98213 54.5883 10.3278 54.3441 10.5757 54.0135C10.6409 53.9214 10.7238 53.8432 10.8197 53.7837C10.9156 53.7242 11.0225 53.6846 11.134 53.6671C11.2454 53.6496 11.3593 53.6547 11.4688 53.682C11.5783 53.7093 11.6812 53.7583 11.7714 53.8261C11.8617 53.8939 11.9374 53.9791 11.9941 54.0766C12.0508 54.1742 12.0874 54.2822 12.1016 54.3941C12.1159 54.506 12.1075 54.6197 12.0771 54.7284C12.0466 54.837 11.9947 54.9385 11.9243 55.0267Z"
                        fill="white" />
                    <path
                        d="M28.1352 57.9723C27.3885 57.9723 26.6932 57.8509 26.0492 57.6083C25.4145 57.3563 24.8592 57.0063 24.3832 56.5583C23.9165 56.1009 23.5525 55.5643 23.2912 54.9483C23.0299 54.3323 22.8992 53.6603 22.8992 52.9323C22.8992 52.2043 23.0299 51.5323 23.2912 50.9163C23.5525 50.3003 23.9212 49.7683 24.3972 49.3203C24.8732 48.8629 25.4285 48.5129 26.0632 48.2703C26.6979 48.0183 27.3932 47.8923 28.1492 47.8923C28.9519 47.8923 29.6845 48.0323 30.3472 48.3123C31.0099 48.5829 31.5699 48.9889 32.0272 49.5303L30.8512 50.6363C30.4965 50.2536 30.0999 49.9689 29.6612 49.7823C29.2225 49.5863 28.7465 49.4883 28.2332 49.4883C27.7199 49.4883 27.2485 49.5723 26.8192 49.7403C26.3992 49.9083 26.0305 50.1463 25.7132 50.4543C25.4052 50.7623 25.1625 51.1263 24.9852 51.5463C24.8172 51.9663 24.7332 52.4283 24.7332 52.9323C24.7332 53.4363 24.8172 53.8983 24.9852 54.3183C25.1625 54.7383 25.4052 55.1023 25.7132 55.4103C26.0305 55.7183 26.3992 55.9563 26.8192 56.1243C27.2485 56.2923 27.7199 56.3763 28.2332 56.3763C28.7465 56.3763 29.2225 56.2829 29.6612 56.0963C30.0999 55.9003 30.4965 55.6063 30.8512 55.2143L32.0272 56.3343C31.5699 56.8663 31.0099 57.2723 30.3472 57.5523C29.6845 57.8323 28.9472 57.9723 28.1352 57.9723ZM36.6896 57.9303C35.9243 57.9303 35.243 57.7669 34.6456 57.4403C34.0483 57.1043 33.577 56.6469 33.2316 56.0683C32.8863 55.4896 32.7136 54.8316 32.7136 54.0943C32.7136 53.3476 32.8863 52.6896 33.2316 52.1203C33.577 51.5416 34.0483 51.0889 34.6456 50.7623C35.243 50.4356 35.9243 50.2723 36.6896 50.2723C37.4643 50.2723 38.1503 50.4356 38.7476 50.7623C39.3543 51.0889 39.8256 51.5369 40.1616 52.1063C40.507 52.6756 40.6796 53.3383 40.6796 54.0943C40.6796 54.8316 40.507 55.4896 40.1616 56.0683C39.8256 56.6469 39.3543 57.1043 38.7476 57.4403C38.1503 57.7669 37.4643 57.9303 36.6896 57.9303ZM36.6896 56.4323C37.119 56.4323 37.5016 56.3389 37.8376 56.1523C38.1736 55.9656 38.435 55.6949 38.6216 55.3403C38.8176 54.9856 38.9156 54.5703 38.9156 54.0943C38.9156 53.6089 38.8176 53.1936 38.6216 52.8483C38.435 52.4936 38.1736 52.2229 37.8376 52.0363C37.5016 51.8496 37.1236 51.7563 36.7036 51.7563C36.2743 51.7563 35.8916 51.8496 35.5556 52.0363C35.229 52.2229 34.9676 52.4936 34.7716 52.8483C34.5756 53.1936 34.4776 53.6089 34.4776 54.0943C34.4776 54.5703 34.5756 54.9856 34.7716 55.3403C34.9676 55.6949 35.229 55.9656 35.5556 56.1523C35.8916 56.3389 36.2696 56.4323 36.6896 56.4323ZM46.4971 57.9303C45.8904 57.9303 45.3351 57.7903 44.8311 57.5103C44.3364 57.2303 43.9397 56.8103 43.6411 56.2503C43.3517 55.6809 43.2071 54.9623 43.2071 54.0943C43.2071 53.2169 43.3471 52.4983 43.6271 51.9383C43.9164 51.3783 44.3084 50.9629 44.8031 50.6923C45.2977 50.4123 45.8624 50.2723 46.4971 50.2723C47.2344 50.2723 47.8831 50.4309 48.4431 50.7483C49.0124 51.0656 49.4604 51.5089 49.7871 52.0783C50.1231 52.6476 50.2911 53.3196 50.2911 54.0943C50.2911 54.8689 50.1231 55.5456 49.7871 56.1243C49.4604 56.6936 49.0124 57.1369 48.4431 57.4543C47.8831 57.7716 47.2344 57.9303 46.4971 57.9303ZM42.3531 60.5483V50.3563H44.0191V52.1203L43.9631 54.1083L44.1031 56.0963V60.5483H42.3531ZM46.3011 56.4323C46.7211 56.4323 47.0944 56.3389 47.4211 56.1523C47.7571 55.9656 48.0231 55.6949 48.2191 55.3403C48.4151 54.9856 48.5131 54.5703 48.5131 54.0943C48.5131 53.6089 48.4151 53.1936 48.2191 52.8483C48.0231 52.4936 47.7571 52.2229 47.4211 52.0363C47.0944 51.8496 46.7211 51.7563 46.3011 51.7563C45.8811 51.7563 45.5031 51.8496 45.1671 52.0363C44.8311 52.2229 44.5651 52.4936 44.3691 52.8483C44.1731 53.1936 44.0751 53.6089 44.0751 54.0943C44.0751 54.5703 44.1731 54.9856 44.3691 55.3403C44.5651 55.6949 44.8311 55.9656 45.1671 56.1523C45.5031 56.3389 45.8811 56.4323 46.3011 56.4323ZM52.3617 60.6463C51.9977 60.6463 51.6337 60.5856 51.2697 60.4643C50.9057 60.3429 50.6023 60.1749 50.3597 59.9603L51.0597 58.6723C51.237 58.8309 51.4377 58.9569 51.6617 59.0503C51.8857 59.1436 52.1143 59.1903 52.3477 59.1903C52.665 59.1903 52.9217 59.1109 53.1177 58.9523C53.3137 58.7936 53.4957 58.5276 53.6637 58.1543L54.0977 57.1743L54.2377 56.9643L57.0657 50.3563H58.7457L55.2457 58.4343C55.0123 58.9943 54.751 59.4376 54.4617 59.7643C54.1817 60.0909 53.8643 60.3196 53.5097 60.4503C53.1643 60.5809 52.7817 60.6463 52.3617 60.6463ZM53.9017 58.0983L50.5277 50.3563H52.3477L55.0917 56.8103L53.9017 58.0983ZM59.8394 57.8323V50.3563H61.5054V52.4143L61.3094 51.8123C61.5334 51.3083 61.8834 50.9256 62.3594 50.6643C62.8447 50.4029 63.4467 50.2723 64.1654 50.2723V51.9383C64.0907 51.9196 64.0207 51.9103 63.9554 51.9103C63.8901 51.9009 63.8247 51.8963 63.7594 51.8963C63.0967 51.8963 62.5694 52.0923 62.1774 52.4843C61.7854 52.8669 61.5894 53.4409 61.5894 54.2063V57.8323H59.8394ZM65.65 57.8323V50.3563H67.4V57.8323H65.65ZM66.532 49.1243C66.2053 49.1243 65.9346 49.0216 65.72 48.8163C65.5146 48.6109 65.412 48.3636 65.412 48.0743C65.412 47.7756 65.5146 47.5283 65.72 47.3323C65.9346 47.1269 66.2053 47.0243 66.532 47.0243C66.8586 47.0243 67.1246 47.1223 67.33 47.3183C67.5446 47.5049 67.652 47.7429 67.652 48.0323C67.652 48.3403 67.5493 48.6016 67.344 48.8163C67.1386 49.0216 66.868 49.1243 66.532 49.1243ZM73.0848 60.6463C72.3942 60.6463 71.7175 60.5529 71.0548 60.3663C70.4015 60.1889 69.8648 59.9276 69.4448 59.5823L70.2288 58.2663C70.5555 58.5369 70.9662 58.7516 71.4608 58.9103C71.9648 59.0783 72.4735 59.1623 72.9868 59.1623C73.8082 59.1623 74.4102 58.9709 74.7928 58.5883C75.1755 58.2149 75.3668 57.6503 75.3668 56.8943V55.5643L75.5068 53.8703L75.4508 52.1763V50.3563H77.1168V56.6983C77.1168 58.0516 76.7715 59.0456 76.0808 59.6803C75.3902 60.3243 74.3915 60.6463 73.0848 60.6463ZM72.8608 57.4963C72.1515 57.4963 71.5075 57.3469 70.9288 57.0483C70.3595 56.7403 69.9068 56.3156 69.5708 55.7743C69.2442 55.2329 69.0808 54.5983 69.0808 53.8703C69.0808 53.1516 69.2442 52.5216 69.5708 51.9803C69.9068 51.4389 70.3595 51.0189 70.9288 50.7203C71.5075 50.4216 72.1515 50.2723 72.8608 50.2723C73.4955 50.2723 74.0648 50.3983 74.5688 50.6503C75.0728 50.9023 75.4742 51.2943 75.7728 51.8263C76.0808 52.3583 76.2348 53.0396 76.2348 53.8703C76.2348 54.7009 76.0808 55.3869 75.7728 55.9283C75.4742 56.4603 75.0728 56.8569 74.5688 57.1183C74.0648 57.3703 73.4955 57.4963 72.8608 57.4963ZM73.1268 56.0123C73.5655 56.0123 73.9575 55.9236 74.3028 55.7463C74.6482 55.5596 74.9142 55.3076 75.1008 54.9903C75.2968 54.6636 75.3948 54.2903 75.3948 53.8703C75.3948 53.4503 75.2968 53.0816 75.1008 52.7643C74.9142 52.4376 74.6482 52.1903 74.3028 52.0223C73.9575 51.8449 73.5655 51.7563 73.1268 51.7563C72.6882 51.7563 72.2915 51.8449 71.9368 52.0223C71.5915 52.1903 71.3208 52.4376 71.1248 52.7643C70.9382 53.0816 70.8448 53.4503 70.8448 53.8703C70.8448 54.2903 70.9382 54.6636 71.1248 54.9903C71.3208 55.3076 71.5915 55.5596 71.9368 55.7463C72.2915 55.9236 72.6882 56.0123 73.1268 56.0123ZM83.6595 50.2723C84.2569 50.2723 84.7889 50.3889 85.2555 50.6223C85.7315 50.8556 86.1049 51.2149 86.3755 51.7003C86.6462 52.1763 86.7815 52.7923 86.7815 53.5483V57.8323H85.0315V53.7723C85.0315 53.1096 84.8729 52.6149 84.5555 52.2883C84.2475 51.9616 83.8135 51.7983 83.2535 51.7983C82.8429 51.7983 82.4789 51.8823 82.1615 52.0503C81.8442 52.2183 81.5969 52.4703 81.4195 52.8063C81.2515 53.1329 81.1675 53.5483 81.1675 54.0523V57.8323H79.4175V47.4443H81.1675V52.3723L80.7895 51.7563C81.0509 51.2803 81.4289 50.9163 81.9235 50.6643C82.4275 50.4029 83.0062 50.2723 83.6595 50.2723ZM91.8155 57.9303C90.9942 57.9303 90.3595 57.7203 89.9115 57.3003C89.4635 56.8709 89.2395 56.2409 89.2395 55.4103V48.7043H90.9895V55.3683C90.9895 55.7229 91.0782 55.9983 91.2555 56.1943C91.4422 56.3903 91.6988 56.4883 92.0255 56.4883C92.4175 56.4883 92.7442 56.3856 93.0055 56.1803L93.4955 57.4263C93.2902 57.5943 93.0382 57.7203 92.7395 57.8043C92.4408 57.8883 92.1328 57.9303 91.8155 57.9303ZM88.0075 51.8123V50.4123H92.9915V51.8123H88.0075ZM103.55 57.9723C102.785 57.9723 102.08 57.8509 101.436 57.6083C100.802 57.3563 100.246 57.0063 99.7703 56.5583C99.2943 56.1009 98.9256 55.5643 98.6643 54.9483C98.4029 54.3323 98.2723 53.6603 98.2723 52.9323C98.2723 52.2043 98.4029 51.5323 98.6643 50.9163C98.9256 50.3003 99.2943 49.7683 99.7703 49.3203C100.256 48.8629 100.82 48.5129 101.464 48.2703C102.108 48.0183 102.813 47.8923 103.578 47.8923C104.409 47.8923 105.156 48.0276 105.818 48.2983C106.49 48.5689 107.055 48.9656 107.512 49.4883L106.364 50.6083C105.982 50.2256 105.566 49.9456 105.118 49.7683C104.68 49.5816 104.194 49.4883 103.662 49.4883C103.149 49.4883 102.673 49.5723 102.234 49.7403C101.796 49.9083 101.418 50.1463 101.1 50.4543C100.783 50.7623 100.536 51.1263 100.358 51.5463C100.19 51.9663 100.106 52.4283 100.106 52.9323C100.106 53.4269 100.19 53.8843 100.358 54.3043C100.536 54.7243 100.783 55.0929 101.1 55.4103C101.418 55.7183 101.791 55.9563 102.22 56.1243C102.65 56.2923 103.126 56.3763 103.648 56.3763C104.134 56.3763 104.6 56.3016 105.048 56.1523C105.506 55.9936 105.94 55.7323 106.35 55.3683L107.386 56.7263C106.873 57.1369 106.276 57.4496 105.594 57.6643C104.922 57.8696 104.241 57.9723 103.55 57.9723ZM105.664 56.4883V52.8203H107.386V56.7263L105.664 56.4883ZM114.225 57.8323V56.3203L114.127 55.9983V53.3523C114.127 52.8389 113.973 52.4423 113.665 52.1623C113.357 51.8729 112.89 51.7283 112.265 51.7283C111.845 51.7283 111.429 51.7936 111.019 51.9243C110.617 52.0549 110.277 52.2369 109.997 52.4703L109.311 51.1963C109.712 50.8883 110.188 50.6596 110.739 50.5103C111.299 50.3516 111.877 50.2723 112.475 50.2723C113.557 50.2723 114.393 50.5336 114.981 51.0563C115.578 51.5696 115.877 52.3676 115.877 53.4503V57.8323H114.225ZM111.873 57.9303C111.313 57.9303 110.823 57.8369 110.403 57.6503C109.983 57.4543 109.656 57.1883 109.423 56.8523C109.199 56.5069 109.087 56.1196 109.087 55.6903C109.087 55.2703 109.185 54.8923 109.381 54.5563C109.586 54.2203 109.917 53.9543 110.375 53.7583C110.832 53.5623 111.439 53.4643 112.195 53.4643H114.365V54.6263H112.321C111.723 54.6263 111.322 54.7243 111.117 54.9203C110.911 55.1069 110.809 55.3403 110.809 55.6203C110.809 55.9376 110.935 56.1896 111.187 56.3763C111.439 56.5629 111.789 56.6563 112.237 56.6563C112.666 56.6563 113.049 56.5583 113.385 56.3623C113.73 56.1663 113.977 55.8769 114.127 55.4943L114.421 56.5443C114.253 56.9829 113.949 57.3236 113.511 57.5663C113.081 57.8089 112.535 57.9303 111.873 57.9303ZM121.566 57.9303C120.782 57.9303 120.082 57.7669 119.466 57.4403C118.86 57.1043 118.384 56.6469 118.038 56.0683C117.693 55.4896 117.52 54.8316 117.52 54.0943C117.52 53.3476 117.693 52.6896 118.038 52.1203C118.384 51.5416 118.86 51.0889 119.466 50.7623C120.082 50.4356 120.782 50.2723 121.566 50.2723C122.294 50.2723 122.934 50.4216 123.484 50.7203C124.044 51.0096 124.469 51.4389 124.758 52.0083L123.414 52.7923C123.19 52.4376 122.915 52.1763 122.588 52.0083C122.271 51.8403 121.926 51.7563 121.552 51.7563C121.123 51.7563 120.736 51.8496 120.39 52.0363C120.045 52.2229 119.774 52.4936 119.578 52.8483C119.382 53.1936 119.284 53.6089 119.284 54.0943C119.284 54.5796 119.382 54.9996 119.578 55.3543C119.774 55.6996 120.045 55.9656 120.39 56.1523C120.736 56.3389 121.123 56.4323 121.552 56.4323C121.926 56.4323 122.271 56.3483 122.588 56.1803C122.915 56.0123 123.19 55.7509 123.414 55.3963L124.758 56.1803C124.469 56.7403 124.044 57.1743 123.484 57.4823C122.934 57.7809 122.294 57.9303 121.566 57.9303ZM129.522 57.9303C128.756 57.9303 128.075 57.7669 127.478 57.4403C126.88 57.1043 126.409 56.6469 126.064 56.0683C125.718 55.4896 125.546 54.8316 125.546 54.0943C125.546 53.3476 125.718 52.6896 126.064 52.1203C126.409 51.5416 126.88 51.0889 127.478 50.7623C128.075 50.4356 128.756 50.2723 129.522 50.2723C130.296 50.2723 130.982 50.4356 131.58 50.7623C132.186 51.0889 132.658 51.5369 132.994 52.1063C133.339 52.6756 133.512 53.3383 133.512 54.0943C133.512 54.8316 133.339 55.4896 132.994 56.0683C132.658 56.6469 132.186 57.1043 131.58 57.4403C130.982 57.7669 130.296 57.9303 129.522 57.9303ZM129.522 56.4323C129.951 56.4323 130.334 56.3389 130.67 56.1523C131.006 55.9656 131.267 55.6949 131.454 55.3403C131.65 54.9856 131.748 54.5703 131.748 54.0943C131.748 53.6089 131.65 53.1936 131.454 52.8483C131.267 52.4936 131.006 52.2229 130.67 52.0363C130.334 51.8496 129.956 51.7563 129.536 51.7563C129.106 51.7563 128.724 51.8496 128.388 52.0363C128.061 52.2229 127.8 52.4936 127.604 52.8483C127.408 53.1936 127.31 53.6089 127.31 54.0943C127.31 54.5703 127.408 54.9856 127.604 55.3403C127.8 55.6949 128.061 55.9656 128.388 56.1523C128.724 56.3389 129.102 56.4323 129.522 56.4323ZM135.185 57.8323V50.3563H136.851V52.4143L136.655 51.8123C136.879 51.3083 137.229 50.9256 137.705 50.6643C138.19 50.4029 138.792 50.2723 139.511 50.2723V51.9383C139.436 51.9196 139.366 51.9103 139.301 51.9103C139.236 51.9009 139.17 51.8963 139.105 51.8963C138.442 51.8963 137.915 52.0923 137.523 52.4843C137.131 52.8669 136.935 53.4409 136.935 54.2063V57.8323H135.185ZM146.725 55.5223L146.627 53.3663L151.765 48.0323H153.809L149.539 52.5683L148.531 53.6743L146.725 55.5223ZM145.101 57.8323V48.0323H146.921V57.8323H145.101ZM151.933 57.8323L148.181 53.3663L149.385 52.0363L154.061 57.8323H151.933ZM159.561 57.8323V56.3203L159.463 55.9983V53.3523C159.463 52.8389 159.309 52.4423 159.001 52.1623C158.693 51.8729 158.226 51.7283 157.601 51.7283C157.181 51.7283 156.765 51.7936 156.355 51.9243C155.953 52.0549 155.613 52.2369 155.333 52.4703L154.647 51.1963C155.048 50.8883 155.524 50.6596 156.075 50.5103C156.635 50.3516 157.213 50.2723 157.811 50.2723C158.893 50.2723 159.729 50.5336 160.317 51.0563C160.914 51.5696 161.213 52.3676 161.213 53.4503V57.8323H159.561ZM157.209 57.9303C156.649 57.9303 156.159 57.8369 155.739 57.6503C155.319 57.4543 154.992 57.1883 154.759 56.8523C154.535 56.5069 154.423 56.1196 154.423 55.6903C154.423 55.2703 154.521 54.8923 154.717 54.5563C154.922 54.2203 155.253 53.9543 155.711 53.7583C156.168 53.5623 156.775 53.4643 157.531 53.4643H159.701V54.6263H157.657C157.059 54.6263 156.658 54.7243 156.453 54.9203C156.247 55.1069 156.145 55.3403 156.145 55.6203C156.145 55.9376 156.271 56.1896 156.523 56.3763C156.775 56.5629 157.125 56.6563 157.573 56.6563C158.002 56.6563 158.385 56.5583 158.721 56.3623C159.066 56.1663 159.313 55.8769 159.463 55.4943L159.757 56.5443C159.589 56.9829 159.285 57.3236 158.847 57.5663C158.417 57.8089 157.871 57.9303 157.209 57.9303ZM167.701 50.2723C168.298 50.2723 168.83 50.3889 169.297 50.6223C169.773 50.8556 170.146 51.2149 170.417 51.7003C170.687 52.1763 170.823 52.7923 170.823 53.5483V57.8323H169.073V53.7723C169.073 53.1096 168.914 52.6149 168.597 52.2883C168.289 51.9616 167.855 51.7983 167.295 51.7983C166.884 51.7983 166.52 51.8823 166.203 52.0503C165.885 52.2183 165.638 52.4703 165.461 52.8063C165.293 53.1329 165.209 53.5483 165.209 54.0523V57.8323H163.459V50.3563H165.125V52.3723L164.831 51.7563C165.092 51.2803 165.47 50.9163 165.965 50.6643C166.469 50.4029 167.047 50.2723 167.701 50.2723ZM176.444 60.6463C175.754 60.6463 175.077 60.5529 174.414 60.3663C173.761 60.1889 173.224 59.9276 172.804 59.5823L173.588 58.2663C173.915 58.5369 174.326 58.7516 174.82 58.9103C175.324 59.0783 175.833 59.1623 176.346 59.1623C177.168 59.1623 177.77 58.9709 178.152 58.5883C178.535 58.2149 178.726 57.6503 178.726 56.8943V55.5643L178.866 53.8703L178.81 52.1763V50.3563H180.476V56.6983C180.476 58.0516 180.131 59.0456 179.44 59.6803C178.75 60.3243 177.751 60.6463 176.444 60.6463ZM176.22 57.4963C175.511 57.4963 174.867 57.3469 174.288 57.0483C173.719 56.7403 173.266 56.3156 172.93 55.7743C172.604 55.2329 172.44 54.5983 172.44 53.8703C172.44 53.1516 172.604 52.5216 172.93 51.9803C173.266 51.4389 173.719 51.0189 174.288 50.7203C174.867 50.4216 175.511 50.2723 176.22 50.2723C176.855 50.2723 177.424 50.3983 177.928 50.6503C178.432 50.9023 178.834 51.2943 179.132 51.8263C179.44 52.3583 179.594 53.0396 179.594 53.8703C179.594 54.7009 179.44 55.3869 179.132 55.9283C178.834 56.4603 178.432 56.8569 177.928 57.1183C177.424 57.3703 176.855 57.4963 176.22 57.4963ZM176.486 56.0123C176.925 56.0123 177.317 55.9236 177.662 55.7463C178.008 55.5596 178.274 55.3076 178.46 54.9903C178.656 54.6636 178.754 54.2903 178.754 53.8703C178.754 53.4503 178.656 53.0816 178.46 52.7643C178.274 52.4376 178.008 52.1903 177.662 52.0223C177.317 51.8449 176.925 51.7563 176.486 51.7563C176.048 51.7563 175.651 51.8449 175.296 52.0223C174.951 52.1903 174.68 52.4376 174.484 52.7643C174.298 53.0816 174.204 53.4503 174.204 53.8703C174.204 54.2903 174.298 54.6636 174.484 54.9903C174.68 55.3076 174.951 55.5596 175.296 55.7463C175.651 55.9236 176.048 56.0123 176.486 56.0123ZM185.988 57.8323V56.6143L189.88 52.9183C190.207 52.6103 190.449 52.3396 190.608 52.1063C190.767 51.8729 190.869 51.6583 190.916 51.4623C190.972 51.2569 191 51.0656 191 50.8883C191 50.4403 190.846 50.0949 190.538 49.8523C190.23 49.6003 189.777 49.4743 189.18 49.4743C188.704 49.4743 188.27 49.5583 187.878 49.7263C187.495 49.8943 187.164 50.1509 186.884 50.4963L185.61 49.5163C185.993 49.0029 186.506 48.6063 187.15 48.3263C187.803 48.0369 188.531 47.8923 189.334 47.8923C190.043 47.8923 190.659 48.0089 191.182 48.2423C191.714 48.4663 192.12 48.7883 192.4 49.2083C192.689 49.6283 192.834 50.1276 192.834 50.7063C192.834 51.0236 192.792 51.3409 192.708 51.6583C192.624 51.9663 192.465 52.2929 192.232 52.6383C191.999 52.9836 191.658 53.3709 191.21 53.8003L187.864 56.9783L187.486 56.2923H193.212V57.8323H185.988ZM198.35 57.9723C197.576 57.9723 196.876 57.7763 196.25 57.3843C195.634 56.9923 195.149 56.4229 194.794 55.6763C194.44 54.9203 194.262 54.0056 194.262 52.9323C194.262 51.8589 194.44 50.9489 194.794 50.2023C195.149 49.4463 195.634 48.8723 196.25 48.4803C196.876 48.0883 197.576 47.8923 198.35 47.8923C199.134 47.8923 199.834 48.0883 200.45 48.4803C201.066 48.8723 201.552 49.4463 201.906 50.2023C202.27 50.9489 202.452 51.8589 202.452 52.9323C202.452 54.0056 202.27 54.9203 201.906 55.6763C201.552 56.4229 201.066 56.9923 200.45 57.3843C199.834 57.7763 199.134 57.9723 198.35 57.9723ZM198.35 56.3903C198.808 56.3903 199.204 56.2689 199.54 56.0263C199.876 55.7743 200.138 55.3916 200.324 54.8783C200.52 54.3649 200.618 53.7163 200.618 52.9323C200.618 52.1389 200.52 51.4903 200.324 50.9863C200.138 50.4729 199.876 50.0949 199.54 49.8523C199.204 49.6003 198.808 49.4743 198.35 49.4743C197.912 49.4743 197.52 49.6003 197.174 49.8523C196.838 50.0949 196.572 50.4729 196.376 50.9863C196.19 51.4903 196.096 52.1389 196.096 52.9323C196.096 53.7163 196.19 54.3649 196.376 54.8783C196.572 55.3916 196.838 55.7743 197.174 56.0263C197.52 56.2689 197.912 56.3903 198.35 56.3903ZM203.542 55.6063V54.3463L208.372 48.0323H210.318L205.558 54.3463L204.648 54.0663H212.418V55.6063H203.542ZM208.918 57.8323V55.6063L208.974 54.0663V52.0923H210.682V57.8323H208.918ZM213.058 57.8323V56.6143L216.95 52.9183C217.277 52.6103 217.52 52.3396 217.678 52.1063C217.837 51.8729 217.94 51.6583 217.986 51.4623C218.042 51.2569 218.07 51.0656 218.07 50.8883C218.07 50.4403 217.916 50.0949 217.608 49.8523C217.3 49.6003 216.848 49.4743 216.25 49.4743C215.774 49.4743 215.34 49.5583 214.948 49.7263C214.566 49.8943 214.234 50.1509 213.954 50.4963L212.68 49.5163C213.063 49.0029 213.576 48.6063 214.22 48.3263C214.874 48.0369 215.602 47.8923 216.404 47.8923C217.114 47.8923 217.73 48.0089 218.252 48.2423C218.784 48.4663 219.19 48.7883 219.47 49.2083C219.76 49.6283 219.904 50.1276 219.904 50.7063C219.904 51.0236 219.862 51.3409 219.778 51.6583C219.694 51.9663 219.536 52.2929 219.302 52.6383C219.069 52.9836 218.728 53.3709 218.28 53.8003L214.934 56.9783L214.556 56.2923H220.282V57.8323H213.058Z"
                        fill="white" />
                    <defs>
                        <pattern id="pattern0" patternContentUnits="objectBoundingBox" width="1"
                            height="1">
                            <use xlink:href="#image0_256_204" transform="scale(0.00390625)" />
                        </pattern>
                        <image id="image0_256_204" width="256" height="256"
                            xlink:href="data:image/png;base64,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" />
                    </defs>
                </svg>
            </div>

        </div>
    </footer>
</x-app-layout>
