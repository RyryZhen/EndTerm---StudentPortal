@extends('layouts.student')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-2xl font-bold text-slate-800">Generated Schedule</h2>
        <a href="{{ route('student.planner') }}" class="text-indigo-600 font-bold text-sm">← Re-adjust Preferences</a>
    </div>

    @if(!$result['is_perfect'])
        <div class="bg-amber-50 border-l-4 border-amber-400 p-4 mb-6">
            <p class="text-amber-700 font-bold">Optimization Notes:</p>
            <ul class="list-disc ml-5 text-sm text-amber-600">
                @foreach($result['warnings'] as $warning)
                    <li>{{ $warning }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-100">
        <table class="w-full border-collapse">
            <thead class="bg-slate-50">
                <tr>
                    <th class="p-4 text-left text-xs font-bold text-slate-500">Subject</th>
                    <th class="p-4 text-left text-xs font-bold text-slate-500">Day & Time</th>
                    <th class="p-4 text-left text-xs font-bold text-slate-500">Instructor</th>
                </tr>
            </thead>
            <tbody>
                @foreach($result['schedule'] as $item)
                <tr class="border-t border-slate-50 hover:bg-slate-50/50">
                    <td class="p-4">
                        <p class="font-bold text-slate-800">{{ $item->subject->name }}</p>
                        @if(in_array($item->subject_id, request('priority', [])))
                            <span class="text-[10px] bg-rose-100 text-rose-600 px-2 py-0.5 rounded-full font-bold">PRIORITY</span>
                        @endif
                    </td>
                    <td class="p-4">
                        <span class="text-sm text-slate-600">{{ $item->day }}</span>
                        <p class="text-xs font-mono text-indigo-500">{{ $item->start_time }} - {{ $item->end_time }}</p>
                    </td>
                    <td class="p-4 text-sm text-slate-500">{{ $item->instructor->name }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="p-6 bg-slate-50 border-t flex justify-end">
            <form action="{{ route('student.enroll.bulk') }}" method="POST">
                @csrf
                @foreach($result['schedule'] as $item)
                    <input type="hidden" name="schedule_ids[]" value="{{ $item->id }}">
                @endforeach
                <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-xl font-bold shadow-lg hover:bg-indigo-700 transition">
                    Confirm & Enroll All
                </button>
            </form>
        </div>
    </div>
</div>
@endsection