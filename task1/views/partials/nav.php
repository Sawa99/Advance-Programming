
<?php
require 'functions.php';
$folder = $folder ?? '/task1/'; ?>

<nav class="sticky top-0">
    <ul class="list-none p-1 m-0 flex bg-blue-800 flex-row flex-wrap lg:justify-center">
        <li class="grow p-0 w-1/4 box-border lg:w-32 lg:grow-0 ">
            <a class="leading-[3] min-h-[45px] no-underline block text-amber-100 text-center " href="<?= $folder ?>"
                <?= urlIs('/task1/') ? ' aria-current="page"' : '' ?>>Home</a>
        </li>
        <li class="grow p-0 w-1/4  box-border lg:w-32 lg:grow-0">
            <a class="leading-[3] min-h-[45px] no-underline block text-amber-100 text-center"
               href="<?= $folder ?>modules" <?= urlIs('/task1/modules') ? ' aria-current="page"' : '' ?>>Modules</a>
        </li>
        <li class="grow p-0 w-1/4  box-border lg:w-32 lg:grow-0">
            <a class="leading-[3] min-h-[45px] no-underline block text-amber-100 text-center"
               href="<?= $folder ?>events" <?= urlIs('/task1/events') ? ' aria-current="page"' : '' ?>>Events</a>
        </li>
    </ul>
</nav>