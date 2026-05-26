<?php
require 'partials/head.php';
require 'partials/header.php';
require 'partials/nav.php'; ?>

    <main>
    <main>
        <h1 class="font-sans text-2xl text-center p-3">Modules Search</h1>

        <form method="GET" class="bg-blue-50 p-6 rounded-lg shadow-sm mb-8 flex flex-row items-end gap-6">
            <div class="flex-1">
                <label for="level" class="block text-base font-semibold text-blue-900 mb-1">Module Level</label>
                <div>
                    <select name="level" id="level"
                            class="w-full p-2 border border-blue-200 rounded focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="">Select Level</option>
                        <option value="5" <?= $selectedLevel === '5' ? 'selected' : '' ?>>5</option>
                        <option value="6" <?= $selectedLevel === '6' ? 'selected' : '' ?>>6</option>
                    </select>
                </div>
            </div>
            <p>Or</p>
            <div class="flex-1">
                <label for="title" class="block text-base font-semibold text-blue-900 mb-1">Module Title</label>
                <div>
                    <input type="text" name="title" id="title" value="<?= $searchTitle ?>"
                           class="w-full p-2 border border-blue-200 rounded focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
            </div>
            <div class="flex-1">
                <label for="sort" class="block text-base font-semibold text-blue-900 mb-1">Sort By</label>
                <select name="sort" id="sort"
                        class="w-full p-2 border border-blue-200 rounded focus:ring-2 focus:ring-blue-500 outline-none">
                    <option value="level" <?= $sort === 'level' ? 'selected' : '' ?>>Level</option>
                    <option value="alpha" <?= $sort === 'alpha' ? 'selected' : '' ?>>Alphabetical</option>
                </select>
            </div>
            <button class="bg-blue-800 text-white px-6 py-2 rounded font-bold hover:bg-blue-700 transition-colors"
                    type="submit">Search</button>
        </form>

        <?php if (!empty($output)): ?>
            <div class="pl-3"><?= $output ?></div>
        <?php endif; ?>

        <ul class="flex flex-wrap gap-6 pl-3">
            <?php foreach ($modules as $module): ?>
                <?php
                $imagePath = $module['imageURL'];
                ?>
                <li class="bg-white border border-blue-100 rounded-lg overflow-hidden shadow-sm"
                    style="width: 320px; flex: 0 0 320px;">
                    <a href="/task1/module.php?id=<?= $module['ID'] ?>&level=<?= urlencode($selectedLevel) ?>&title=<?= urlencode($searchTitle) ?>&sort=<?= urlencode($sort) ?>" class="block">
                        <div class="border-b border-blue-100" style="height: 220px; overflow: hidden;">
                            <img src="<?= $imagePath ?>" alt="<?= htmlspecialchars($module['title']) ?>" class="block"
                                 style="width: 100%; height: 100%; object-fit: cover; object-position: center;">
                        </div>
                        <div class="p-4">
                            <p class="text-blue-800 hover:underline font-semibold block leading-snug">
                                Level <?= htmlspecialchars($module['level']) ?> - <?= htmlspecialchars($module['title']) ?>
                            </p>
                        </div>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </main>

<?php require 'partials/footer.php'; ?>