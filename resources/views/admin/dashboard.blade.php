@extends('layouts.admin')

@section('title', 'Dashboard')
@section('header', 'Welcome, Admin')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <a href="#" class="p-6 bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition">
            <h3 class="text-gray-500 font-semibold uppercase text-xs">Students</h3>
            <h2 class="text-3xl font-bold text-indigo-600">{{ $students }}</h2>
            <p class="text-sm text-blue-500 mt-2">View all →</p>
        </a>

        <a href="#" class="p-6 bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition">
            <h3 class="text-gray-500 font-semibold uppercase text-xs">Instructors</h3>
            <h2 class="text-3xl font-bold text-green-600">{{ $instructors }}</h2>
            <p class="text-sm text-green-500 mt-2">View all →</p>
        </a>

        <a href="{{ route('admin.schedules.index') }}" class="p-6 bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition">
            <h3 class="text-gray-500 font-semibold uppercase text-xs">Schedules</h3>
            <h2 class="text-3xl font-bold text-orange-600">{{ $schedules }}</h2>
            <p class="text-sm text-orange-500 mt-2">Manage Slots →</p>
        </a>

        <a href="#" class="p-6 bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition">
            <h3 class="text-gray-500 font-semibold uppercase text-xs">Enrollments</h3>
            <h2 class="text-3xl font-bold text-purple-600">{{ $enrollments }}</h2>
            <p class="text-sm text-purple-500 mt-2">Reports →</p>
        </a>
    </div>

    <div class="mt-10">
        <h2 class="text-xl font-bold text-gray-700 mb-4">Quick Actions</h2>
        <div class="flex gap-4">
            <a href="{{ route('admin.subjects.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                + Add New Subject
            </a>
            <a href="{{ route('admin.schedules.index') }}" class="bg-white border border-indigo-600 text-indigo-600 px-4 py-2 rounded-lg hover:bg-indigo-50">
                Set New Schedule
            </a>
        </div>
    </div>
@endsection