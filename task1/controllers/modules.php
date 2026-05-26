<?php

require 'functions.php';
require 'database.php';

$heading = "Modules";
$modules = [];
$output = "";
$filter = "";
$selectedLevel = "";
$searchTitle = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $level = isset($_POST['level']) ? htmlspecialchars($_POST['level']) : ''; //helps prevent sql injection
    $title = isset($_POST['title']) ? htmlspecialchars($_POST['title']) : '';
    $selectedLevel = $level;
    $searchTitle = $title;

    if (empty($level) && empty($title)) {
        $output = "Please provide either a level or a title to search";
    } else {
        $config = require('config.php');
        $db = new Database($config['database']); //connect to database

        //queries for both level and title
        if (!empty($level) || !empty($title)) {
            $query = "select * from modules where Level = :level AND title like :title";
            $modules = $db->query($query, [
                'level' => $level,
                'title' => '%' . $title . '%'
            ])->get();
            $filter = $level . " " . $title;
            $searchType = "level " . $level . " and title '" . $title . "'";
        }

        //Output if no matches
        if (count($modules) == 0) {
            $output = "<p>We have found no matches for " . $searchType . ", please try again</p>";
        }
    }
} elseif (isset($_GET['level']) || isset($_GET['title'])) {
    $level = isset($_GET['level']) ? htmlspecialchars($_GET['level']) : '';
    $title = isset($_GET['title']) ? htmlspecialchars($_GET['title']) : '';
    $selectedLevel = $level;
    $searchTitle = $title;

    if (!empty($level) || !empty($title)) {
        $config = require('config.php');
        $db = new Database($config['database']);

        //queries for both level and title
        if (!empty($level) || !empty($title)) {
            $query = "select * from modules where Level = :level AND title like :title";
            $modules = $db->query($query, [
                'level' => $level,
                'title' => '%' . $title . '%'
            ])->get();
            $filter = $level . " " . $title;
            $searchType = "level " . $level . " and title '" . $title . "'";
        }

        if (count($modules) == 0) {
            $output = "<p>We have found no matches for " . $searchType . ", please try again</p>";
        }
    }
} else {
    $output = "Please add details to the form and press search";
}

require "views/modules.view.php";
