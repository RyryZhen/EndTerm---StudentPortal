@extends('layouts.admin')

@section('title', 'Admin Hub')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-10">
        <h1 class="text-4xl font-black text-slate-800 tracking-tight">Admin Control Center</h1>
        <p class="text-slate-500 mt-2 font-medium">Real-time overview of your academic ecosystem.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        <a href="#" class="group p-8 bg-white rounded-[2rem] shadow-xl shadow-slate-100 border border-slate-50 hover:scale-[1.02] transition-all duration-300">
            <div class="w-12 h-12 bg-indigo-50 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-indigo-600 transition-colors">
                <i class="fas fa-user-graduate text-indigo-600 group-hover:text-white"></i>
            </div>
            <h3 class="text-slate-400 font-bold uppercase text-xs tracking-widest">Total Students</h3>
            <h2 class="text-4xl font-black text-slate-800 mt-1">{{ $students }}</h2>
            <div class="mt-6 flex items-center text-indigo-600 font-bold text-sm">
                View Directory <i class="fas fa-arrow-right ml-2 text-xs group-hover:translate-x-1 transition-transform"></i>
            </div>
        </a>

        <a href="#" class="group p-8 bg-white rounded-[2rem] shadow-xl shadow-slate-100 border border-slate-50 hover:scale-[1.02] transition-all duration-300">
            <div class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-emerald-500 transition-colors">
                <i class="fas fa-chalkboard-teacher text-emerald-600 group-hover:text-white"></i>
            </div>
            <h3 class="text-slate-400 font-bold uppercase text-xs tracking-widest">Active Faculty</h3>
            <h2 class="text-4xl font-black text-slate-800 mt-1">{{ $instructors }}</h2>
            <div class="mt-6 flex items-center text-emerald-500 font-bold text-sm">
                Manage Staff <i class="fas fa-arrow-right ml-2 text-xs group-hover:translate-x-1 transition-transform"></i>
            </div>
        </a>

        <a href="{{ route('admin.schedules.index') }}" class="group p-8 bg-white rounded-[2rem] shadow-xl shadow-slate-100 border border-slate-50 hover:scale-[1.02] transition-all duration-300">
            <div class="w-12 h-12 bg-amber-50 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-amber-500 transition-colors">
                <i class="fas fa-calendar-alt text-amber-600 group-hover:text-white"></i>
            </div>
            <h3 class="text-slate-400 font-bold uppercase text-xs tracking-widest">Class Slots</h3>
            <h2 class="text-4xl font-black text-slate-800 mt-1">{{ $schedules }}</h2>
            <div class="mt-6 flex items-center text-amber-500 font-bold text-sm">
                Optimize Timetable <i class="fas fa-arrow-right ml-2 text-xs group-hover:translate-x-1 transition-transform"></i>
            </div>
        </a>

        <a href="#" class="group p-8 bg-white rounded-[2rem] shadow-xl shadow-slate-100 border border-slate-50 hover:scale-[1.02] transition-all duration-300">
            <div class="w-12 h-12 bg-rose-50 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-rose-500 transition-colors">
                <i class="fas fa-file-signature text-rose-600 group-hover:text-white"></i>
            </div>
            <h3 class="text-slate-400 font-bold uppercase text-xs tracking-widest">Enrollments</h3>
            <h2 class="text-4xl font-black text-slate-800 mt-1">{{ $enrollments }}</h2>
            <div class="mt-6 flex items-center text-rose-500 font-bold text-sm">
                View Reports <i class="fas fa-arrow-right ml-2 text-xs group-hover:translate-x-1 transition-transform"></i>
            </div>
        </a>
    </div>

    <div class="mt-16 bg-slate-900 rounded-[3rem] p-10 shadow-2xl shadow-indigo-200 relative overflow-hidden">
        <div class="relative z-10">
            <h2 class="text-2xl font-black text-white mb-2">Management Toolkit</h2>
            <p class="text-slate-400 mb-8 max-w-md">Quickly expand your curriculum or update the institutional schedule.</p>
            
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('admin.subjects.create') }}" class="bg-indigo-500 text-white px-8 py-4 rounded-2xl font-bold hover:bg-indigo-400 transition shadow-lg shadow-indigo-500/20 flex items-center">
                    <i class="fas fa-plus-circle mr-2"></i> Create New Subject
                </a>
                <a href="{{ route('admin.schedules.index') }}" class="bg-slate-800 text-white border border-slate-700 px-8 py-4 rounded-2xl font-bold hover:bg-slate-700 transition flex items-center">
                    <i class="fas fa-clock mr-2 text-indigo-400"></i> Configure Time Slots
                </a>
            </div>
        </div>
        
        <div class="absolute -right-20 -top-20 w-64 h-64 bg-indigo-600 rounded-full blur-[100px] opacity-20"></div>
        <div class="absolute -left-20 -bottom-20 w-64 h-64 bg-emerald-600 rounded-full blur-[100px] opacity-10"></div>
    </div>
</div>
@endsection