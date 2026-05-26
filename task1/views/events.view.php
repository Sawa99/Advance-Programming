<?php
require 'partials/head.php';
require 'partials/header.php';
require 'partials/nav.php'; ?>

    <main>
        <h1 class="font-sans text-2xl text-center p-3">Events Search</h1>

        <form method="post" class="bg-blue-50 p-6 rounded-lg shadow-sm mb-8 flex flex-row items-end gap-6">
            <div class="flex-1">
                <label for="type" class=" block text-base font-semibold text-blue-900 mb-1"> Event Type </label>
                <div>
                    <select name="type" id="type"
                            class="w-full p-2 border border-blue-200 rounded focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="">Select Type</option>
                        <option value="parties" <?= $selectedType === 'parties' ? 'selected' : '' ?>>Parties</option>
                        <option value="sport" <?= $selectedType === 'sport' ? 'selected' : '' ?>>Sport</option>
                        <option value="computing" <?= $selectedType === 'computing' ? 'selected' : '' ?>>Computing</option>
                    </select>
                </div>
            </div>
            <p>Or</p>
            <div class="flex-1">
                <label for="title" class="block text-base font-semibold text-blue-900 mb-1">Event Title</label>
                <div>
                    <input type="text" name="title" id="title" value="<?= $searchTitle ?>"
                           class="w-full p-2 border border-blue-200 rounded focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
            </div>
            <button class="bg-blue-800 text-white px-6 py-2 rounded font-bold hover:bg-blue-700 transition-colors"
                    type="submit">Search</button>
        </form>
        <div class="flex flex-row gap-10 items-start mt-8">

            <aside class="w-1/3 border-r border-blue-200 pr-6 pl-3">
                <h2 class="font-mono text-xl mb-4 text-blue-900 uppercase">Upcoming Events</h2>
                <ul class="space-y-6">
                    <?php
                    foreach ($events as $event):
                        $params = [];
                        if (!empty($selectedType)) {
                            $params[] = 'type=' . urlencode($selectedType);
                        }
                        if (!empty($searchTitle)) {
                            $params[] = 'title=' . urlencode($searchTitle);
                        }
                        $queryString = !empty($params) ? '&' . implode('&', $params) : '';
                        $imagePath = $event['imageURL']; ?>
                        <li class="bg-white border border-blue-100 rounded-lg overflow-hidden shadow-sm w-11/12 mx-auto">
                            <a  href="/task1/events.php?id=<?= $event['ID'] . $queryString ?>" class="block">
                                <div class="border-b border-blue-100" style="height: 150px; overflow: hidden;">
                                    <img src="<?= $imagePath ?>" alt="<?= htmlspecialchars($event['event_title']) ?>"
                                         class="block"
                                         style="width: 100%; height: 100%; object-fit: cover; object-position: center;">
                                </div>
                                <div class="p-3">
                                    <p class="text-blue-800 hover:underline font-semibold block leading-snug">
                                        <?= htmlspecialchars($event['type']) ?> - <?= htmlspecialchars($event['event_title']) ?>
                                    </p>
                                </div>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </aside>

            <section class="flex-1 min-h-[400px]">
                <?php if (!empty($selectedEvent)): ?>
                    <div class="bg-white p-8 rounded-lg border border-blue-100 shadow-sm">
                        <h2 class="font-mono text-2xl text-blue-900 border-b border-blue-800 mb-6 pb-2">Event Details</h2>
                        <ul class="space-y-4">
                            <?php foreach ($selectedEvent as $key => $value): ?>
                                <?php if (strtolower((string) $key) === 'id')
                                    continue; ?>
                                <?php
                                $displayValue = (string) $value;
                                if (stripos((string) $key, 'date') !== false && !empty($displayValue)) {
                                    $timestamp = strtotime($displayValue);
                                    if ($timestamp !== false) {
                                        $displayValue = date('j F Y g:i A', $timestamp);
                                    }
                                }
                                ?>
                                <li>
                                    <strong class="font-mono text-xs uppercase text-blue-700 block mb-1">
                                        <?= htmlspecialchars(ucwords(str_replace('_', ' ', $key))) ?>:
                                    </strong>
                                    <span class="text-lg text-gray-900"><?= htmlspecialchars($displayValue) ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php else: ?>
                    <div class="h-full flex items-center justify-center border-2 border-dashed border-blue-100 rounded-lg p-20">
                        <p class="text-blue-300 font-mono italic">Select an event from the list to view full details.</p>
                    </div>
                <?php endif; ?>
            </section>
        </div>
    </main>

<?php require 'partials/footer.php'; ?>