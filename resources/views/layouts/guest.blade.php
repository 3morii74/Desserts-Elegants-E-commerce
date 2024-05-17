<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Scripts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src="{{ asset('js/app.js') }}" defer></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cookie&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <!-- Include Swiper JS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>

<body>
    <div class="bg-white shadow-md" x-data="{ isOpen: false }">
        <nav class="container px-6 py-3 mx-auto md:flex md:justify-between md:items-center">
            <div class="flex items-center justify-between">
                <a href="{{ route('Home') }}"><img src="/images/logo.png" class="w-16 h-16 rounded mx-4"></a>
                <a href="{{ route('Home') }}" class="text-xl text-base text-transparent bg-clip-text bg-gradient-to-r from-green-400 to-purple-500 font-bold bg-clip-text md:text-2xl" href="#">
                    Desserts Elegants
                </a>
                <!-- Mobile menu button -->
                <div @click="isOpen = !isOpen" class="flex md:hidden">
                    <button type="button" class="text-gray-800 hover:text-gray-400 focus:outline-none focus:text-gray-400" aria-label="toggle menu">
                        <svg viewBox="0 0 24 24" class="w-6 h-6 fill-current">
                            <path fill-rule="evenodd" d="M4 5h16a1 1 0 0 1 0 2H4a1 1 0 1 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2z">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu open: "block", Menu closed: "hidden" -->
            <div :class="isOpen ? 'flex' : 'hidden'" class="flex-col mt-8 space-y-4 md:flex md:space-y-0 md:flex-row md:items-center md:space-x-10 md:mt-0 navtransition">
                <a class="text-transparent bg-clip-text bg-gradient-to-r from-green-400 to-purple-500 hover:text-larger" href="/">Home</a>
                <!--<a class="text-transparent bg-clip-text bg-gradient-to-r from-green-400 to-purple-500 hover:text-larger" href="{{ route('categories.index') }}">Categories</a>-->
                @if(auth()->check())
                <a class="text-transparent bg-clip-text bg-gradient-to-r from-green-400 to-purple-500 hover:text-larger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Logout
                </a>
                <a class="text-transparent bg-clip-text bg-gradient-to-r from-green-400 to-purple-500 hover:text-larger" href="{{ route('order.indexClint') }}">
                    My Orders
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                @else
                <a class="text-transparent bg-clip-text bg-gradient-to-r from-green-400 to-purple-500 hover:text-larger" href="{{ route('contact.login') }}">
                    Login
                </a>
                @endif
                <!--<a class="text-transparent bg-clip-text bg-gradient-to-r from-green-400 to-purple-500 hover:text-larger" href="{{ route('Home') }}">Contact Us</a>-->
                <a class="text-transparent bg-clip-text bg-gradient-to-r from-green-400 to-purple-500 hover:text-larger" href="{{ route('item.show') }}"><span class="material-symbols-outlined">
                        shopping_cart
                    </span></a>

            </div>
        </nav>
    </div>
    <div class="font-sans text-gray-900 antialiased min-h-screen">
        {{ $slot }}
    </div>
    <footer class="bg-teal-800 border-t border-teal-800">
        <div class="container flex flex-wrap items-center justify-center px-4 py-8 mx-auto lg:justify-between">
            <div class="flex flex-wrap justify-center">
                <ul class="flex items-center text-purple-50 text-2xl">
                    <a href="{{ route('Home') }}" class="hover:text-purple-500 mr-6">
                        <li>Home</li>
                    </a>
                    <a href="{{ route('order.indexClint') }}" class="hover:text-purple-500 mr-30">
                        <li>My Orders</li>
                    </a>
                    <a class="mr-4">
                        <li> Contact Us |
                            <span class="material-symbols-outlined">
                                call
                            </span>
                            01007760041
                        </li>
                    </a>
                    <a href="https://www.instagram.com/dessertselegants?igsh=Zjlsem13b2oxcjNp" class="ml-3 hover:bg-purple-500 text-2xl mr-4">
                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-6 h-6 text-purple-50 text-2xl" viewBox="0 0 24 24">
                            <rect width="20" height="20" x="2" y="2" rx="5" ry="5"></rect>
                            <path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37zm1.5-4.87h.01"></path>
                        </svg>
                    </a>
                </ul>
            </div>
        </div>
    </footer>
</body>

</html>