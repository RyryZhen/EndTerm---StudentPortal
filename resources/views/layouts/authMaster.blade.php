<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - @yield('title')</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,800,900&display=swap" rel="stylesheet" />
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body { font-family: 'Figtree', sans-serif; }
        .auth-gradient {
            background: radial-gradient(circle at top right, #6366f1 0%, #4f46e5 20%, #1e1b4b 100%);
        }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4">

    <div class="fixed top-0 left-0 w-full h-full overflow-hidden pointer-events-none z-0">
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-indigo-100 rounded-full blur-[100px] opacity-50"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-rose-100 rounded-full blur-[100px] opacity-30"></div>
    </div>

    <div class="w-full max-w-5xl grid grid-cols-1 lg:grid-cols-2 bg-white rounded-[3rem] shadow-2xl overflow-hidden relative z-10 border border-slate-100">
        
        <div class="hidden lg:flex auth-gradient p-12 flex-col justify-between text-white relative overflow-hidden">
            <div class="relative z-10">
                <div class="flex items-center space-x-3 mb-10">
                    <div class="w-10 h-10 bg-white/20 backdrop-blur-md rounded-xl flex items-center justify-center border border-white/30">
                        <i class="fas fa-graduation-cap text-white"></i>
                    </div>
                    <span class="text-xl font-black tracking-tighter uppercase">Smart Portal</span>
                </div>
                
                <h2 class="text-5xl font-black leading-tight mb-6">Master your <br><span class="text-indigo-200">academic</span> journey.</h2>
                <p class="text-indigo-100 text-lg font-medium opacity-80 max-w-sm">
                    Access your schedules, enroll in subjects, and build your future with the most advanced scheduler yet.
                </p>
            </div>

   

            <div class="absolute inset-0 opacity-10 pointer-events-none" style="background-image: url('https://www.transparenttextures.com/patterns/cubes.png');"></div>
        </div>

        <div class="p-8 md:p-16 lg:p-20 flex flex-col justify-center bg-white">
            <div class="mb-10 text-center lg:text-left">
                <h1 class="text-3xl font-black text-slate-800 tracking-tight">@yield('header')</h1>
                <p class="text-slate-400 font-medium mt-2">@yield('subheader')</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 p-4 bg-rose-50 rounded-2xl border border-rose-100">
                    <ul class="list-none text-sm text-rose-600 font-bold">
                        @foreach ($errors->all() as $error)
                            <li><i class="fas fa-exclamation-circle mr-2"></i> {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')

            <div class="mt-12 text-center lg:text-left pt-8 border-t border-slate-50">
                <p class="text-slate-400 text-sm font-bold">
                    &copy; {{ date('Y') }} Smart Scheduler Systems. 
                    <span class="block lg:inline ml-0 lg:ml-2">Empowering student success.</span>
                </p>
            </div>
        </div>
    </div>

</body>
</html>