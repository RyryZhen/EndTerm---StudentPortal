<nav aria-label="alternative nav" class="bg-indigo-900 shadow-xl h-20 fixed bottom-0 mt-12 md:relative md:h-screen z-10 w-full md:w-64 content-center">
    <div class="md:mt-12 md:w-64 md:fixed md:left-0 md:top-0 content-center md:content-start text-left justify-between">
        <ul class="list-reset flex flex-row md:flex-col pt-3 md:py-3 px-1 md:px-2 text-center md:text-left">
            <li class="mr-3 flex-1">
                <a href="{{ route('admin.dashboard') }}" class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 border-indigo-900 hover:border-pink-500">
                    <i class="fas fa-chart-area pr-0 md:pr-3"></i><span class="pb-1 md:pb-0 text-xs md:text-base text-gray-400 md:text-gray-200 block md:inline-block">Dashboard</span>
                </a>
            </li>
            <li class="mr-3 flex-1">
                <a href="{{ route('admin.subjects.index') }}" class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 border-indigo-900 hover:border-purple-500">
                    <i class="fa fa-book pr-0 md:pr-3"></i><span class="pb-1 md:pb-0 text-xs md:text-base text-gray-400 md:text-gray-200 block md:inline-block">Subjects</span>
                </a>
            </li>
            <li class="mr-3 flex-1">
                <a href="{{ route('admin.schedules.index') }}" class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 border-indigo-900 hover:border-blue-500">
                    <i class="fa fa-calendar-alt pr-0 md:pr-3"></i><span class="pb-1 md:pb-0 text-xs md:text-base text-gray-400 md:text-gray-200 block md:inline-block">Schedules</span>
                </a>
            </li>
            <li class="mr-3 flex-1">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 border-indigo-900 hover:border-red-500">
                        <i class="fa fa-sign-out-alt pr-0 md:pr-3"></i><span class="pb-1 md:pb-0 text-xs md:text-base text-gray-400 md:text-gray-200 block md:inline-block">Logout</span>
                    </button>
                </form>
            </li>
        </ul>
    </div>
</nav>