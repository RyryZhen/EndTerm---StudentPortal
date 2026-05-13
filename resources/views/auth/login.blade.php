@extends('layouts.authMaster')

@section('title', 'Login')
@section('header', 'Welcome Back')
@section('subheader', 'Sign in to manage your schedules.')

@section('content')
    @if (session('status'))
        <div class="mb-6 p-4 bg-emerald-50 rounded-2xl border border-emerald-100 text-emerald-600 text-sm font-bold">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <div>
            <label for="email" class="block text-xs font-black uppercase text-slate-400 mb-2 tracking-widest">
                Email Address
            </label>
            <input id="email" 
                   type="email" 
                   name="email" 
                   value="{{ old('email') }}" 
                   required 
                   autofocus 
                   autocomplete="username" 
                   class="w-full bg-slate-50 border-none rounded-2xl p-4 focus:ring-2 focus:ring-indigo-500 font-medium transition placeholder:text-slate-300"
                   placeholder="name@university.edu">
            @error('email')
                <p class="mt-2 text-xs text-rose-500 font-bold italic">{{ $message }}</p>
            @enderror
        </div>

        <div class="mt-4">
            <div class="flex justify-between items-center mb-2">
                <label for="password" class="block text-xs font-black uppercase text-slate-400 tracking-widest">
                    Password
                </label>
                @if (Route::has('password.request'))
                    <a class="text-xs font-bold text-indigo-600 hover:text-indigo-800 transition" href="{{ route('password.request') }}">
                        Forgot Password?
                    </a>
                @endif
            </div>
            
            <input id="password" 
                   type="password" 
                   name="password" 
                   required 
                   autocomplete="current-password" 
                   class="w-full bg-slate-50 border-none rounded-2xl p-4 focus:ring-2 focus:ring-indigo-500 font-medium transition placeholder:text-slate-300"
                   placeholder="••••••••">
            @error('password')
                <p class="mt-2 text-xs text-rose-500 font-bold italic">{{ $message }}</p>
            @enderror
        </div>

        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <input id="remember_me" type="checkbox" name="remember" class="w-5 h-5 rounded-lg border-slate-200 text-indigo-600 shadow-sm focus:ring-indigo-500 transition cursor-pointer">
                <span class="ms-3 text-sm font-bold text-slate-500 group-hover:text-slate-700 transition">{{ __('Keep me logged in') }}</span>
            </label>
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full bg-indigo-600 text-white py-4 rounded-2xl font-black shadow-xl shadow-indigo-100 hover:bg-indigo-700 hover:shadow-indigo-200 transition transform hover:-translate-y-0.5 active:scale-95 flex items-center justify-center">
                {{ __('LOG IN TO PORTAL') }}
                <i class="fas fa-arrow-right ml-2 text-sm opacity-70"></i>
            </button>
        </div>

        
    </form>
@endsection