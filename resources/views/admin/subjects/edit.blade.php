@extends('layouts.admin')

@section('title', 'Edit Subject')
@section('header', 'Edit: ' . $subject->code)

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6 text-sm">
        <a href="{{ route('admin.subjects.index') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
            <i class="fas fa-arrow-left mr-1"></i> Back to Curriculum
        </a>
    </div>

    <div class="bg-white shadow-lg rounded-xl border border-gray-200 overflow-hidden">
        <div class="p-8">
            <form method="POST" action="{{ route('admin.subjects.update', $subject->id) }}" class="space-y-6">
                @csrf
                @method('PUT') <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Subject Code</label>
                        <input type="text" name="code" value="{{ $subject->code }}" required
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-3 border">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Subject Name</label>
                        <input type="text" name="name" value="{{ $subject->name }}" required
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-3 border">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Units</label>
                    <input type="number" step="0.01" name="units" value="{{ $subject->units }}" required
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-3 border">
                </div>

                <div class="bg-amber-50 p-6 rounded-xl border border-amber-100">
                    <h2 class="text-xs font-bold text-amber-600 uppercase tracking-wider mb-4">
                        <i class="fas fa-link mr-1"></i> Update Requirements
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Dependent On</label>
                            <select name="requirement_id" class="w-full border-gray-300 rounded-lg shadow-sm p-3 border bg-white">
                                <option value="">None (No Pre-requisite)</option>
                                @foreach($subjects as $item)
                                    @if($item->id !== $subject->id) {{-- Don't show self --}}
                                        <option value="{{ $item->id }}" {{ $subject->requirement_id == $item->id ? 'selected' : '' }}>
                                            {{ $item->code }} - {{ $item->name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Requirement Type</label>
                            <select name="requirement_type" class="w-full border-gray-300 rounded-lg shadow-sm p-3 border bg-white">
                                <option value="none" {{ $subject->requirement_type == 'none' ? 'selected' : '' }}>None</option>
                                <option value="pre" {{ $subject->requirement_type == 'pre' ? 'selected' : '' }}>Pre-requisite</option>
                                <option value="co" {{ $subject->requirement_type == 'co' ? 'selected' : '' }}>Co-requisite</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-100">
                    <a href="{{ route('admin.subjects.index') }}" class="text-gray-500 hover:text-gray-700 font-medium">Cancel Changes</a>
                    <button type="submit" 
                        class="bg-indigo-600 text-white px-8 py-3 rounded-lg hover:bg-indigo-700 transition duration-200 shadow-lg font-bold">
                        Update Subject
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection