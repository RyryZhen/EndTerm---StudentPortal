@extends('layouts.admin')

@section('content')
<div class="p-6 md:p-10">
    <h1 class="text-4xl font-black text-slate-800 tracking-tight">Edit Department</h1>
    
    <div class="mt-8 bg-white rounded-[2.5rem] border border-slate-100 p-8 md:p-12 shadow-sm max-w-4xl">
        {{-- IMPORTANT: method is POST but we add @method('PUT') for Laravel updates --}}
        <form action="{{ route('admin.departments.update', $department->id) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-black uppercase text-slate-400 mb-3 tracking-widest">Department Name</label>
                <input type="text" name="name" value="{{ $department->name }}" class="w-full bg-slate-50 border-none rounded-2xl p-4 focus:ring-2 focus:ring-indigo-500 font-bold text-slate-700">
            </div>

            <div>
                <label class="block text-xs font-black uppercase text-slate-400 mb-3 tracking-widest">Department Code</label>
                <input type="text" name="code" value="{{ $department->code }}" class="w-full bg-slate-50 border-none rounded-2xl p-4 focus:ring-2 focus:ring-indigo-500 font-black text-slate-700 uppercase">
            </div>

            <div class="pt-6 flex items-center justify-end space-x-4 border-t border-slate-50">
                <a href="{{ route('admin.departments.index') }}" class="text-sm font-black text-slate-400 uppercase tracking-widest">Cancel</a>
                <button type="submit" class="bg-indigo-600 text-white px-10 py-4 rounded-2xl font-black shadow-xl hover:bg-indigo-700 transition transform hover:-translate-y-1">
                    Update Department
                </button>
            </div>
        </form>
    </div>
</div>
@endsection