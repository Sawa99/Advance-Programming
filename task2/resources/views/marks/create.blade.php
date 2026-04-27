<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Add Mark
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <p class="mb-4 text-sm text-gray-500 dark:text-gray-400">
                        Mark must be between 0 and {{ $mark->assignment->total_marks }}.
                    </p>
                     <form method="POST" action="{{ route('marks.store', $assignment) }}">
                         @csrf
                         <input type="hidden" name="assignment_id" value="{{ $assignment->id }}">

                        <div class="mb-4">
                            <label for="mark" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Mark
                            </label>
                            <input type="number"
                                   id="mark"
                                   name="mark"
                                   value="{{ old('mark') }}"
                                   min="0"
                                   max="{{ $assignment->total_marks }}"
                                   step="0.01"
                                   class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md"
                                   required>
                            @error('mark')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center gap-4">
                            <button type="submit"
                                    class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">
                                Add Mark
                            </button>
                            <a href="{{ route('assignments.show', $assignment) }}"
                               class="text-sm text-gray-600 dark:text-gray-400 hover:underline">
                                Cancel
                            </a>

                        </div>
                     </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
