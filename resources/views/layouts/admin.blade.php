<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    <div class="flex flex-col md:flex-row">
        @include('layouts.partials.admin-nav')

        <div class="main-content flex-1 bg-gray-100 mt-12 md:mt-2 pb-24 md:pb-5">
            <div class="bg-indigo-800 pt-3">
                <div class="rounded-tl-3xl bg-gradient-to-r from-indigo-900 to-indigo-800 p-4 shadow text-2xl text-white">
                    <h1 class="font-bold pl-2">@yield('header', 'Admin Dashboard')</h1>
                </div>
            </div>

            <div class="p-8">
                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 shadow">
                        {{ session('success') }}
                    </div>
                @endif

                @yield('content')
            </div>

            @include('layouts.partials.admin-footer')
        </div>
    </div>

</body>
</html>