@extends('layouts.student')

@section('title', 'Student Dashboard')
@section('header', 'Academic Overview')


@section('content')
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    
    <div class="lg:col-span-4 space-y-8">
        
        <section>
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-2xl p-6 mb-8 text-white shadow-lg flex justify-between items-center">
    <div>
        <h2 class="text-xl font-bold">Ready to enroll ka-PSUnian?</h2>
        <p class="text-indigo-100 text-sm">Use Smart Scheduler to generate a conflict-free schedule para sayo!</p>
    </div>
    <a href="{{ route('student.planner') }}" class="bg-white text-indigo-600 px-6 py-3 rounded-xl font-bold hover:bg-indigo-50 transition">
        Open Smart Scheduler
    </a>
</div>
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-bold text-slate-800 flex items-center">
                    <i class="fas fa-magic text-indigo-500 mr-2"></i> Smart Suggestions
                </h2>
                <span class="text-[10px] bg-indigo-100 text-indigo-700 px-2 py-0.5 rounded font-bold uppercase">Friday-Free Priority</span>
            </div>
            
            <div class="space-y-4">
                @forelse($suggested as $s)
                    <div class="bg-white border-2 border-indigo-500/20 p-5 rounded-2xl shadow-sm hover:shadow-md transition relative overflow-hidden group">
                        <div class="absolute top-0 right-0 bg-indigo-500 text-white text-[10px] px-3 py-1 rounded-bl-lg font-bold">
                            Score: {{ $s['score'] }}
                        </div>
                        
                        <h3 class="font-bold text-slate-800 leading-tight pr-10">{{ $s['schedule']->subject->name }}</h3>
                        <p class="text-xs text-slate-500 mt-1">{{ $s['schedule']->instructor->name }}</p>
                        
                        <div class="mt-4 flex items-center text-xs font-semibold text-indigo-600">
                            <i class="far fa-calendar-alt mr-2"></i> {{ $s['schedule']->day }} 
                            <i class="far fa-clock ml-4 mr-2"></i> {{ \Carbon\Carbon::parse($s['schedule']->start_time)->format('h:i A') }}
                        </div>

                        <form method="POST" action="{{ route('student.enroll.store', $s['schedule']->id) }}" class="mt-4">
                            @csrf
                            <button type="submit" class="w-full bg-indigo-600 text-white py-2.5 rounded-xl text-sm font-bold hover:bg-indigo-700 transition shadow-indigo-200 shadow-lg">
                                Quick Enroll
                            </button>
                        </form>
                    </div>
                @empty
                    <div class="text-center py-6 bg-slate-100 rounded-2xl border border-dashed border-slate-300">
                        <p class="text-slate-400 text-sm italic">No new suggestions found.</p>
                    </div>
                @endforelse
            </div>
        </section>

        <section>
            <h2 class="text-lg font-bold text-slate-800 mb-4 flex items-center">
                <i class="fas fa-list text-slate-400 mr-2"></i> Manual Enrollment
            </h2>
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 divide-y max-h-[400px] overflow-y-auto">
                @foreach($schedules as $schedule)
                    <div class="p-4 hover:bg-slate-50 flex justify-between items-center group">
                        <div>
                            <div class="text-sm font-bold text-slate-700">{{ $schedule->subject->code }}</div>
                            <div class="text-[11px] text-slate-500">{{ $schedule->day }} | {{ $schedule->start_time }}</div>
                        </div>
                        <form method="POST" action="{{ route('student.enroll.store', $schedule->id) }}">
                            @csrf
                            <button class="opacity-0 group-hover:opacity-100 bg-slate-200 text-slate-700 p-2 rounded-lg hover:bg-indigo-600 hover:text-white transition">
                                <i class="fas fa-plus"></i>
                            </button>
                        </form>
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
                    <span class="w-3 h-3 bg-red-400 rounded-full"></span>
                    <span class="w-3 h-3 bg-yellow-400 rounded-full"></span>
                    <span class="w-3 h-3 bg-green-400 rounded-full"></span>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full table-fixed border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200">
                            @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'] as $day)
                                <th class="py-4 px-2 text-[10px] font-black uppercase text-slate-400 tracking-widest">{{ $day }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'] as $day)
                                <td class="border-r border-slate-100 last:border-0 p-2 align-top h-96 bg-slate-50/20">
                                    @if(isset($timetable[$day]))
                                        @foreach($timetable[$day] as $class)
                                            <div class="bg-white border-l-4 border-indigo-600 p-3 rounded-r-lg shadow-sm mb-3 timetable-slot">
                                                <div class="text-[11px] font-black text-slate-800 truncate">{{ $class['subject'] }}</div>
                                                <div class="text-[9px] text-indigo-500 font-bold mt-1 uppercase">
                                                    {{ \Carbon\Carbon::parse($class['start'])->format('g:i A') }}
                                                </div>
                                                <div class="text-[9px] text-slate-400 mt-2 truncate italic">
                                                    {{ $class['instructor'] }}
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="flex items-center justify-center h-full opacity-20">
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