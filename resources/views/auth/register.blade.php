<x-guest-layout>
    <div class="h-screen grid grid-cols-5" style="background-image: url({{ asset('unsplash_EVgsAbL51Rk.png') }}); background-size: cover; background-position: center;">

        {{-- Left Side --}}
        <div class="col-span-3 bg-[#131315]/50 flex justify-center items-center relative">
            <a href="{{ url()->previous() }}" class="absolute left-0 top-0 m-[40px] w-[40px]">
                <svg viewBox="0 0 29 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M28.4999 10.5H6.62091L14.5604 2.56045L12.4394 0.439453L0.878906 12L12.4394 23.5605L14.5604 21.4395L6.62091 13.5H28.4999V10.5Z" fill="white"/>
                </svg>
            </a>

            <div>
                {{-- Logo --}}
                {{-- <img data-aos="zoom-out" class="mx-auto inset-0 h-[352px]" src="Logo.svg" alt=""> --}}
            </div>
            <div data-aos="fade-right" data-aos-duration="3000" class="absolute inset-x-0 bottom-0 m-[30px]">
                {{-- Get in touch --}}
                <h1 class="text-5xl font-bold text-white underline underline-offset-8"><span class="text-[#9595D8] underline underline-offset-8">Get</span> in touch</h1>
                {{-- Contact List --}}
                <div  class="flex mt-4 items-center">
                    <svg class="" width="25" height="26" viewBox="0 0 25 26" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <rect y="0.832275" width="25" height="25" fill="url(#pattern0)"/><defs><pattern id="pattern0" patternContentUnits="objectBoundingBox" width="1" height="1"><use xlink:href="#image0_13_218" transform="scale(0.00390625)"/></pattern><image id="image0_13_218" width="256" height="256" xlink:href="data:image/png;base64,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"/></defs>
                    </svg><span class="text-[#fff] ml-2 underline underline-offset-6 text-2xl mr-6">0864-3736-2721</span>
                    <svg width="25" height="26" viewBox="0 0 25 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22.3214 0.987549H2.67857C1.96817 0.987549 1.28686 1.268 0.784535 1.76721C0.282206 2.26642 0 2.94349 0 3.64948L0 23.1703C0 23.8763 0.282206 24.5534 0.784535 25.0526C1.28686 25.5518 1.96817 25.8323 2.67857 25.8323H10.3376V17.3856H6.82199V13.4099H10.3376V10.3797C10.3376 6.93309 12.4023 5.02925 15.5647 5.02925C17.0792 5.02925 18.6629 5.29766 18.6629 5.29766V8.68054H16.918C15.1987 8.68054 14.6624 9.74088 14.6624 10.8284V13.4099H18.5006L17.8867 17.3856H14.6624V25.8323H22.3214C23.0318 25.8323 23.7131 25.5518 24.2155 25.0526C24.7178 24.5534 25 23.8763 25 23.1703V3.64948C25 2.94349 24.7178 2.26642 24.2155 1.76721C23.7131 1.268 23.0318 0.987549 22.3214 0.987549Z" fill="white"/>
                    </svg><span class="text-[#fff] ml-2 text-2xl mr-6">@EvyuPlan</span>
                    <svg width="27" height="27" viewBox="0 0 27 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M24.1071 0H2.89286C1.29576 0 0 1.28771 0 2.87489V23.9574C0 25.5446 1.29576 26.8323 2.89286 26.8323H24.1071C25.7042 26.8323 27 25.5446 27 23.9574V2.87489C27 1.28771 25.7042 0 24.1071 0ZM21.16 9.51109C21.1721 9.67879 21.1721 9.85248 21.1721 10.0202C21.1721 15.213 17.1944 21.1963 9.92612 21.1963C7.68415 21.1963 5.60491 20.5495 3.85714 19.4354C4.17656 19.4714 4.48393 19.4834 4.80938 19.4834C6.6596 19.4834 8.35915 18.8605 9.71518 17.8063C7.97946 17.7704 6.52098 16.6384 6.02076 15.0812C6.62946 15.171 7.1779 15.171 7.80469 15.0093C5.99665 14.644 4.64062 13.0628 4.64062 11.1522V11.1043C5.16496 11.3977 5.77969 11.5774 6.42455 11.6014C5.8824 11.243 5.43796 10.7568 5.13089 10.1862C4.82381 9.61557 4.66367 8.97828 4.66473 8.33119C4.66473 7.60049 4.85759 6.92968 5.20112 6.34871C7.14777 8.73248 10.0708 10.2897 13.3493 10.4574C12.7888 7.79215 14.7958 5.62999 17.2065 5.62999C18.3455 5.62999 19.3701 6.10315 20.0933 6.86979C20.9853 6.70209 21.8411 6.37267 22.6004 5.92347C22.3051 6.83385 21.6844 7.60049 20.8647 8.08563C21.6603 8.00177 22.4317 7.78017 23.1429 7.47471C22.6065 8.25932 21.9315 8.95408 21.16 9.51109Z" fill="white"/>
                    </svg><span class="text-[#fff] ml-2 text-2xl mr-6">@evyuplan.20</span>
                </div>
                {{-- Contact List 2--}}
                <div  class="flex mt-2 items-center">
                    <svg width="26" height="27" viewBox="0 0 26 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M13.0029 7.12686C9.31389 7.12686 6.33832 10.0846 6.33832 13.7515C6.33832 17.4184 9.31389 20.3762 13.0029 20.3762C16.6919 20.3762 19.6675 17.4184 19.6675 13.7515C19.6675 10.0846 16.6919 7.12686 13.0029 7.12686ZM13.0029 18.0584C10.619 18.0584 8.67005 16.127 8.67005 13.7515C8.67005 11.3761 10.6132 9.44463 13.0029 9.44463C15.3926 9.44463 17.3358 11.3761 17.3358 13.7515C17.3358 16.127 15.3868 18.0584 13.0029 18.0584ZM21.4946 6.85588C21.4946 7.71495 20.7986 8.40106 19.9401 8.40106C19.0759 8.40106 18.3856 7.70919 18.3856 6.85588C18.3856 6.00257 19.0817 5.3107 19.9401 5.3107C20.7986 5.3107 21.4946 6.00257 21.4946 6.85588ZM25.9086 8.42412C25.81 6.35427 25.3344 4.52081 23.8089 3.01023C22.2892 1.49964 20.4447 1.02686 18.3624 0.923083C16.2163 0.802006 9.78372 0.802006 7.63759 0.923083C5.56107 1.0211 3.71656 1.49388 2.19108 3.00446C0.665589 4.51505 0.195761 6.34851 0.0913553 8.41836C-0.0304518 10.5516 -0.0304518 16.9457 0.0913553 19.0789C0.189961 21.1488 0.665589 22.9822 2.19108 24.4928C3.71656 26.0034 5.55527 26.4762 7.63759 26.58C9.78372 26.7011 16.2163 26.7011 18.3624 26.58C20.4447 26.482 22.2892 26.0092 23.8089 24.4928C25.3286 22.9822 25.8042 21.1488 25.9086 19.0789C26.0305 16.9457 26.0305 10.5574 25.9086 8.42412ZM23.1361 21.3679C22.6837 22.4979 21.8078 23.3685 20.6651 23.824C18.954 24.4986 14.8938 24.3429 13.0029 24.3429C11.112 24.3429 7.04596 24.4928 5.34066 23.824C4.20379 23.3743 3.32794 22.5037 2.86972 21.3679C2.19108 19.667 2.34769 15.6311 2.34769 13.7515C2.34769 11.8719 2.19688 7.83026 2.86972 6.13518C3.32214 5.00512 4.19799 4.13452 5.34066 3.67904C7.05176 3.00446 11.112 3.16013 13.0029 3.16013C14.8938 3.16013 18.9598 3.01023 20.6651 3.67904C21.802 4.12875 22.6779 4.99936 23.1361 6.13518C23.8147 7.83603 23.6581 11.8719 23.6581 13.7515C23.6581 15.6311 23.8147 19.6728 23.1361 21.3679Z" fill="white"/>
                    </svg><span class="text-[#fff] ml-2 text-2xl mr-6">@Eyuplan_</span>
                    <svg width="28" height="27" viewBox="0 0 28 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2.44444 3.66935L12.4689 12.3386C12.928 12.7356 13.4586 12.9461 14 12.9461C14.5414 12.9461 15.072 12.7356 15.5311 12.3386L25.5556 3.66935M3.88889 25.6523H24.1111C24.8773 25.6523 25.6121 25.2312 26.1539 24.4816C26.6956 23.732 27 22.7154 27 21.6554V5.66779C27 4.60775 26.6956 3.59112 26.1539 2.84156C25.6121 2.092 24.8773 1.6709 24.1111 1.6709H3.88889C3.12271 1.6709 2.38791 2.092 1.84614 2.84156C1.30436 3.59112 1 4.60775 1 5.66779V21.6554C1 22.7154 1.30436 23.732 1.84614 24.4816C2.38791 25.2312 3.12271 25.6523 3.88889 25.6523Z" fill="white"/><path d="M2.44444 3.66935L12.4689 12.3386C12.928 12.7356 13.4586 12.9461 14 12.9461C14.5414 12.9461 15.072 12.7356 15.5311 12.3386L25.5556 3.66935M3.88889 25.6523H24.1111C24.8773 25.6523 25.6121 25.2312 26.1539 24.4816C26.6956 23.732 27 22.7154 27 21.6554V5.66779C27 4.60775 26.6956 3.59112 26.1539 2.84156C25.6121 2.092 24.8773 1.6709 24.1111 1.6709H3.88889C3.12271 1.6709 2.38791 2.092 1.84614 2.84156C1.30436 3.59112 1 4.60775 1 5.66779V21.6554C1 22.7154 1.30436 23.732 1.84614 24.4816C2.38791 25.2312 3.12271 25.6523 3.88889 25.6523Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg><span class="text-[#fff] ml-2 text-2xl mr-6">Evyuplan@gmail.com</span>
                </div>
            </div>
        </div>
        {{-- Left Side End--}}

        {{-- Right Side --}}
        <div class="col-span-2 bg-[#555585]/70 flex items-center relative p-20">
            <div class="flex-1">
                <h1 class="text-5xl font-bold text-white underline underline-offset-[12px] mb-14">Register</h1>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- User Name -->
                    <div class="mt-4">
                        <label for="name" class="text-2xl font-semibold text-white my-2">User Name</label>
                        <input type="text" name="name" id="name" class="w-full mb-4 text-3xl font-semibold focus-within:border-white text-white bg-[#fff]/30 hover:bg-[#9595D8]/60 focus-within:bg-[#9595D8]/60 border-2 border-white rounded-lg h-[71px]" required autofocus>
                        @error('name')
                            <span class="text-red-600 mt-2">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Email Address -->
                    <div class="mt-4">
                        <label for="email" class="text-2xl font-semibold text-white my-2">Email</label>
                        <input type="text" name="email" id="email" class="w-full mb-4 text-3xl font-semibold focus-within:border-white text-white bg-[#fff]/30 hover:bg-[#9595D8]/60 focus-within:bg-[#9595D8]/60 border-2 border-white rounded-lg h-[71px]" required>
                        @error('email')
                            <span class="text-red-600 mt-2">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <label for="password" class="text-2xl font-semibold text-white my-2">Password</label>
                        <input type="password" name="password" id="password" class="w-full text-3xl font-semibold focus-within:border-white text-white bg-[#fff]/30 hover:bg-[#9595D8]/60 focus-within:bg-[#9595D8]/60 border-2 border-white rounded-lg h-[71px]" required>
                        <p class="text-lg font-medium text-white">Minimum 8 characters</p>
                        @error('password')
                            <span class="text-red-600 mt-2">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="mt-4">
                        <label for="password_confirmation" class="text-2xl font-semibold text-white my-2">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="w-full text-3xl font-semibold focus-within:border-white text-white bg-[#fff]/30 hover:bg-[#9595D8]/60 focus-within:bg-[#9595D8]/60 border-2 border-white rounded-lg h-[71px] mb-4" required>
                        @error('password_confirmation')
                            <span class="text-red-600 mt-2">{{ $message }}</span>
                        @enderror
                    </div>

                    <button class="w-full mt-8 font-extrabold text-2xl rounded-lg h-[71px] bg-[#BEBEFF] text-white border-white border-2 hover:bg-[#fff]/90 hover:text-[#BEBEFF] hover:border-[#BEBEFF]">{{ __('Register') }}</button>

                    <h3 class="text-2xl font-medium text-white mt-4 text-center">Already have an account? <a href="{{ route('login') }}" class="text-[#BEBEFF] font-extrabold">Log in</a></h3>
                </form>


            </div>
        </div>


    </div>
</x-guest-layout>

{{-- <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form> --}}
