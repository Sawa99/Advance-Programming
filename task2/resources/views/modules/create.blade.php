<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Module') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <form method="POST" action="{{ route('modules.store') }}">
                        @csrf

                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="credits" :value="__('Credits')" />
                            <x-text-input id="credits" name="credits" type="number" class="mt-1 block w-full" :value="old('credits')" required min="0" />
                            <x-input-error class="mt-2" :messages="$errors->get('credits')" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="level" :value="__('Level')" />
                            <x-text-input id="level" name="level" type="number" class="mt-1 block w-full" :value="old('level')" required min="1" />
                            <x-input-error class="mt-2" :messages="$errors->get('level')" />
                        </div>

                        <div class="mb-4">
                            <x-input-label :value="__('Awards')" />
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Select all awards this module belongs to.</p>
                            @foreach($awards as $award)
                                <label class="flex items-center gap-2 mb-1">
                                    <input type="checkbox" name="awards[]" value="{{ $award->id }}"
                                        {{ in_array($award->id, old('awards', [])) ? 'checked' : '' }}>
                                    {{ $award->name }}
                                </label>
                            @endforeach
                            <x-input-error class="mt-2" :messages="$errors->get('awards')" />
                        </div>

                        <x-primary-button>{{ __('Create Module') }}</x-primary-button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
