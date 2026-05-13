@extends('layouts.student')

@section('title', 'Student Dashboard')
@section('header', 'Academic Overview')

@section('content')
@php
    $enrolledScheduleIds = $enrolled->pluck('schedule_id')->toArray();
@endphp

<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    
    <div class="lg:col-span-4 space-y-8">
        
        <section>
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-2xl p-6 mb-8 text-white shadow-lg flex flex-col gap-4">
                <div>
                    <h2 class="text-xl font-bold">Ready to enroll ka-PSUnian?</h2>
                    <p class="text-indigo-100 text-sm">Use Smart Scheduler to generate a conflict-free schedule para sayo!</p>
                </div>
                <a href="{{ route('student.planner') }}" class="bg-white text-indigo-600 px-6 py-3 rounded-xl font-bold hover:bg-indigo-50 transition text-center">
                    Open Smart Scheduler
                </a>
            </div>
        </section>

        <div class="bg-indigo-600 rounded-2xl p-6 text-white shadow-lg">
            <h2 class="text-xl font-bold">Official Enrollment</h2>
            <p class="text-indigo-100 text-sm mt-2">You are currently enrolled in <strong>{{ $enrolled->count() }}</strong> subjects.</p>
        </div>

        <section class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm">
            <h2 class="text-sm font-black text-slate-400 uppercase tracking-widest mb-4">Subject List</h2>
            <div class="space-y-3">
                @foreach($enrolled as $en)
                    <div class="flex items-center p-3 bg-slate-50 rounded-xl border border-slate-100">
                        <div class="w-2 h-2 bg-indigo-500 rounded-full mr-3"></div>
                        <span class="text-xs font-bold text-slate-700">{{ $en->schedule->subject->name }}</span>
                    </div>
                @endforeach
            </div>
        </section>
    </div>

    <div class="lg:col-span-8 space-y-8">
        
<section class="bg-white rounded-3xl shadow-xl border border-slate-200 overflow-hidden">
    <div class="bg-slate-800 p-6 flex justify-between items-center text-white">
        <h2 class="text-xl font-bold">Weekly Timetable</h2>
        <div class="flex space-x-2">
            <span class="text-[10px] font-bold bg-indigo-500 px-2 py-1 rounded">
                {{ $enrolled->count() }} Subjects Confirmed
            </span>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full table-fixed border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200">
                    @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'] as $day)
                        <th class="py-4 px-2 text-[10px] font-black uppercase text-slate-400 tracking-widest text-center">{{ $day }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                <tr>
                    @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'] as $day)
                        <td class="border-r border-slate-100 last:border-0 p-2 align-top h-96 bg-slate-50/20">
                            {{-- Check if this specific day has any classes in our filtered timetable --}}
                            @if(isset($timetable[$day]) && count($timetable[$day]) > 0)
                                @foreach($timetable[$day] as $class)
                                    <div class="bg-white border-l-4 border-indigo-600 p-3 rounded-r-lg shadow-sm mb-3 border-y border-r border-slate-100 transition-all hover:shadow-md">
                                        <div class="text-[11px] font-black text-slate-800 leading-tight">
                                            {{ $class['subject'] }}
                                        </div>
                                        <div class="text-[9px] text-indigo-500 font-bold mt-1 uppercase flex items-center">
                                            <i class="far fa-clock mr-1"></i>
                                            {{ \Carbon\Carbon::parse($class['start'])->format('g:i A') }}
                                        </div>
                                        <div class="text-[9px] text-slate-400 mt-2 truncate italic border-t border-slate-50 pt-1">
                                            {{ $class['instructor'] }}
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="flex items-center justify-center h-full opacity-10">
                                    <span class="text-[10px] font-bold uppercase rotate-90 tracking-widest text-slate-300">Vacant</span>
                                </div>
                            @endif
                        </td>
                    @endforeach
                </tr>
            </tbody>
        </table>
    </div>
</section>

        <section>
            <h2 class="text-lg font-bold text-slate-800 mb-4">Confirmed Enrollments</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($enrolled as $en)
                    <div class="bg-emerald-50 border border-emerald-100 p-4 rounded-2xl flex items-center">
                        <div class="bg-emerald-500 text-white p-3 rounded-xl mr-4 shadow-lg shadow-emerald-100">
                            <i class="fas fa-check"></i>
                        </div>
                        <div>
                            <div class="text-sm font-bold text-emerald-900">{{ $en->schedule->subject->name }}</div>
                            <div class="text-xs text-emerald-600 italic">Enrolled Successfully</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

    </div>
</div>
@endsection