<?php
require 'functions.php';
require 'database.php';

$heading = "Modules";
$modules = [];
$output = "";
$selectedLevel = isset($_GET['level']) ? htmlspecialchars($_GET['level']) : '';
$searchTitle = isset($_GET['title']) ? htmlspecialchars($_GET['title']) : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'level';

$config = require('config.php');
$db = new Database($config['database']);

$orderBy = $sort === 'alpha' ? 'ORDER BY title ASC' : 'ORDER BY Level ASC, title ASC';

if (!empty($selectedLevel) || !empty($searchTitle)) {
    if (!empty($selectedLevel) && !empty($searchTitle)) {
        $modules = $db->query("SELECT * FROM modules WHERE Level = :level AND title LIKE :title $orderBy", [
            'level' => $selectedLevel,
            'title' => '%' . $searchTitle . '%'
        ])->get();
    } elseif (!empty($selectedLevel)) {
        $modules = $db->query("SELECT * FROM modules WHERE Level = :level $orderBy", [
            'level' => $selectedLevel
        ])->get();
    } elseif (!empty($searchTitle)) {
        $modules = $db->query("SELECT * FROM modules WHERE title LIKE :title $orderBy", [
            'title' => '%' . $searchTitle . '%'
        ])->get();
    }

    if (count($modules) == 0) {
        $output = "No modules found, please try again";
    }
} else {
    $modules = $db->query("SELECT ID, level, title, imageURL FROM modules $orderBy")->get();
}

require "views/modules.view.php";