<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- User Details --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">My Details</h3>
                    <p><span class="font-medium">Name:</span> {{ $user->name }}</p>
                    <p><span class="font-medium">Email:</span> {{ $user->email }}</p>
                    <p><span class="font-medium">Award:</span> {{ $user->award?->name ?? 'Not assigned' }}</p>
                    <div class="mt-4">
                        <a href="{{ route('profile.edit') }}" class="text-indigo-600 dark:text-indigo-400 underline text-sm">
                            Edit Profile &amp; Award
                        </a>
                    </div>
                </div>
            </div>

            {{-- Predicted Classification --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Predicted Classification</h3>

                    @if ($modules->isEmpty())
                        <p class="text-gray-500 dark:text-gray-400 italic">No modules found.</p>
                    @else
                        <form method="GET" action="{{ route('dashboard') }}" class="mb-6">
                            @foreach ($modules as $module)
                                @php $actual = \App\Helpers\ClassificationHelper::modulePercentage($module->assignments); @endphp
                                <div class="flex items-center justify-between mb-3">
                                    <div>
                                        <span class="font-medium">{{ $module->name }}</span>
                                        <span class="text-sm text-gray-500 dark:text-gray-400 ml-2">
                                Level {{ $module->level }} &bull; {{ $module->credits }} credits
                            </span>
                                    </div>

                                    @if ($actual !== null && $module->is_completed)
                                        <span class="text-sm text-green-600 dark:text-green-400">
                                {{ $actual }}% (actual)
                            </span>
                                        <input type="hidden" name="predictions[{{ $module->id }}]" value="{{ $actual }}">
                                    @else
                                        @if ($actual !== null)
                                            <span class="text-sm text-gray-500 dark:text-gray-400 mr-2">
                                    Currently {{ $actual }}%
                                </span>
                                        @endif
                                        <input type="number"
                                               name="predictions[{{ $module->id }}]"
                                               min="0" max="100" step="0.1"
                                               placeholder="Predicted %"
                                               value="{{ request('predictions.' . $module->id) }}"
                                               class="w-32 border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md text-sm">
                                    @endif
                                </div>
                            @endforeach

                            <button type="submit"
                                    class="mt-2 px-4 py-2 bg-blue-600 text-white rounded-md text-sm hover:bg-blue-700">
                                Predict Classification
                            </button>
                        </form>

                        @if ($prediction['overall'] > 0)
                            <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                                <p class="text-lg font-semibold">
                                    Predicted: {{ $prediction['classification'] }}
                                    <span class="text-gray-500 dark:text-gray-400 font-normal text-sm ml-2">
                            ({{ $prediction['overall'] }}% overall)
                        </span>
                                </p>
                                @if ($prediction['level5Average'] !== null)
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                        Level 5 average: {{ $prediction['level5Average'] }}%
                                    </p>
                                @endif
                                @if ($prediction['level6Average'] !== null)
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                        Level 6 average: {{ $prediction['level6Average'] }}%
                                    </p>
                                @endif
                            </div>
                        @endif
                    @endif
                </div>
            </div>

            {{-- Modules & Grades --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">My Modules</h3>

                    @if($modules->isEmpty())
                        <p class="text-gray-500 dark:text-gray-400">No modules assigned to your award.</p>
                    @else
                        <ul class="space-y-4">
                            @foreach($modules as $module)
                                <li>
                                    <a href="{{ route('modules.show', $module) }}" class="font-bold text-indigo-600 dark:text-indigo-400 hover:underline">{{ $module->name }}</a>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">
                                        (Level {{ $module->level }}, {{ $module->credits }} credits)
                                    </span>

                                    @if($module->is_completed)
                                        @php
                                            $allMarks = $module->assignments->flatMap->marks;
                                            $average = $allMarks->isNotEmpty() ? round($allMarks->avg('mark'), 2) : null;
                                        @endphp
                                        <span class="ml-2">— Overall Grade: {{ $average !== null ? $average : 'No marks recorded' }}</span>
                                    @else
                                        <ul class="ml-4 mt-1 space-y-1 text-sm">
                                            @foreach($module->assignments as $assignment)
                                                @php $mark = $assignment->marks->first(); @endphp
                                                <li>{{ $assignment->name }}: {{ $mark ? $mark->mark : 'Ungraded' }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
