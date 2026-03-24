@extends('layouts.admin')

@section('title', 'Create Subject')
@section('header', 'Create New Subject')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.subjects.index') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
            <i class="fas fa-arrow-left mr-1"></i> Back to List
        </a>
    </div>

    <div class="bg-white shadow-lg rounded-xl border border-gray-200 overflow-hidden">
        <div class="p-8">
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700">
                    <ul class="list-disc ml-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.subjects.store') }}" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Subject Code</label>
                        <input type="text" name="code" value="{{ old('code') }}" placeholder="e.g. URD_CC101_IT" required
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-3 border">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Subject Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="e.g. Intro to Computing" required
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-3 border">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 bg-gray-50 p-6 rounded-xl border border-gray-100">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Units</label>
                        <input type="number" step="0.01" name="units" value="{{ old('units') }}" placeholder="3.00" required
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-3 border">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Year Level</label>
                        <select name="year_level" required class="w-full border-gray-300 rounded-lg shadow-sm p-3 border bg-white">
                            <option value="1" {{ old('year_level') == 1 ? 'selected' : '' }}>1st Year</option>
                            <option value="2" {{ old('year_level') == 2 ? 'selected' : '' }}>2nd Year</option>
                            <option value="3" {{ old('year_level') == 3 ? 'selected' : '' }}>3rd Year</option>
                            <option value="4" {{ old('year_level') == 4 ? 'selected' : '' }}>4th Year</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Semester</label>
                        <select name="semester" required class="w-full border-gray-300 rounded-lg shadow-sm p-3 border bg-white">
                            <option value="1" {{ old('semester') == 1 ? 'selected' : '' }}>1st Semester</option>
                            <option value="2" {{ old('semester') == 2 ? 'selected' : '' }}>2nd Semester</option>
                        </select>
                    </div>
                </div>

                <div class="bg-indigo-50 p-6 rounded-xl border border-indigo-100">
                    <h2 class="text-xs font-bold text-indigo-600 uppercase tracking-wider mb-4">
                        <i class="fas fa-link mr-1"></i> Academic Requirements
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Dependent On</label>
                            <select name="requirement_id" class="w-full border-gray-300 rounded-lg shadow-sm p-3 border bg-white">
                                <option value="">None (No Pre-requisite)</option>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}" {{ old('requirement_id') == $subject->id ? 'selected' : '' }}>
                                        {{ $subject->code }} - {{ $subject->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Requirement Type</label>
                            <select name="requirement_type" class="w-full border-gray-300 rounded-lg shadow-sm p-3 border bg-white">
                                <option value="none" {{ old('requirement_type') == 'none' ? 'selected' : '' }}>None</option>
                                <option value="pre" {{ old('requirement_type') == 'pre' ? 'selected' : '' }}>Pre-requisite (Must pass first)</option>
                                <option value="co" {{ old('requirement_type') == 'co' ? 'selected' : '' }}>Co-requisite (Can take together)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-100">
                    <a href="{{ route('admin.subjects.index') }}" class="text-gray-500 hover:text-gray-700 font-medium">Cancel</a>
                    <button type="submit" 
                        class="bg-indigo-600 text-white px-8 py-3 rounded-lg hover:bg-indigo-700 transition duration-200 shadow-lg font-bold">
                        Save Subject
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection