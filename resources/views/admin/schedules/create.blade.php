@extends('layouts.admin')

@section('content')
{{-- Ensure Alpine.js is loaded in your layout, or add it here: --}}
{{-- <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}

<div class="max-w-4xl mx-auto" 
     x-data="{ 
        year: '{{ $selectedYear ?? '' }}', 
        sem: '{{ $selectedSem ?? '' }}' 
     }">
    
    <div class="bg-indigo-900 p-6 rounded-t-xl shadow-lg border-b border-indigo-800">
        <h2 class="text-white font-bold mb-4 text-sm uppercase tracking-widest text-center md:text-left">
            <i class="fas fa-filter mr-2"></i>Step 1: Define Target Group
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-bold text-indigo-200 mb-1 uppercase">Year Level</label>
                <select x-model="year" 
                    @change="window.location.href = '?year='+year+'&semester='+sem" 
                    class="w-full rounded-lg bg-indigo-800 text-white border-none focus:ring-2 focus:ring-white p-2">
                    <option value="">Select Year</option>
                    @foreach([1,2,3,4] as $y) 
                        <option value="{{ $y }}" {{ $selectedYear == $y ? 'selected' : '' }}>Year {{ $y }}</option> 
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-indigo-200 mb-1 uppercase">Semester</label>
                <select x-model="sem" 
                    @change="window.location.href = '?year='+year+'&semester='+sem" 
                    class="w-full rounded-lg bg-indigo-800 text-white border-none focus:ring-2 focus:ring-white p-2">
                    <option value="">Select Sem</option>
                    <option value="1" {{ $selectedSem == 1 ? 'selected' : '' }}>1st Semester</option>
                    <option value="2" {{ $selectedSem == 2 ? 'selected' : '' }}>2nd Semester</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-indigo-200 mb-1 uppercase">Target Section</label>
                <input type="text" name="section" form="mainForm" placeholder="e.g. 1A" required
                    class="w-full rounded-lg bg-white text-gray-900 border-none focus:ring-2 focus:ring-indigo-500 p-2">
            </div>
        </div>
    </div>

    <div class="bg-white shadow-lg rounded-b-xl border border-gray-200 overflow-hidden">
        <div class="p-8">
            @if(!$selectedYear || !$selectedSem)
                <div class="text-center py-10">
                    <div class="text-indigo-200 text-5xl mb-4"><i class="fas fa-layer-group"></i></div>
                    <h3 class="text-gray-400 font-medium italic">Please select Year and Semester above to load subjects.</h3>
                </div>
            @else
                <form id="mainForm" method="POST" action="{{ route('admin.schedules.store') }}" class="space-y-6">
    @csrf
    <input type="hidden" name="year_level" :value="year">
    <input type="hidden" name="semester" :value="sem">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Select Subject</label>
            <select name="subject_id" required class="w-full border-gray-300 rounded-lg shadow-sm p-3 border bg-white focus:ring-indigo-500">
                <option value="">-- Choose a Subject --</option>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}">{{ $subject->code }} - {{ $subject->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Assign Instructor</label>
            <select name="instructor_id" required class="w-full border-gray-300 rounded-lg shadow-sm p-3 border bg-white focus:ring-indigo-500">
                <option value="">-- Choose an Instructor --</option>
                @foreach($instructors as $instructor)
                    <option value="{{ $instructor->id }}">{{ $instructor->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1 text-indigo-600">Day</label>
            <select name="day" required class="w-full border-gray-300 rounded-lg shadow-sm p-3 border bg-white">
                @foreach(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'] as $day)
                    <option value="{{ $day }}">{{ $day }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1 text-indigo-600">Start Time</label>
            <input type="time" name="start_time" required class="w-full border-gray-300 rounded-lg shadow-sm p-3 border">
        </div>
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1 text-indigo-600">End Time</label>
            <input type="time" name="end_time" required class="w-full border-gray-300 rounded-lg shadow-sm p-3 border">
        </div>
    </div>

    <div class="bg-gray-50 p-4 rounded-lg border border-dashed border-gray-300">
        <label class="block text-sm font-semibold text-gray-700 mb-1">Room / Laboratory Assignment</label>
        <div class="relative">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                <i class="fas fa-door-open"></i>
            </span>
            <input type="text" name="room" placeholder="e.g. IT Lab 1, Room 302, or Gym" 
                class="w-full pl-10 border-gray-300 rounded-lg shadow-sm p-3 border focus:ring-indigo-500 focus:border-indigo-500">
        </div>
        <p class="mt-2 text-xs text-gray-500 italic">This helps prevent double-booking the same room at the same time.</p>
    </div>

    <div class="flex items-center justify-end pt-6 border-t border-gray-100">
        <button type="submit" class="bg-indigo-600 text-white px-12 py-3 rounded-lg hover:bg-indigo-700 shadow-xl font-bold transition transform hover:scale-105 active:scale-95">
            <i class="fas fa-check-circle mr-2"></i>Save Section Schedule
        </button>
    </div>
</form>
            @endif
        </div>
    </div>
</div>
@endsection