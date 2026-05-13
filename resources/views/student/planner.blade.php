@extends('layouts.student')

@section('title', 'Smart Scheduler')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">
    <div class="mb-8 flex justify-between items-end">
        <div>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight">Smart Scheduler</h1>
            <p class="text-slate-500">Showing subjects for 
                <span class="text-indigo-600 font-bold">Year {{ auth()->user()->year_level }}</span>
            </p>
        </div>
        {{-- Visual Badge for Dept --}}
        <div class="px-4 py-2 bg-slate-100 rounded-2xl border border-slate-200">
            <span class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Department ID</span>
            <div class="text-lg font-black text-slate-700">{{ auth()->user()->department_id }}</div>
        </div>
    </div>

    <div class="bg-black text-green-400 p-4 font-mono text-xs mb-6 rounded-xl">
        Filtering active: Year {{ auth()->user()->year_level }} | 
        Dept: {{ auth()->user()->department_id }} | 
        Results: {{ $available_subjects->count() }}
    </div>

    <form action="{{ route('student.planner.generate') }}" method="POST" id="mainPlannerForm">
        @csrf
       <div id="selected-schedules-container">
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <div class="lg:col-span-4 space-y-6">
                {{-- Mega Helper now only shows relevant sections --}}
                <div class="bg-gradient-to-br from-indigo-600 to-violet-700 p-6 rounded-3xl shadow-xl border border-indigo-400/20">
                    <h3 class="font-bold text-white mb-2 flex items-center text-sm">
                        <i class="fas fa-bolt text-yellow-300 mr-2"></i> Mega Helper
                    </h3>
                    <p class="text-indigo-100 text-[10px] mb-4 uppercase tracking-widest font-bold">Load Year {{ auth()->user()->year_level }} Sections</p>
                    
                    <select id="sectionLoader" class="w-full bg-white/10 border-indigo-400/30 text-white rounded-xl text-sm focus:ring-yellow-400 focus:border-yellow-400 cursor-pointer">
                        <option value="" class="text-slate-800">Select a section...</option>
                        @foreach($sections as $section)
                            <option value="{{ $section['id'] }}" 
                                    class="text-slate-800" 
                                    data-subjects="{{ json_encode($section['subject_ids'] ?? []) }}">
                                Section {{ $section['name'] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200">
                    <h3 class="font-bold text-slate-800 mb-6 flex items-center">
                        <i class="fas fa-sliders text-indigo-500 mr-2"></i> Scheduling Rules
                    </h3>
                    
<div class="space-y-6">
    <div>
        <label class="block text-xs font-black uppercase text-slate-400 mb-3 tracking-widest">Preferred School Days</label>
        <div class="grid grid-cols-3 gap-2">
            @foreach(['Mon', 'Tue', 'Wed', 'Thu', 'Fri'] as $day)
                <label class="relative group">
                    {{-- 1. Removed 'checked' --}}
                    {{-- 2. Added 'day-filter' class --}}
                    <input type="checkbox" 
                           name="preferred_days[]" 
                           value="{{ $day }}" 
                           class="day-filter peer sr-only"> 
                    
                    <div class="text-center py-2 rounded-xl border-2 border-slate-100 peer-checked:border-indigo-500 peer-checked:bg-indigo-50 text-xs font-bold text-slate-400 peer-checked:text-indigo-700 cursor-pointer transition-all duration-200 group-hover:border-slate-200">
                        {{ $day }}
                    </div>
                </label>
            @endforeach
        </div>
    </div>
</div>

                    <div class="mt-8 pt-6 border-t border-slate-100">
                        <button type="submit" class="w-full bg-indigo-600 text-white py-4 rounded-2xl font-black shadow-xl shadow-indigo-100 hover:bg-indigo-700 active:scale-[0.98] transition-all flex items-center justify-center">
                            <i class="fas fa-wand-magic-sparkles mr-2"></i> GENERATE MATCHES
                        </button>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-8 space-y-8">
                
                {{-- Timetable remains same as previous working version --}}
                <section class="bg-white rounded-3xl shadow-xl border border-slate-200 overflow-hidden">
                    <div class="bg-slate-800 p-5 flex justify-between items-center text-white">
                        <h2 class="text-lg font-bold">Weekly Timetable Preview</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full table-fixed border-collapse">
                            <thead>
                                <tr class="bg-slate-50 border-b border-slate-200">
                                    @foreach(['Mon', 'Tue', 'Wed', 'Thu', 'Fri'] as $day)
                                        <th class="py-4 px-2 text-[10px] font-black uppercase text-slate-400 tracking-widest border-r border-slate-100 last:border-0">{{ $day }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @foreach(['Mon', 'Tue', 'Wed', 'Thu', 'Fri'] as $day)
                                        <td class="border-r border-slate-100 last:border-0 p-3 align-top h-[500px] bg-slate-50/20 day-column" data-day="{{ $day }}">
                                            <div class="empty-state flex items-center justify-center h-full opacity-20">
                                                <span class="text-[10px] font-bold uppercase rotate-90 tracking-widest text-slate-300">Vacant</span>
                                            </div>
                                        </td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>

                <section class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="bg-slate-50 px-6 py-4 border-b border-slate-200 flex justify-between items-center">
                        <h3 class="text-xs font-bold text-slate-500 uppercase tracking-widest">Available for Your Level</h3>
                        <span class="text-xs font-bold text-indigo-600 uppercase tracking-widest" id="selected-count">0 Selected</span>
                    </div>

                    <div class="max-h-[500px] overflow-y-auto">
                        <div class="grid grid-cols-1 md:grid-cols-2 divide-y divide-slate-100">
                            @foreach($available_subjects as $subject)
                                <div class="p-4 hover:bg-slate-50 transition flex items-center justify-between group">
                                    <div class="flex items-center space-x-4">
                                        <input type="checkbox" name="subjects[]" value="{{ $subject->id }}" 
                                               class="subject-checkbox w-6 h-6 rounded-lg border-slate-300 text-indigo-600 focus:ring-indigo-500 transition">
                                        <div>
                                            <h4 class="font-bold text-slate-800 text-sm leading-tight">{{ $subject->name }}</h4>
                                            <div class="flex items-center space-x-2 mt-1">
                                                <span class="text-[9px] text-slate-400 font-black uppercase">{{ $subject->code }}</span>
                                                <span class="text-[9px] bg-slate-100 text-slate-500 px-1 rounded font-bold">{{ $subject->units }} Units</span>
                                                
                                                {{-- Bypass Subject Badge --}}
                                                @if($subject->requirement_type === 'none' && $subject->year_level != auth()->user()->year_level)
                                                    <span class="text-[8px] bg-green-100 text-green-600 px-1 rounded font-bold uppercase">Bypass</span>
                                                @endif

                                                {{-- Prerequisite Badge --}}
                                                @if($subject->requirement_id)
                                                    <span class="text-[8px] bg-amber-100 text-amber-600 px-1 rounded font-bold uppercase" title="Requires Subject ID: {{ $subject->requirement_id }}">
                                                        {{ $subject->requirement_type === 'pre' ? 'Pre-req' : 'Co-req' }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <label class="flex items-center cursor-pointer p-1 rounded-xl">
                                        <input type="checkbox" name="priority[]" value="{{ $subject->id }}" class="sr-only peer">
                                        <div class="w-8 h-5 bg-slate-200 rounded-full relative peer-checked:bg-rose-500 transition shadow-inner">
                                            <div class="absolute top-0.5 left-0.5 w-4 h-4 bg-white rounded-full transition transform peer-checked:translate-x-3 shadow-sm"></div>
                                        </div>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </form>
</div>

<script>
function updateSelectedSchedules(scheduleId) {
    const container = document.getElementById('selected-schedules-container');
    
    // 1. Check if this ID is already in the container to prevent duplicates
    if (document.getElementById('sched-' + scheduleId)) {
        return; // Already exists, do nothing
    }

    // 2. Create the hidden input
    let input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'schedule_ids[]';
    input.value = scheduleId;
    input.id = 'sched-' + scheduleId;
    
    container.appendChild(input);
}

// YOU ALSO NEED THIS: A way to remove the ID if they unselect it
function removeSelectedSchedule(scheduleId) {
    const input = document.getElementById('sched-' + scheduleId);
    if (input) {
        input.remove();
    }
}



document.addEventListener('DOMContentLoaded', function() {
    // Add this inside your document.addEventListener('DOMContentLoaded'...) block
document.querySelectorAll('.day-filter').forEach(dayBox => {
    dayBox.addEventListener('change', updateLivePreview);
});
    const sectionLoader = document.getElementById('sectionLoader');
    const checkboxes = document.querySelectorAll('.subject-checkbox');
    const selectedCountDisplay = document.getElementById('selected-count');
    
    // Safety check for the JSON data
    const subjectSchedules = JSON.parse('{!! addslashes(json_encode($available_subjects->keyBy("id"))) !!}');

    sectionLoader.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if(!selectedOption.value) return;
        const subjectIds = JSON.parse(selectedOption.getAttribute('data-subjects') || '[]');
        checkboxes.forEach(cb => cb.checked = false);
        subjectIds.forEach(id => {
            const checkbox = document.querySelector(`.subject-checkbox[value="${id}"]`);
            if (checkbox) checkbox.checked = true;
        });
        updateLivePreview();
    });

    checkboxes.forEach(box => {
        box.addEventListener('change', updateLivePreview);
    });

function updateLivePreview() {
    const selectedSectionId = sectionLoader.value;
    
    // --- ADD THIS BLOCK: Clear the hidden inputs before recalculating ---
    const container = document.getElementById('selected-schedules-container');
    if (container) container.innerHTML = ''; 
    // --------------------------------------------------------------------

    const activeDays = Array.from(document.querySelectorAll('.day-filter:checked'))
                            .map(cb => cb.value);

    // Reset columns
    document.querySelectorAll('.day-column').forEach(col => {
        col.innerHTML = `<div class="empty-state flex items-center justify-center h-full opacity-20"><span class="text-[10px] font-bold uppercase rotate-90 tracking-widest text-slate-300">Vacant</span></div>`;
    });
    
    let count = 0;
    checkboxes.forEach(box => {
        if (box.checked) {
            const subject = subjectSchedules[box.value];
            
            if (subject && subject.schedules) {
                const schedules = Array.isArray(subject.schedules) ? subject.schedules : Object.values(subject.schedules);
                
                let appearsInSelectedDays = false;

                schedules.forEach(sch => {
                    if (selectedSectionId && sch.section_id != selectedSectionId) {
                        return;
                    }

                    const isPreferredDay = activeDays.some(day => sch.day.includes(day));

                    if (isPreferredDay) {
                        // --- ADD THIS LINE: Pass the ID to your hidden input function ---
                        updateSelectedSchedules(sch.id); 
                        // ----------------------------------------------------------------

                        appearsInSelectedDays = true;
                        let dayKey = sch.day.substring(0, 3);
                        const col = document.querySelector(`.day-column[data-day="${dayKey}"]`);
                        
                        if (col) {
                            const empty = col.querySelector('.empty-state');
                            if (empty) empty.remove();

                            const card = document.createElement('div');
                            card.className = "bg-white border-l-4 border-indigo-600 p-3 rounded-r-lg shadow-md mb-3 border-y border-r border-slate-100 transition-all hover:shadow-lg animate-in fade-in slide-in-from-left-2";
                            card.innerHTML = `
                                <div class="text-[11px] font-black text-slate-800 leading-tight">${subject.name}</div>
                                <div class="text-[9px] text-indigo-500 font-bold mt-1 uppercase">
                                    ${formatTime(sch.start_time)} - ${formatTime(sch.end_time)}
                                </div>
                            `;
                            col.appendChild(card);
                        }
                    }
                });

                if (appearsInSelectedDays) {
                    count++;
                }
            }
        }
    });
    selectedCountDisplay.innerText = `${count} Selected`;
}

// function updateLivePreview() {
//     const selectedSectionId = sectionLoader.value;
    
//     // 1. Get the currently "Blue" (Active) days
//     const activeDays = Array.from(document.querySelectorAll('.day-filter:checked'))
//                             .map(cb => cb.value);

//     // Reset columns
//     document.querySelectorAll('.day-column').forEach(col => {
//         col.innerHTML = `<div class="empty-state flex items-center justify-center h-full opacity-20"><span class="text-[10px] font-bold uppercase rotate-90 tracking-widest text-slate-300">Vacant</span></div>`;
//     });
    
//     let count = 0;
//     checkboxes.forEach(box => {
//         if (box.checked) {
//             const subject = subjectSchedules[box.value];
            
//             if (subject && subject.schedules) {
//                 const schedules = Array.isArray(subject.schedules) ? subject.schedules : Object.values(subject.schedules);
                
//                 // Track if this subject actually appears on any of the selected days
//                 let appearsInSelectedDays = false;

//                 schedules.forEach(sch => {
//                     // Filter 1: Match the Section
//                     if (selectedSectionId && sch.section_id != selectedSectionId) {
//                         return;
//                     }

//                     // Filter 2: Match the Preferred Days
//                     // We check if the schedule's day (e.g., "Monday") matches any activeDays (e.g., "Mon")
//                     const isPreferredDay = activeDays.some(day => sch.day.includes(day));

//                     if (isPreferredDay) {
//                         appearsInSelectedDays = true;
//                         let dayKey = sch.day.substring(0, 3);
//                         const col = document.querySelector(`.day-column[data-day="${dayKey}"]`);
                        
//                         if (col) {
//                             const empty = col.querySelector('.empty-state');
//                             if (empty) empty.remove();

//                             const card = document.createElement('div');
//                             card.className = "bg-white border-l-4 border-indigo-600 p-3 rounded-r-lg shadow-md mb-3 border-y border-r border-slate-100 transition-all hover:shadow-lg animate-in fade-in slide-in-from-left-2";
//                             card.innerHTML = `
//                                 <div class="text-[11px] font-black text-slate-800 leading-tight">${subject.name}</div>
//                                 <div class="text-[9px] text-indigo-500 font-bold mt-1 uppercase">
//                                     ${formatTime(sch.start_time)} - ${formatTime(sch.end_time)}
//                                 </div>
//                             `;
//                             col.appendChild(card);
//                         }
//                     }
//                 });

//                 // Increment count only if the subject has a valid slot on selected days
//                 if (appearsInSelectedDays) {
//                     count++;
//                 }
//             }
//         }
//     });
//     selectedCountDisplay.innerText = `${count} Selected`;
// }




    function formatTime(timeStr) {
        if (!timeStr) return '';
        const [hour, minute] = timeStr.split(':');
        const h = parseInt(hour);
        const ampm = h >= 12 ? 'PM' : 'AM';
        const formattedH = h % 12 || 12;
        return `${formattedH}:${minute} ${ampm}`;
    }
});
</script>
@endsection