@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    {{-- Filter Header --}}
    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 flex justify-between items-center">
        <form method="GET" action="{{ route('admin.schedules.index') }}" class="flex items-center gap-4">
            <div class="flex items-center gap-2">
                <label class="text-xs font-bold text-gray-500 uppercase">Section:</label>
                <select name="section" onchange="this.form.submit()" class="rounded-lg border-gray-300 font-bold text-indigo-600 focus:ring-indigo-500">
                    <option value="">-- All --</option>
                    @foreach($sections as $sec)
                        <option value="{{ $sec }}" {{ $selectedSection == $sec ? 'selected' : '' }}>
                            Section {{ $sec }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-center gap-2">
                <label class="text-xs font-bold text-gray-500 uppercase">Term:</label>
                <select name="semester" onchange="this.form.submit()" class="rounded-lg border-gray-300 font-bold text-indigo-600 focus:ring-indigo-500">
                    <option value="">-- All --</option>
                    <option value="1" {{ request('semester') == '1' ? 'selected' : '' }}>1st Semester</option>
                    <option value="2" {{ request('semester') == '2' ? 'selected' : '' }}>2nd Semester</option>
                </select>
            </div>

            @if($selectedSection || request('semester'))
                <a href="{{ route('admin.schedules.index') }}" class="text-xs text-rose-500 hover:underline">
                    <i class="fas fa-times-circle mr-1"></i>Clear Filters
                </a>
            @endif
        </form>

        <a href="{{ route('admin.schedules.create') }}" class="bg-indigo-600 text-white px-5 py-2 rounded-lg font-bold shadow-md hover:bg-indigo-700 transition">
            <i class="fas fa-plus mr-2"></i>New Slot
        </a>
    </div>

    @if(!$selectedSection)
        <div class="bg-indigo-50 border border-indigo-100 p-10 rounded-3xl text-center">
            <i class="fas fa-layer-group text-indigo-200 text-6xl mb-4"></i>
            <h2 class="text-indigo-900 font-black text-xl">Select a Section to View Timetable</h2>
            <p class="text-indigo-600/70 text-sm">Use the dropdown above to filter by section.</p>
        </div>
    @else
        @forelse($schedules as $sectionName => $days)
            <div class="bg-white rounded-3xl shadow-xl border border-gray-200 overflow-hidden">
                <div class="bg-indigo-600 p-4 text-white flex justify-between items-center">
                    <h3 class="font-black uppercase tracking-tighter text-lg">Section {{ $sectionName }} — Weekly Plan</h3>
                    <span class="text-xs opacity-75">Mon-Fri Only</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th class="p-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest border-r w-32">Time</th>
                                {{-- REMOVED SATURDAY FROM HEAD --}}
                                @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'] as $day)
                                    <th class="p-4 text-center text-[11px] font-black text-gray-700 uppercase tracking-widest border-r last:border-r-0">
                                        {{ $day }}
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $timeSlots = [
                                    '07:00', '08:00', '09:00', '10:00', '11:00', '12:00', 
                                    '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00'
                                ];
                                $dayMap = ['Monday' => 'Mon', 'Tuesday' => 'Tue', 'Wednesday' => 'Wed', 'Thursday' => 'Thu', 'Friday' => 'Fri'];
                                $skipCells = []; 
                            @endphp

                            @foreach($timeSlots as $time)
                                <tr class="border-b border-gray-100 hover:bg-gray-50/50 transition">
                                    <td class="p-3 text-center border-r bg-gray-50/30">
                                        <span class="text-[10px] font-bold text-gray-400">{{ \Carbon\Carbon::parse($time)->format('h:i A') }}</span>
                                    </td>
                                    
                                    {{-- REMOVED SATURDAY FROM BODY LOOP --}}
                                    @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'] as $dayName)
                                        @php
                                            $timeKey = $dayName . '-' . $time;
                                            if (isset($skipCells[$timeKey])) continue;

                                            $shortDay = $dayMap[$dayName] ?? substr($dayName, 0, 3);
                                            $currentDaySlots = $days[$dayName] ?? ($days[$shortDay] ?? collect());

                                            // IMPROVED MATCHING: Checks if the start time falls within this hour block
                                            $slot = $currentDaySlots->first(function($s) use ($time) {
                                                $sTime = \Carbon\Carbon::parse($s->start_time)->format('H');
                                                $gTime = \Carbon\Carbon::parse($time)->format('H');
                                                return $sTime === $gTime;
                                            });

                                            $rowSpan = 1;
                                            if ($slot && $slot->subject) {
                                                $rowSpan = (int) $slot->subject->units;
                                                for ($i = 1; $i < $rowSpan; $i++) {
                                                    $futureTime = \Carbon\Carbon::parse($time)->addHours($i)->format('H:00');
                                                    $skipCells[$dayName . '-' . $futureTime] = true;
                                                }
                                            }
                                        @endphp

                                        <td class="p-1 border-r last:border-r-0 min-w-[160px] relative" rowspan="{{ $rowSpan }}">
                                            @if($slot && $slot->subject && $slot->instructor)
                                                <div class="h-full w-full p-2 rounded-xl bg-indigo-50 border-l-4 border-indigo-500 shadow-sm flex flex-col justify-between overflow-hidden group min-h-[80px]">
                                                    <div>
                                                        <div class="text-[9px] font-black text-indigo-600 uppercase mb-1">
                                                            {{ \Carbon\Carbon::parse($slot->start_time)->format('h:i') }} - {{ \Carbon\Carbon::parse($slot->end_time)->format('h:i A') }}
                                                        </div>
                                                        <div class="text-[11px] font-bold text-gray-800 leading-tight">
                                                            {{ $slot->subject->name }}
                                                        </div>
                                                    </div>

                                                    <div class="mt-2 flex items-center justify-between border-t border-indigo-100 pt-1">
                                                        <span class="text-[9px] text-gray-500 truncate">
                                                            <i class="fas fa-user-tie mr-1 opacity-50"></i>{{ $slot->instructor->name }}
                                                        </span>
                                                        <span class="text-[9px] font-black text-rose-500 bg-rose-50 px-1.5 py-0.5 rounded">
                                                            {{ $slot->room }}
                                                        </span>
                                                    </div>

                                                    <form action="{{ route('admin.schedules.destroy', $slot->id) }}" method="POST" class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" onclick="return confirm('Remove slot?')" class="text-rose-400 hover:text-rose-600">
                                                            <i class="fas fa-times-circle text-xs"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Summary Table Section (Updated to exclude Saturday) --}}
            <div class="mt-8 bg-white rounded-3xl shadow-xl border border-gray-200 overflow-hidden">
                <div class="bg-gray-800 p-4 text-white flex items-center gap-2">
                    <i class="fas fa-list-ul text-gray-400"></i>
                    <h3 class="font-bold uppercase tracking-tight text-sm">Course Summary & Load</h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="p-4 text-[10px] font-black text-gray-500 uppercase">Subject Name</th>
                                <th class="p-4 text-[10px] font-black text-gray-500 uppercase text-center">Day</th>
                                <th class="p-4 text-[10px] font-black text-gray-500 uppercase">Time & Room</th>
                                <th class="p-4 text-[10px] font-black text-gray-500 uppercase">Instructor</th>
                                <th class="p-4 text-[10px] font-black text-gray-500 uppercase text-center">Units</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @php 
                                $filteredSchedules = collect($days)->flatten()->filter(function($item) use ($sectionName) {
                                    // Filter for section AND ensure no Saturdays appear in summary either
                                    return $item->section_name === $sectionName && !str_contains(strtolower($item->day), 'sat');
                                });

                                $uniqueSubjects = $filteredSchedules->unique('subject_id');
                                $totalUnits = $uniqueSubjects->sum(fn($s) => $s->subject->units);
                            @endphp

                            @foreach($uniqueSubjects as $s)
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="p-4">
                                        <div class="font-bold text-gray-800 text-xs">{{ $s->subject->name }}</div>
                                        <div class="text-[9px] text-gray-400 font-mono">{{ $s->subject->code }}</div>
                                    </td>
                                    <td class="p-4 text-center">
                                        @php
                                            $daysMet = $filteredSchedules->where('subject_id', $s->subject_id)
                                                                        ->pluck('day')
                                                                        ->unique();
                                        @endphp
                                        <div class="flex flex-wrap justify-center gap-1">
                                            @foreach($daysMet as $d)
                                                <span class="px-1.5 py-0.5 rounded bg-indigo-50 text-indigo-600 font-bold text-[8px] uppercase">
                                                    {{ substr($d, 0, 3) }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="p-4">
                                        <div class="text-xs text-gray-700 font-semibold">
                                            {{ \Carbon\Carbon::parse($s->start_time)->format('h:i A') }}
                                        </div>
                                        <div class="text-[10px] text-rose-500 font-black">
                                            <i class="fas fa-door-open mr-1"></i>{{ $s->room }}
                                        </div>
                                    </td>
                                    <td class="p-4 text-xs text-gray-600 italic">
                                        {{ $s->instructor->name }}
                                    </td>
                                    <td class="p-4 text-center font-black text-gray-800 text-xs">
                                        {{ number_format($s->subject->units, 1) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50 font-black">
                            <tr>
                                <td colspan="4" class="p-4 text-right text-xs text-gray-500 uppercase tracking-widest">Total Academic Load:</td>
                                <td class="p-4 text-center text-indigo-600 text-sm">
                                    {{ number_format($totalUnits, 1) }} Units
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div> 
        @empty
            <div class="bg-white p-10 rounded-3xl text-center border border-dashed border-gray-300">
                <p class="text-gray-500">No schedules found for this section.</p>
            </div>
        @endforelse
    @endif
</div>
@endsection