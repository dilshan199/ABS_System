<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css','resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <title>@yield('title')</title>
</head>
<body>
    <!-- Top navigation bar -->
    <nav class="bg-white dark:bg-gray-800 fixed top-0 left-0 flex w-full z-50 shadow-md shadow-gray-400/10">
        <div class="w-64 flex-none px-2 py-4 flex items-center space-x-3">
            <button type="button" data-drawer-target="offCanvasSideMenu" data-drawer-toggle="offCanvasSideMenu" aria-controls="offCanvasSideMenu" class="text-2xl text-gray-600 dark:text-gray-400 hover:text-navy-blue-400 dark:hover:text-navy-blue-200 sm:hidden">
                <span class="sr-only">Off canvas sidemenu</span>
                <i class="bi bi-list"></i>
            </button>
            {{-- <h2 class="text-2xl font-bold uppercase text-gray-900 dark:text-gray-400">asc<span class="text-navy-blue-400">pos</span></h2> --}}
        </div>
        <div class="w-64 flex-auto flex items-center justify-end md:justify-between px-2">
            <button type="button" class="text-sm dark:text-gray-400 hover:text-navy-blue-300 dark:hover:text-navy-blue-300 hidden md:block" title="Full Screen">
                <i class="bi bi-arrows-fullscreen"></i>
            </button>
            <ul class="flex items-center text-gray-900 dark:text-gray-400 space-x-4">
                <li class="relative">
                    <a type="button" id="profileDropBtn" data-dropdown-toggle="profileDropContent" data-dropdown-placement="bottom" data-dropdown-offset-distance="25" data-dropdown-offset-skidding="-10" class="flex items-center hover:text-navy-blue-300 cursor-pointer" title="Profile">
                        <span class="w-10 h-10 rounded-full text-lg font-bold bg-gray-100 dark:bg-gray-700 text-navy-blue-300 dark:text-navy-blue-200 flex items-center justify-center relative">
                            @php
                                echo  Str::upper(Str::substr($user->user_name, 0, 1))
                            @endphp
                            <span class="w-3 h-3 rounded-full bg-green-600 border-2 border-white dark:border-gray-800 top-6 -right-1 absolute"></span>
                        </span>
                        <div class="ml-2 hidden md:block">
                            <h6 class="font-medium text-sm">{{ $user->user_name }}</h6>
                            {{-- <p class="text-xs font-light">Administrator</p> --}}
                        </div>
                    </a>
                    <div id="profileDropContent" aria-labelledby="profileDropBtn" class="absolute w-48 h-auto bg-white dark:bg-gray-800 shadow-md top-14 right-2 rounded-md hidden">
                        <div class="flex items-center border-b border-b-gray-200 dark:border-b-gray-700 py-4 px-2">
                            <span class="w-10 h-10 rounded-full text-lg font-bold bg-gray-100 dark:bg-gray-700 text-navy-blue-300 dark:text-navy-blue-200 flex items-center justify-center relative">
                                @php
                                    echo  Str::upper(Str::substr($user->user_name, 0, 1))
                                @endphp
                                <span class="w-3 h-3 rounded-full bg-green-600 border-2 border-white dark:border-gray-800 top-6 -right-1 absolute"></span>
                            </span>
                            <div class="ml-2">
                                <h6 class="font-medium text-sm text-gray-900 dark:text-gray-400">{{ $user->user_name }}</h6>
                                {{-- <p class="text-xs font-light text-gray-900 dark:text-gray-400">Administrator</p> --}}
                            </div>
                        </div>
                        <div class="px-2 py-4 border-b border-b-gray-200 dark:border-b-gray-700">
                            <ul class="text-sm text-gray-600 dark:text-gray-400 font-medium">
                                <li>
                                    <a href="#" class="hover:text-navy-blue-300 dark:hover:text-navy-blue-200 flex items-center space-x-2">
                                        <i class="bi bi-person-circle"></i>
                                        <span>Profie</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="px-2 py-4">
                            <ul class="text-sm text-gray-600 dark:text-gray-400 font-medium">
                                <li>
                                    <a href="{{ route('oauth.logout')}}" class="hover:text-navy-blue-300 dark:hover:text-navy-blue-200 flex items-center space-x-2">
                                        <i class="bi bi-power"></i>
                                        <span>Sign out</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Side menu -->
    <aside id="offCanvasSideMenu" class="fixed left-0 top-0 w-64 z-40 h-screen bg-white dark:bg-gray-800 border-r border-r-gray-200 dark:border-r-gray-700 -translate-x-full sm:translate-x-0 transition-transform delay-75" aria-label="Sidebar">
        <div class="mt-16">
            <div class="px-2 py-4 flex items-center border-b border-b-gray-200 dark:border-b-gray-700">
                <span class="w-10 h-10 rounded-full text-lg font-bold bg-gray-100 dark:bg-gray-700 text-navy-blue-300 dark:text-navy-blue-200 flex items-center justify-center relative">
                    @php
                       echo  Str::upper(Str::substr($user->user_name, 0, 1))
                    @endphp
                    <span class="w-3 h-3 rounded-full bg-green-600 border-2 border-white dark:border-gray-800 top-6 -right-1 absolute"></span>
                </span>
                <div class="ml-2 dark:text-gray-400">
                    <h6 class="font-medium text-sm">{{ $user->user_name }}</h6>
                    {{-- <p class="text-xs font-light">Administrator</p> --}}
                </div>
            </div>
            <div class="py-4 overflow-y-scroll h-[482px]">
                <ul class="px-2 text-sm text-gray-600 dark:text-gray-400 font-medium" id="accordion">
                    <li>
                        <a href="#" class="flex items-center space-x-3 bg-navy-blue-500 hover:bg-navy-blue-300 text-white rounded-lg shadow-md px-2 py-2">
                            <i class="bi bi-house-door"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="mt-5">
                        <a href="{{ route('category.index') }}" class="flex items-center space-x-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 px-2 py-2 link" target="_blank">
                            <i class="bi bi-box-seam"></i>
                            <span class="flex-1">Categories</span>
                            <i class="bi bi-chevron-down"></i>
                        </a>
                    </li>
                    <li class="">
                        <a href="#" class="flex items-center space-x-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 px-2 py-2 link">
                            <i class="bi bi-person-vcard"></i>
                            <span class="flex-1">Employees</span>
                            <i class="bi bi-chevron-down"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center space-x-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 px-2 py-2" target="_blank">
                            <i class="bi bi-pc-display-horizontal"></i>
                            <span>POS</span>
                        </a>
                    </li>
                    <li class="">
                        <a href="{{ route('product.index') }}" class="flex items-center space-x-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 px-2 py-2 link" target="_blank">
                            <i class="bi bi-boxes"></i>
                            <span class="flex-1">Item Register</span>
                            <i class="bi bi-chevron-down"></i>
                        </a>
                    </li>
                    <li class="">
                        <a href="#" class="flex items-center space-x-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 px-2 py-2 link">
                            <i class="bi bi-truck"></i>
                            <span class="flex-1">Suppliers</span>
                            <i class="bi bi-chevron-down"></i>
                        </a>
                        <ul class="submenu bg-gray-100 dark:bg-gray-700">
                            <li>
                                <a href="#" class="flex items-center space-x-3 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 px-2 py-2">
                                    <span>Create Category</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center space-x-3 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 px-2 py-2">
                                    <span>Manage Categories</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="">
                        <a href="{{ route('oauth.index') }}" class="flex items-center space-x-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 px-2 py-2 link" target="_blank">
                            <i class="bi bi-person-add"></i>
                            <span class="flex-1">Users</span>
                            <i class="bi bi-chevron-down"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </aside>

    <!-- Right panel -->
    <div class="sm:ml-64">
        <div class="mt-16 px-4 py-4">
            @yield('content')
        </div>
    </div>
</body>
</html>
