@extends('layouts.admin')

@section('title', 'Manage Subjects')
@section('header', 'Subject Curriculum')

@section('content')
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

<div x-data="{ activeYear: 1 }" class="space-y-6">
    
    <div class="flex flex-wrap gap-2 p-1 bg-gray-100 rounded-xl w-fit">
        @foreach([1 => '1st Year', 2 => '2nd Year', 3 => '3rd Year', 4 => '4th Year'] as $num => $label)
            <button type="button" 
                @click="activeYear = {{ $num }}" 
                :class="activeYear === {{ $num }} ? 'bg-white text-indigo-600 shadow-sm' : 'text-gray-500 hover:text-gray-700'"
                class="px-6 py-2 rounded-lg font-bold text-sm transition-all duration-200">
                {{ $label }}
            </button>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        @foreach([1 => 'First Semester', 2 => 'Second Semester'] as $semNum => $semLabel)
        <div class="space-y-4">
            <h3 class="text-lg font-bold text-slate-800 flex items-center">
                <span class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center mr-2 text-sm font-bold">
                    {{ $semNum }}
                </span>
                {{ $semLabel }}
            </h3>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <table class="w-full text-left border-collapse text-sm">
                    <thead class="bg-gray-50 text-gray-400 uppercase text-[10px] font-black tracking-widest">
                        <tr>
                            <th class="px-4 py-3 border-b">Code</th>
                            <th class="px-4 py-3 border-b">Description</th>
                            <th class="px-4 py-3 border-b text-center">Units</th>
                            <th class="px-4 py-3 border-b text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach([1, 2, 3, 4] as $year)
                            {{-- Filter subjects for this specific Year and Semester --}}
                            @php 
                                $yearGroup = $subjects->get($year);
                                $currentSubs = $yearGroup ? $yearGroup->get($semNum) : collect(); 
                            @endphp

                            @forelse($currentSubs as $subject)
                                <tr x-show="activeYear === {{ $year }}" x-cloak class="hover:bg-indigo-50/50 transition">
                                    <td class="px-4 py-3 font-bold text-indigo-600 uppercase">{{ $subject->code }}</td>
                                    <td class="px-4 py-3 text-gray-700 leading-tight">
                                        {{ $subject->name }}
                                        @if($subject->pre_req_code)
                                            <div class="text-[9px] text-rose-500 font-bold mt-0.5 uppercase">
                                                PRE-REQ: {{ $subject->pre_req_code }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-center font-medium">{{ number_format($subject->units, 1) }}</td>
                                    <td class="px-4 py-3 text-right space-x-2">
                                        <a href="{{ route('admin.subjects.edit', $subject->id) }}" class="text-blue-400 hover:text-blue-600">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.subjects.destroy', $subject->id) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-gray-300 hover:text-red-500" onclick="return confirm('Delete this subject?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr x-show="activeYear === {{ $year }}" x-cloak>
                                    <td colspan="4" class="px-4 py-8 text-center text-gray-400 italic text-xs">
                                        No subjects found for Year {{ $year }} - Sem {{ $semNum }}.
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

    <div class="fixed bottom-8 right-8">
        <a href="{{ route('admin.subjects.create') }}" 
           class="bg-indigo-600 text-white w-14 h-14 rounded-full flex items-center justify-center shadow-2xl hover:bg-indigo-700 hover:scale-110 transition-all duration-200">
           <i class="fas fa-plus text-xl"></i>
        </a>
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
</style>
@endsection