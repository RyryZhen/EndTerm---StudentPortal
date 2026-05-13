@extends('layouts.admin') {{-- Extends your sidebar-based admin layout --}}

@section('title', 'Departments')

@section('content')
<div class="p-6 md:p-10">
    <div class="mb-8">
        @if(session('error'))
    <div class="mb-8 p-6 bg-rose-50 border border-rose-100 rounded-[2rem] flex items-center shadow-sm">
        <div class="w-10 h-10 bg-rose-500 rounded-xl flex items-center justify-center text-white mr-4">
            <i class="fas fa-exclamation-circle"></i>
        </div>
        <p class="text-rose-600 font-bold text-sm">{{ session('error') }}</p>
    </div>
@endif
        @if(session('success'))
    <div class="mb-8 p-6 bg-emerald-50 border border-emerald-100 rounded-[2rem] flex items-center justify-between shadow-sm">
        <div class="flex items-center">
            <div class="w-10 h-10 bg-emerald-500 rounded-xl flex items-center justify-center text-white mr-4">
                <i class="fas fa-key"></i>
            </div>
            <div>
                <p class="text-emerald-800 font-black uppercase text-xs tracking-widest">Access Granted</p>
                <p class="text-emerald-600 font-bold text-sm">{{ session('success') }}</p>
            </div>
        </div>
        <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-emerald-600">
            <i class="fas fa-times"></i>
        </button>
    </div>
@endif
        <nav class="flex mb-4 text-xs font-black uppercase tracking-widest text-slate-400">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-indigo-600 transition">Dashboard</a>
            <span class="mx-2">/</span>
            <span class="text-indigo-600">Departments</span>
        </nav>
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-4xl font-black text-slate-800 tracking-tight">Academic Units</h1>
                <p class="text-slate-500 font-medium mt-1">Categorizing courses for Architecture and IT colleges.</p>
            </div>
            <a href="{{ route('admin.departments.create') }}" 
               class="inline-flex items-center justify-center bg-indigo-600 text-white px-8 py-4 rounded-2xl font-black shadow-xl shadow-indigo-200 hover:bg-indigo-700 transition transform hover:-translate-y-1">
                <i class="fas fa-plus mr-2"></i> ADD NEW UNIT
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
        @foreach($departments as $dept)
        <div class="relative bg-white rounded-[2.5rem] border border-slate-100 p-8 shadow-sm hover:shadow-xl hover:shadow-indigo-50/50 transition-all duration-300 group">
            
            <div class="absolute top-8 right-8 px-4 py-1 bg-slate-900 text-white text-[10px] font-black tracking-widest rounded-full group-hover:bg-indigo-600 transition-colors">
                {{ $dept->code }}
            </div>

            <div class="mb-6">
                <div class="w-14 h-14 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600 mb-4 group-hover:scale-110 transition-transform">
                    @if(str_contains($dept->code, 'ARC') || str_contains($dept->code, 'COA'))
                        <i class="fas fa-drafting-compass text-2xl"></i>
                    @else
                        <i class="fas fa-code text-2xl"></i>
                    @endif
                </div>
                <h3 class="text-2xl font-black text-slate-800 leading-tight">{{ $dept->name }}</h3>
            </div>

            <div class="grid grid-cols-2 gap-4 py-6 border-y border-slate-50">
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-tighter">Students</p>
                    <p class="text-xl font-black text-slate-700">{{ $dept->users_count ?? 0 }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-tighter">Subjects</p>
                    <p class="text-xl font-black text-slate-700">{{ $dept->subjects_count ?? 0 }}</p>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-between">
                <div class="flex -space-x-2">
                    {{-- Visual representation of "active" members --}}
                    <div class="w-8 h-8 rounded-full border-2 border-white bg-slate-200"></div>
                    <div class="w-8 h-8 rounded-full border-2 border-white bg-indigo-200"></div>
                    <div class="w-8 h-8 rounded-full border-2 border-white bg-rose-200"></div>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('admin.departments.edit', $dept->id) }}" class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-50 text-slate-400 hover:bg-indigo-50 hover:text-indigo-600 transition">
                        <i class="fas fa-pen text-xs"></i>
                    </a>
                  <div class="flex gap-2">
    <a href="{{ route('admin.departments.edit', $dept->id) }}" class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-50 text-slate-400 hover:bg-indigo-50 hover:text-indigo-600 transition">
        <i class="fas fa-pen text-xs"></i>
    </a>

    <form action="{{ route('admin.departments.destroy', $dept->id) }}" method="POST" onsubmit="return confirm('Are you sure? This will remove all departmental access.');">
        @csrf
        @method('DELETE')
        <button type="submit" class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-50 text-slate-400 hover:bg-rose-50 hover:text-rose-600 transition">
            <i class="fas fa-trash text-xs"></i>
        </button>
    </form>
</div>
                </div>
            </div>
        </div>
        @endforeach

        @if($departments->isEmpty())
        <div class="col-span-full py-20 text-center bg-slate-50 rounded-[3rem] border-2 border-dashed border-slate-200">
            <i class="fas fa-layer-group text-4xl text-slate-300 mb-4"></i>
            <p class="text-slate-500 font-bold uppercase tracking-widest text-sm">No departments found.</p>
        </div>
        @endif
    </div>
</div>
@endsection