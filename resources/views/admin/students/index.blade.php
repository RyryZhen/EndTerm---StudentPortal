@extends('layouts.admin')

@section('content')
<div class="flex flex-col md:flex-row">
    <div class="main-content flex-1 bg-gray-100 mt-12 md:mt-2 pb-24 md:pb-5">

        <div class="bg-gray-800 pt-3">
            <div class="rounded-tl-3xl bg-gradient-to-r from-indigo-900 to-gray-800 p-4 shadow text-2xl text-white font-bold">
                <h1 class="font-bold pl-2">Manage Students</h1>
            </div>
        </div>

        <div class="p-6">
            @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 shadow-md" role="alert">
                <p class="font-bold">Success!</p>
                <p>{{ session('success') }}</p>
            </div>
            @endif

<div class="bg-white rounded-xl shadow-lg p-6 mb-8 border-t-4 border-pink-500">
    <h2 class="text-xl font-semibold mb-4 text-gray-800 flex items-center">
        <i class="fas fa-magic mr-3 text-indigo-900"></i> Auto-Register Student
    </h2>
    
<form action="{{ route('admin.students.store') }}" method="POST" class="space-y-4">
    @csrf
    <div>
        <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest block mb-1">Full Name</label>
        <input type="text" name="name" required class="w-full border-slate-200 rounded-xl focus:ring-indigo-500">
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest block mb-1">Year Level</label>
            <select name="year_level" class="w-full border-slate-200 rounded-xl text-sm">
                <option value="1">1st Year</option>
                <option value="2">2nd Year</option>
                <option value="3">3rd Year</option>
                <option value="4">4th Year</option>
            </select>
        </div>

        <div>
            <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest block mb-1">Max Units</label>
            <input type="number" name="max_units" value="23" min="1" max="30" class="w-full border-slate-200 rounded-xl text-sm">
        </div>
    </div>

    <div>
        <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest block mb-1">Status</label>
        <div class="flex space-x-2">
            @foreach(['Regular', 'Irregular', 'Returnee'] as $status)
                <label class="flex-1">
                    <input type="radio" name="status" value="{{ $status }}" class="peer sr-only" {{ $loop->first ? 'checked' : '' }}>
                    <div class="text-center py-2 border-2 border-slate-100 rounded-xl text-xs font-bold text-slate-400 peer-checked:border-indigo-500 peer-checked:bg-indigo-50 peer-checked:text-indigo-700 cursor-pointer transition">
                        {{ $status }}
                    </div>
                </label>
            @endforeach
        </div>
    </div>

    <button type="submit" class="w-full bg-slate-800 text-white py-3 rounded-xl font-bold mt-4 hover:bg-slate-900 transition">
        Create Student Account
    </button>
</form>
</div>

            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800">Department Roster</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="text-indigo-900 uppercase text-sm leading-normal">
                                <th class="py-4 px-6 font-bold">ID Number</th>
                                <th class="py-4 px-6 font-bold">Student Name</th>
                                <th class="py-4 px-6 font-bold">Portal Email</th>
                                <th class="py-4 px-6 font-bold text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @forelse($students as $student)
                            <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors">
                                <td class="py-4 px-6 font-medium text-gray-900">{{ $student->student_id_number }}</td>
                                <td class="py-4 px-6 font-semibold">{{ $student->name }}</td>
                                <td class="py-4 px-6">
                                    <span class="text-blue-600 hover:underline"><i class="far fa-envelope mr-2"></i>{{ $student->email }}</span>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <span class="bg-green-100 text-green-700 py-1 px-3 rounded-full text-xs font-bold uppercase">Enrolled</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="py-10 text-center text-gray-400 italic">No students found in this department.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection