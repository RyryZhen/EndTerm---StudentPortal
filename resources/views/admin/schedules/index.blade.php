@extends('layouts.admin')

@section('content')
<div class="space-y-10">
    
    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 flex justify-between items-center">
        <form method="GET" action="{{ route('admin.schedules.index') }}" class="flex items-center gap-3">
            <label class="text-xs font-bold text-gray-500 uppercase">Filter Section:</label>
         <select name="section" onchange="this.form.submit()" class="rounded-lg border-gray-300 font-bold text-indigo-600">
    <option value="">-- Show All Sections --</option>
    @foreach($sections as $sec)
        <option value="{{ $sec }}" {{ $selectedSection == $sec ? 'selected' : '' }}>
            Section {{ $sec }}
        </option>
    @endforeach
</select>
            @if($selectedSection)
                <a href="{{ route('admin.schedules.index') }}" class="text-xs text-rose-500 hover:underline">Reset</a>
            @endif
        </form>
        <a href="{{ route('admin.schedules.create') }}" class="bg-indigo-600 text-white px-5 py-2 rounded-lg font-bold shadow-md hover:bg-indigo-700 transition">
            <i class="fas fa-plus mr-2"></i>New Slot
        </a>
    </div>

    <div class="space-y-12">
        @forelse($schedules as $sectionName => $days)
            {{-- 
               This IF statement is the fix: 
               If the user selected a section, we only show the matching section name.
               If no section is selected, we show all of them.
            --}}
            @if(!$selectedSection || $selectedSection == $sectionName)
                <div class="animate-fadeIn">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="bg-indigo-600 text-white px-4 py-1 rounded-full text-sm font-black tracking-widest uppercase">
                            Section {{ $sectionName }}
                        </div>
                        <div class="h-px flex-1 bg-gray-200"></div>
                        <span class="text-xs text-gray-400 font-medium italic">Weekly Timetable</span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'] as $dayName)
                            @if(isset($days[$dayName]))
                                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col hover:shadow-md transition">
                                    <div class="bg-gray-50 px-4 py-3 border-b flex justify-between items-center">
                                        <span class="text-[11px] font-black uppercase text-gray-400 tracking-widest">{{ $dayName }}</span>
                                        <span class="bg-white border border-gray-200 text-[10px] px-2 py-0.5 rounded-full text-gray-400 font-bold">
                                            {{ count($days[$dayName]) }} Classes
                                        </span>
                                    </div>
                                    
                                    <div class="p-3 space-y-3 flex-1 bg-white">
                                        @foreach($days[$dayName] as $slot)
                                            <div class="p-3 rounded-xl border border-gray-100 bg-gray-50/50 group relative">
                                                <div class="flex justify-between items-start">
                                                    <div class="text-[10px] font-bold text-indigo-600 mb-1">
                                                        <i class="far fa-clock mr-1"></i>
                                                        {{ \Carbon\Carbon::parse($slot->start_time)->format('h:i A') }} - 
                                                        {{ \Carbon\Carbon::parse($slot->end_time)->format('h:i A') }}
                                                    </div>
                                                    
                                                    <form action="{{ route('admin.schedules.destroy', $slot->id) }}" method="POST">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="text-gray-300 hover:text-rose-500 transition" onclick="return confirm('Remove this slot?')">
                                                            <i class="fas fa-times-circle text-xs"></i>
                                                        </button>
                                                    </form>
                                                </div>

                                                <div class="font-bold text-gray-800 text-sm leading-tight group-hover:text-indigo-600 transition">
                                                    {{ $slot->subject->name }}
                                                </div>
                                                
                                                <div class="mt-2 pt-2 border-t border-gray-100 flex items-center justify-between text-[10px]">
                                                    <div class="text-gray-500">
                                                        <i class="fas fa-user-tie mr-1 opacity-50"></i>{{ $slot->instructor->name }}
                                                    </div>
                                                    <div class="font-black text-rose-500 bg-rose-50 px-1.5 py-0.5 rounded">
                                                        {{ $slot->room }}
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif
        @empty
            <div class="bg-white p-20 rounded-3xl border-2 border-dashed border-gray-100 text-center">
                <i class="fas fa-calendar-alt text-6xl text-gray-200 mb-4"></i>
                <p class="text-gray-400 font-medium italic">No schedules have been created yet.</p>
                <a href="{{ route('admin.schedules.create') }}" class="text-indigo-500 text-sm mt-2 inline-block hover:underline font-bold">Create your first slot &rarr;</a>
            </div>
        @endforelse
    </div>
</div>
@endsection