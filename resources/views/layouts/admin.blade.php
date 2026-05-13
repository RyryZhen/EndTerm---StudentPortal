<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Portal') | URD-IT</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Plus+Jakarta+Sans', sans-serif; }
        /* Custom scrollbar for a cleaner feel */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #c7d2fe; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #818cf8; }
    </style>
</head>
<body class="bg-[#F8FAFC] text-slate-900 h-full antialiased">

   <div class="flex h-screen overflow-hidden bg-[#F8FAFC]">
    
    {{-- 1. FIXED SIDEBAR --}}
    {{-- We add h-screen and overflow-y-auto so the NAV can scroll if it has too many links --}}
    <aside class="z-50 w-64 flex-shrink-0 h-screen overflow-y-auto bg-indigo-900 shadow-xl">
        @include('layouts.partials.admin-nav')
    </aside>

    {{-- 2. INDEPENDENT SCROLL AREA --}}
    {{-- This 'main' tag is now the ONLY thing that scrolls --}}
    <main class="flex-1 flex flex-col h-screen overflow-y-auto relative focus:outline-none">
        
        {{-- Header stays at the top of the main scroll area --}}
        <header class="bg-indigo-700 sticky top-0 z-40 shadow-md">
            <div class="px-8 py-6 bg-gradient-to-r from-indigo-800 to-indigo-600 rounded-bl-[40px]">
                {{-- Header Content --}}
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-indigo-200 text-[10px] font-black uppercase tracking-[0.2em] mb-1">Administrator Access</p>
                        <h1 class="text-2xl font-black text-white tracking-tight">@yield('header', 'System Overview')</h1>
                    </div>
                </div>
            </div>
        </header>

        {{-- Content --}}
        <section class="p-8 flex-1">
            <div class="animate-fade-in-up">
                @yield('content')
            </div>
        </section>

        {{-- Footer --}}
        <footer class="mt-auto px-8 py-4 border-t border-gray-200 bg-white">
            @include('layouts.partials.admin-footer')
        </footer>
    </main>
</div>

    <style>
        .animate-fade-in-up {
            animation: fadeInUp 0.5s ease-out;
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>

</body>
</html>