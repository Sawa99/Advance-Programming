<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            API Test
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-lg font-semibold mb-4">Modules (from API)</h2>
            <ul id="modules-list"></ul>

            <h2 class="text-lg font-semibold mt-8 mb-4">Awards (from API)</h2>
            <ul id="awards-list"></ul>
        </div>
    </div>

    <script>
        fetch('/api/modules')
            .then(res => res.json())
            .then(data => {
                const list = document.getElementById('modules-list');
                data.forEach(module => {
                    list.innerHTML += `<li>${module.name} - Level ${module.level}</li>`;
                });
            });

        fetch('/api/awards')
            .then(res => res.json())
            .then(data => {
                const list = document.getElementById('awards-list');
                data.forEach(award => {
                    list.innerHTML += `<li>${award.name}</li>`;
                });
            });
    </script>
</x-app-layout>
