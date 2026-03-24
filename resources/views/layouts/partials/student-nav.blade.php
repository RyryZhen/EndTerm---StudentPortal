<nav class="bg-white border-b border-slate-200 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <div class="flex-shrink-0 flex items-center">
                    <span class="text-2xl mr-2 text-indigo-600"><i class="fas fa-graduation-cap"></i></span>
                    <span class="font-black text-slate-800 text-xl tracking-tighter uppercase">Auto<span class="text-indigo-600">Sched</span></span>
                </div>
                
                <div class="hidden sm:ml-8 sm:flex sm:space-x-8">
                    <a href="{{ route('student.dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('student.dashboard') ? 'border-indigo-500 text-slate-900' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' }} text-sm font-medium">
                        Dashboard
                    </a>
                    <a href="#" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300 text-sm font-medium">
                        My Grades
                    </a>
                    <a href="#" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300 text-sm font-medium">
                        Curriculum
                    </a>
                </div>
            </div>

            <div class="flex items-center space-x-4">
                <div class="text-right hidden sm:block">
                    <div class="text-sm font-bold text-slate-800">{{ Auth::user()->name }}</div>
                    <div class="text-[10px] text-slate-400 uppercase font-bold">Student ID: #{{ Auth::id() + 1000 }}</div>
                </div>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-slate-100 p-2 rounded-full text-slate-500 hover:bg-rose-50 hover:text-rose-600 transition">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>