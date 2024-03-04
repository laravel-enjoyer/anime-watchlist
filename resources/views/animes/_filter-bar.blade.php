<div x-data="{ sidebarOpen: true }" class="fixed top-35 w-64 ml-2">
    <!-- Button to toggle sidebar -->
    <button @click="sidebarOpen = !sidebarOpen" class="bg-gray-700 text-white px-4 py-2 rounded-lg mb-1">Filters
    </button>
    <!-- Sidebar -->
    <div id="sidebar" x-show="sidebarOpen"
         class="block w-64 p-4 dark:bg-gray-800 border dark:border-gray-700 rounded-xl text-white">
        <!-- Filter options -->
        <div class="">
            <form action="{{ route('animes') }}" method="GET">
                <!-- Status filter -->
                <div class="flex items-center justify-center mb-2">
                    <div class="z-10 w-56 p-3 bg-white rounded-lg shadow dark:bg-gray-700">
                        <h6 class="mb-3 text-md font-bold dark:text-white">
                            Status
                        </h6>
                        <ul class="space-y-2 text-sm" aria-labelledby="dropdownDefault">
                            @foreach ($filters['statuses'] as $status)
                                <li class="flex items-center">
                                    <input id="status_{{ $status }}" type="checkbox" name="status" value=""
                                           class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500"/>

                                    <label for="status_{{ $status }}"
                                           class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ App\Models\Anime::getStatusDisplayName($status) }}
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Type filter -->
                <div class="flex items-center justify-center mb-2">
                    <div class="z-10 w-56 p-3 bg-white rounded-lg shadow dark:bg-gray-700">
                        <h6 class="mb-3 text-md font-bold dark:text-white">
                            Type
                        </h6>
                        <ul class="space-y-2 text-sm" aria-labelledby="dropdownDefault">
                            @foreach ($filters['types'] as $type)
                                <li class="flex items-center">
                                    <input id="type_{{ $type }}" type="checkbox" name="type" value=""
                                           class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500"/>

                                    <label for="type_{{ $type }}"
                                           class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $type }}
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>


                <!-- Sorting filter -->
                <div class="flex items-center justify-center mb-2">
                    <div class="z-10 w-56 p-3 bg-white rounded-lg shadow dark:bg-gray-700">
                        <h6 class="mb-3 text-md font-bold dark:text-white">
                            Sorting
                        </h6>
                        <ul class="space-y-2 text-sm" aria-labelledby="dropdownDefault">
                            @foreach ($filters['sorting'] as $option)
                                <div class="flex items-center mb-4">
                                    <input id="sorting-{{ $option }}" type="radio" value="" name="sorting"
                                           class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="sorting-{{ $option }}"
                                           class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">By {{ $option }}</label>
                                </div>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Year filter -->
                <div class="flex items-center justify-center mb-2">
                    <div class="z-10 w-56 p-3 bg-white rounded-lg shadow dark:bg-gray-700">
                        <h6 class="mb-3 text-md font-bold dark:text-white">
                            Year
                        </h6>

                        <select id="filter-year-select"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="">...</option>
                            @foreach ($filters['years'] as $option)
                                <option value="{{ $option }}">{{ $option }}</option>
                            @endforeach
                        </select>


                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
