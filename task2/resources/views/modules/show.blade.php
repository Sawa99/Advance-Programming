<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $module->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Module Details --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Module Details</h3>
                    <p><span class="font-medium">Level:</span> {{ $module->level }}</p>
                    <p><span class="font-medium">Credits:</span> {{ $module->credits }}</p>
                    <p><span class="font-medium">Status:</span>
                        {{ $module->is_completed ? 'Completed' : 'In Progress' }}
                    </p>
                </div>
            </div>

            {{-- Assignments --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between">
                    <h3 class="text-lg font-semibold mb-4">Assignments</h3>
                    <a href="{{ route('assignments.create', ['module' => $module]) }}"
                       class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">
                        Add Assignment
                    </a>
                    </div>

                    @if($module->assignments->isEmpty())
                        <p class="text-gray-500 dark:text-gray-400">No assignments for this module.</p>
                    @else
                        <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($module->assignments as $assignment)
                                @php $mark = $assignment->marks->firstWhere('user_id', auth()->id()); @endphp
                                <li class="py-3 flex items-center justify-between">
                                    <a href="{{ route('assignments.show', $assignment) }}"
                                       class="text-indigo-600 dark:text-indigo-400 hover:underline font-medium">
                                        {{ $assignment->name }}
                                    </a>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">
                                        @if($mark)
                                            {{ $mark->mark }} / {{ $assignment->total_marks }}
                                        @else
                                            Ungraded
                                        @endif
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
