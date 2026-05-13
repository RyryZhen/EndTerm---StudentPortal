@extends('layouts.admin')

@section('title', 'Manage Subjects')
@section('header', 'Subject Curriculum')

@section('content')
{{-- Alpine.js is already in your Master Layout, so we don't need to load it again --}}

<div x-data="{ activeYear: 1 }" class="space-y-6">
    
    {{-- Year Selection Tabs --}}
    <div class="flex flex-wrap gap-2 p-1.5 bg-gray-200/50 rounded-2xl w-fit backdrop-blur-sm border border-gray-200">
        @foreach([1 => '1st Year', 2 => '2nd Year', 3 => '3rd Year', 4 => '4th Year'] as $num => $label)
            <button type="button" 
                @click="activeYear = {{ $num }}" 
                :class="activeYear === {{ $num }} ? 'bg-white text-indigo-600 shadow-md scale-105' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-100'"
                class="px-8 py-2.5 rounded-xl font-black text-xs uppercase tracking-wider transition-all duration-300">
                {{ $label }}
            </button>
        @endforeach
    </div>

    {{-- Semesters Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        @foreach([1 => 'First Semester', 2 => 'Second Semester'] as $semNum => $semLabel)
        <div class="space-y-4">
            <h3 class="text-sm font-black text-slate-400 uppercase tracking-[0.2em] flex items-center px-2">
                <i class="fas fa-layer-group mr-2 text-indigo-500"></i>
                {{ $semLabel }}
            </h3>

            <div class="bg-white rounded-[32px] shadow-xl shadow-indigo-900/5 border border-gray-100 overflow-hidden">
                <table class="w-full text-left border-collapse text-sm">
                    <thead class="bg-slate-50/80 text-slate-400 uppercase text-[9px] font-black tracking-widest">
                        <tr>
                            <th class="px-6 py-4 border-b border-gray-100">Code</th>
                            <th class="px-6 py-4 border-b border-gray-100">Description</th>
                            <th class="px-6 py-4 border-b border-gray-100 text-center">Units</th>
                            <th class="px-6 py-4 border-b border-gray-100 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach([1, 2, 3, 4] as $year)
                          {{-- Inside your Blade loop --}}
@php 
    // Securely fetch the nested collection
    $yearData = $subjects->get($year) ?? collect();
    $currentSubs = $yearData->get($semNum) ?? collect();
@endphp

                            {{-- Rows for specific year --}}
                            @forelse($currentSubs as $subject)
                                <tr x-show="activeYear === {{ $year }}" 
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 translate-y-2"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    class="hover:bg-indigo-50/30 transition-colors group">
                                    
                                    <td class="px-6 py-4 font-bold text-indigo-600 uppercase tracking-tighter">{{ $subject->code }}</td>
                                    <td class="px-6 py-4">
                                        <div class="text-slate-700 font-semibold leading-snug group-hover:text-indigo-900 transition-colors">
                                            {{ $subject->name }}
                                        </div>
                                        {{-- Assuming pre-requisite logic --}}
                                        @if($subject->pre_req_code)
                                            <span class="inline-block px-2 py-0.5 bg-rose-50 text-rose-500 text-[9px] font-black rounded uppercase mt-1 border border-rose-100">
                                                Pre-req: {{ $subject->pre_req_code }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-slate-100 text-slate-600 font-bold text-xs">
                                            {{ number_format($subject->units, 0) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('admin.subjects.edit', $subject->id) }}" class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition">
                                                <i class="fas fa-pen-nib"></i>
                                            </a>
                                            <form action="{{ route('admin.subjects.destroy', $subject->id) }}" method="POST" class="inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition" onclick="return confirm('Delete this subject?')">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr x-show="activeYear === {{ $year }}">
                                    <td colspan="4" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <div class="w-12 h-12 bg-slate-50 rounded-full flex items-center justify-center mb-2">
                                                <i class="fas fa-folder-open text-slate-200"></i>
                                            </div>
                                            <p class="text-slate-400 text-xs font-medium">No subjects recorded for this term.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Floating Action Button --}}
    <div class="fixed bottom-10 right-10 group">
        <div class="absolute -top-12 right-0 bg-slate-800 text-white text-[10px] px-3 py-1 rounded-lg font-bold opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap uppercase tracking-widest shadow-xl">
            Add New Subject
        </div>
        <a href="{{ route('admin.subjects.create') }}" 
           class="bg-indigo-600 text-white w-16 h-16 rounded-[22px] flex items-center justify-center shadow-2xl shadow-indigo-500/40 hover:bg-indigo-700 hover:rotate-90 hover:rounded-full transition-all duration-500">
            <i class="fas fa-plus text-2xl"></i>
        </a>
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
</style>
@endsection