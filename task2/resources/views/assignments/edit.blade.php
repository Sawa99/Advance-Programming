<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit Assignment — {{ $assignment->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">


                    <form method="POST" action="{{ route('assignments.update', $assignment) }}">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="module_id" value="{{ $assignment->module_id }}">

                        {{-- Name --}}
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Assignment Name
                            </label>
                            <input type="text" id="name" name="name"
                                   value="{{ old('name', $assignment->name) }}"
                                   class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                   required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Weight --}}
                        <div class="mb-4">
                            <label for="weight" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Weight (%)
                            </label>
                            <input type="number" id="weight" name="weight"
                                   value="{{ old('weight', $assignment->weight) }}"
                                   min="0" max="100" step="0.01"
                                   class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                   required>
                            @error('weight')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Total Marks --}}
                        <div class="mb-6">
                            <label for="total_marks" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Total Marks
                            </label>
                            <input type="number" id="total_marks" name="total_marks"
                                   value="{{ old('total_marks', $assignment->total_marks) }}"
                                   min="1" step="0.01"
                                   class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                   required>
                            @error('total_marks')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center gap-4">
                            <button type="submit"
                                    class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">
                                Save Changes
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
