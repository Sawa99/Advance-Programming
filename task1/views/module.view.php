<?php
require 'partials/head.php';
require 'partials/header.php';
require 'partials/nav.php'; ?>

    <main class="p-6">
        <h1 class="text-blue-900 text-2xl font-bold mb-4"><?= $heading ?></h1>
        <div class="bg-blue-50 p-6 rounded-lg space-y-4">
            <div>
                <h2 class="font-semibold text-lg text-blue-900">Module: <?= htmlspecialchars($module['title']) ?></h2>
                <p class="text-gray-600">Level <?= $module['level'] ?></p>
            </div>
            <div>
                <p class="text-blue-900 font-medium">Module Leader:</p>
                <p><?= htmlspecialchars($module['leader']) ?></p>
            </div>
            <div>
                <p class="text-blue-900 font-medium">Module Description:</p>
                <p><?= htmlspecialchars($module['description']) ?></p>
            </div>
        </div>

        <p class="mt-6">
            <?php
            $params = [];
            if (!empty($selectedLevel)) {
                $params[] = 'level=' . urlencode($selectedLevel);
            }
            if (!empty($searchTitle)) {
                $params[] = 'title=' . urlencode($searchTitle);
            }
            if (!empty($sort)) {
                $params[] = 'sort=' . urlencode($sort);
            }
            $queryString = !empty($params) ? '?' . implode('&', $params) : '';
            ?>
            <a class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
               href="/task1/modules.php<?= $queryString ?>">← Back to modules list</a>
        </p>
    </main>

<?php require 'partials/footer.php'; ?>