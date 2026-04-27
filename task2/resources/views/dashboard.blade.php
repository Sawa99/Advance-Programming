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
                    <p class="text-gray-500 dark:text-gray-400 italic">Coming soon...</p>
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
                                    <strong>{{ $module->name }}</strong>
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
