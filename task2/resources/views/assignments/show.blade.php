<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $assignment->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Assignment Details --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Assignment Details</h3>
                    <p><span class="font-medium">Module:</span>
                        <a href="{{ route('modules.show', $assignment->module) }}"
                           class="text-indigo-600 dark:text-indigo-400 hover:underline">
                            {{ $assignment->module->name }}
                        </a>
                    </p>
                    <p><span class="font-medium">Weight:</span> {{ $assignment->weight }}%</p>
                    <p><span class="font-medium">Total Marks:</span> {{ $assignment->total_marks }}</p>
                </div>
            </div>

            {{-- Mark --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between">
                    <h3 class="text-lg font-semibold mb-4">Your Mark</h3>
                        <a href="{{ route('marks.create', $assignment) }}">
                            Add Mark
                        </a>
                    </div>

                    @if($mark)
                        <p class="text-2xl font-bold mb-4">
                            {{ $mark->mark }} / {{ $assignment->total_marks }}
                        </p>
                        <a href="{{ route('marks.edit', $mark) }}"
                           class="inline-block px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">
                            Edit Mark
                        </a>
                    @else
                        <p class="text-gray-500 dark:text-gray-400 mb-4">No mark recorded yet.</p>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
