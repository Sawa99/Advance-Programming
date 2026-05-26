<?php
require 'partials/head.php';
require 'partials/header.php';
require 'partials/nav.php'; ?>

    <main>
        <section class="mb-10">
            <h2 class="font-mono text-xl mb-4 text-blue-900 uppercase pl-3">Featured Modules</h2>

            <?php if (!empty($featuredModules)): ?>
                <ul class="flex flex-wrap gap-6 pl-3">
                    <?php foreach ($featuredModules as $index => $module): ?>
                        <?php $imagePath = $module['imageURL']; ?>
                        <li class="bg-white border border-blue-100 rounded-lg overflow-hidden shadow-sm"
                            style="width: 320px; flex: 0 0 320px;">
                            <a href="/task1/module.php?id=<?= $module['ID'] ?>" class="block">
                                <div class="border-b border-blue-100" style="height: 220px; overflow: hidden;">
                                    <img src="<?= $imagePath ?>" alt="<?= htmlspecialchars($module['title']) ?>" class="block"
                                         style="width: 100%; height: 100%; object-fit: cover; object-position: center;">
                                </div>
                                <div class="p-4">
                                    <h3 class="text-blue-800 hover:underline font-semibold leading-snug">
                                        <?= htmlspecialchars($module['title']) ?>
                                    </h3>
                                </div>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p class="text-blue-700 pl-3">No featured modules found.</p>
            <?php endif; ?>
        </section>

        <section>
            <h2 class="font-mono text-xl mb-4 text-blue-900 uppercase pl-3">Upcoming Events</h2>

            <?php if (!empty($upcomingEvents)): ?>
                <ul class="flex flex-wrap gap-6 pl-3">
                    <?php foreach ($upcomingEvents as $index => $event): ?>
                        <?php $imagePath = $event['imageURL']; ?>
                        <li class="bg-white border border-blue-100 rounded-lg overflow-hidden shadow-sm"
                            style="width: 320px; flex: 0 0 320px;">
                            <a href="/task1/events.php?id=<?= $event['id'] ?>" class="block">
                                <div class="border-b border-blue-100" style="height: 220px; overflow: hidden;">
                                    <img src="<?= $imagePath ?>" alt="<?= htmlspecialchars($event['event_title']) ?>" class="block"
                                         style="width: 100%; height: 100%; object-fit: cover; object-position: center;">
                                </div>
                                <div class="p-4">
                                    <p class="text-blue-800 hover:underline font-semibold block leading-snug">
                                        <?= htmlspecialchars($event['event_title']) ?>
                                    </p>
                                </div>
                            </a>
                            <div class="px-4 pb-3">
                                <button onclick="this.nextElementSibling.classList.toggle('hidden')"
                                        class="text-sm text-blue-600 hover:underline font-medium">See more</button>
                                <div class="hidden mt-2 text-sm text-gray-700 space-y-1 border-t border-blue-50 pt-2">
                                    <p><span class="font-semibold text-blue-800">Date:</span>
                                        <?= date('j F Y g:i A', strtotime($event['start_datetime'])) ?></p>
                                    <p><span class="font-semibold text-blue-800">Location:</span>
                                        <?= htmlspecialchars($event['location'] ?? 'TBC') ?></p>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p class="text-blue-700">No upcoming events found.</p>
            <?php endif; ?>
        </section>
    </main>

<?php require 'partials/footer.php'; ?>