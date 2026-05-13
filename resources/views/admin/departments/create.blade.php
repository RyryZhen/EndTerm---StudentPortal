@extends('layouts.admin')

@section('title', 'Create Department')

@section('content')
<div class="p-6 md:p-10">
    <div class="mb-8">
        <nav class="flex mb-4 text-xs font-black uppercase tracking-widest text-slate-400">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-indigo-600 transition">Dashboard</a>
            <span class="mx-2">/</span>
            <a href="{{ route('admin.departments.index') }}" class="hover:text-indigo-600 transition">Departments</a>
            <span class="mx-2">/</span>
            <span class="text-indigo-600">New Unit</span>
        </nav>
        <h1 class="text-4xl font-black text-slate-800 tracking-tight">Register New Unit</h1>
        <p class="text-slate-500 font-medium mt-1">Define a new academic department and its identification code.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <div class="bg-white rounded-[2.5rem] border border-slate-100 p-8 md:p-12 shadow-sm">
                <form action="{{ route('admin.departments.store') }}" method="POST" class="space-y-8">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="md:col-span-2">
                            <label for="name" class="block text-xs font-black uppercase text-slate-400 mb-3 tracking-widest">
                                Full Department Name
                            </label>
                            <input type="text" 
                                   name="name" 
                                   id="name"
                                   value="{{ old('name') }}"
                                   required
                                   placeholder="e.g., College of Architecture & Fine Arts"
                                   class="w-full bg-slate-50 border-none rounded-2xl p-4 focus:ring-2 focus:ring-indigo-500 font-bold text-slate-700 transition placeholder:text-slate-300">
                            @error('name')
                                <p class="mt-2 text-xs text-rose-500 font-bold italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="code" class="block text-xs font-black uppercase text-slate-400 mb-3 tracking-widest">
                                Short Code (Identifier)
                            </label>
                            <input type="text" 
                                   name="code" 
                                   id="code"
                                   value="{{ old('code') }}"
                                   required
                                   placeholder="e.g., COA"
                                   class="w-full bg-slate-50 border-none rounded-2xl p-4 focus:ring-2 focus:ring-indigo-500 font-black text-slate-700 transition placeholder:text-slate-300 uppercase">
                            <p class="mt-2 text-[10px] text-slate-400 font-bold">This code will be used as a prefix for subjects.</p>
                            @error('code')
                                <p class="mt-2 text-xs text-rose-500 font-bold italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-black uppercase text-slate-400 mb-3 tracking-widest">
                                Initial Status
                            </label>
                            <div class="flex items-center space-x-4 p-4 bg-slate-50 rounded-2xl">
                                <div class="w-3 h-3 bg-emerald-500 rounded-full animate-pulse"></div>
                                <span class="text-sm font-black text-slate-600 uppercase">Active on Creation</span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 flex items-center justify-end space-x-4 border-t border-slate-50">
                        <a href="{{ route('admin.departments.index') }}" class="text-sm font-black text-slate-400 hover:text-slate-600 transition uppercase tracking-widest">
                            Cancel
                        </a>
                        <button type="submit" class="bg-indigo-600 text-white px-10 py-4 rounded-2xl font-black shadow-xl shadow-indigo-100 hover:bg-indigo-700 transition transform hover:-translate-y-1 active:scale-95 uppercase tracking-widest">
                            Save Department
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-slate-900 rounded-[2.5rem] p-8 text-white shadow-xl shadow-slate-200">
                <div class="w-12 h-12 bg-indigo-500 rounded-2xl flex items-center justify-center mb-6">
                    <i class="fas fa-lightbulb text-xl"></i>
                </div>
                <h4 class="text-xl font-black mb-4">Pro Tip</h4>
                <p class="text-slate-400 font-medium leading-relaxed mb-6">
                    When creating codes for **Architecture**, use prefixes like <span class="text-indigo-400 font-black">COA</span>. For **Information Technology**, use <span class="text-indigo-400 font-black">CIT</span>. This helps the Smart Planner auto-categorize curriculum subjects.
                </p>
                <div class="p-4 bg-white/5 rounded-2xl border border-white/10">
                    <p class="text-[10px] font-black uppercase tracking-widest text-indigo-400 mb-2">Example Structure</p>
                    <p class="text-sm font-bold italic">"College of Information Technology" -> CIT</p>
                </div>
            </div>

            <div class="bg-indigo-50 rounded-[2.5rem] p-8 border border-indigo-100">
                <h4 class="text-sm font-black text-indigo-900 uppercase tracking-widest mb-2">Need Help?</h4>
                <p class="text-xs text-indigo-700 font-medium leading-relaxed">
                    Adding a department allows you to group students and instructors for better analytics and course management.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection