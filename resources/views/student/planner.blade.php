@extends('layouts.student')

@section('title', 'Smart Scheduler')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-black text-slate-800">Smart Scheduler</h1>
        <p class="text-slate-500">Step 1: Select your subjects and pin your priorities.</p>
    </div>

    <form action="{{ route('student.generate-schedule') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <div class="lg:col-span-4 space-y-6">
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200 sticky top-4">
                    <h3 class="font-bold text-slate-800 mb-4 flex items-center">
                        <i class="fas fa-filter text-indigo-500 mr-2"></i> Scheduling Rules
                    </h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-black uppercase text-slate-400 mb-2 tracking-widest">Preferred School Days</label>
                            <div class="grid grid-cols-3 gap-2">
                                @foreach(['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
                                    <label class="relative">
                                        <input type="checkbox" name="preferred_days[]" value="{{ $day }}" class="peer sr-only" checked>
                                        <div class="text-center py-2 rounded-xl border-2 border-slate-100 peer-checked:border-indigo-500 peer-checked:bg-indigo-50 text-xs font-bold text-slate-400 peer-checked:text-indigo-700 cursor-pointer transition">
                                            {{ $day }}
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-black uppercase text-slate-400 mb-2 tracking-widest">Available Hours</label>
                            <div class="flex items-center space-x-2">
                                <input type="time" name="start_limit" value="07:30" class="w-full border-slate-200 rounded-xl text-sm">
                                <span class="text-slate-300">-</span>
                                <input type="time" name="end_limit" value="18:00" class="w-full border-slate-200 rounded-xl text-sm">
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-slate-100">
                        <button type="submit" class="w-full bg-indigo-600 text-white py-4 rounded-2xl font-black shadow-xl shadow-indigo-200 hover:bg-indigo-700 transition flex items-center justify-center">
                            <i class="fas fa-wand-magic-sparkles mr-2"></i> GENERATE MATCHES
                        </button>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-8">
                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="bg-slate-50 px-6 py-4 border-b border-slate-200 flex justify-between">
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-widest">Available Subjects</span>
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-widest">Set Priority</span>
                    </div>

                    <div class="divide-y divide-slate-100">
                        @foreach($available_subjects as $subject)
                            <div class="p-6 hover:bg-slate-50/50 transition flex items-center justify-between group">
                                <div class="flex items-center space-x-4">
                                    <input type="checkbox" name="subjects[]" value="{{ $subject->id }}" class="w-6 h-6 rounded-lg border-slate-300 text-indigo-600 focus:ring-indigo-500">
                                    <div>
                                        <h4 class="font-bold text-slate-800">{{ $subject->name }}</h4>
                                        <p class="text-xs text-slate-400">{{ $subject->code }} • {{ $subject->units ?? 3 }} Units</p>
                                    </div>
                                </div>

                                <label class="flex items-center cursor-pointer group-hover:bg-white p-2 rounded-xl border border-transparent group-hover:border-slate-200 transition">
                                    <input type="checkbox" name="priority[]" value="{{ $subject->id }}" class="sr-only peer">
                                    <span class="text-[10px] font-black mr-3 text-slate-300 peer-checked:text-rose-500 uppercase tracking-tighter">Priority Subject</span>
                                    <div class="w-10 h-6 bg-slate-200 rounded-full relative peer-checked:bg-rose-500 transition shadow-inner">
                                        <div class="absolute top-1 left-1 w-4 h-4 bg-white rounded-full transition transform peer-checked:translate-x-4 shadow-sm"></div>
                                    </div>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection