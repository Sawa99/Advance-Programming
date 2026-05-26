<?php
require 'functions.php';
require 'database.php';

$heading = "Events";
$events = [];
$output = "";
$filter = "";
$selectedType = "";
$searchTitle = "";
$selectedEvent = [];

$config = require('config.php');
$db = new Database($config['events_database']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = isset($_POST['type']) ? htmlspecialchars($_POST['type']) : '';
    $title = isset($_POST['title']) ? htmlspecialchars($_POST['title']) : '';
    $selectedType = $type;
    $searchTitle = $title;

    // Require either type or title
    if (empty($type) && empty($title)) {
        $output = "Please provide either a type or a title to search";
    } else {
        // Search by type if provided
        if (!empty($type) || !empty($title)) {
            $query = "select * from events where type = :type AND event_title like :title";
            $events = $db->query($query, [
                'type' => $type,
                'title' => '%' . $title . '%'
            ])->get();
            $filter = $type . " " . $title;
            $searchType = "type " . $type . " and title '" . $title . "'";
        }

        //output if no matches
        if (count($events) == 0) {
            $output = "<p>You have found no matches for " . $searchType . ", please try again</p>";
        }
    }
}  elseif (isset($_GET['id']) || isset($_GET['type']) || isset($_GET['title'])) {
    $type = isset($_GET['type']) ? htmlspecialchars($_GET['type']) : '';
    $title = isset($_GET['title']) ? htmlspecialchars($_GET['title']) : '';
    $selectedType = $type;
    $searchTitle = $title;

    if (!empty($type) || !empty($title)) {
        if (!empty($type) && !empty($title)) {
            $query = "select * from events where type = :type AND event_title like :title";
            $events = $db->query($query, ['type' => $type, 'title' => '%' . $title . '%'])->get();
            $searchType = "type " . $type . " and title '" . $title . "'";
        } elseif (!empty($type)) {
            $query = "select * from events where type = :type";
            $events = $db->query($query, ['type' => $type])->get();
            $searchType = "type " . $type;
        } else {
            $search = "%" . $title . "%";
            $query = "select * from events where event_title like :title";
            $events = $db->query($query, ['title' => $search])->get();
            $searchType = "title '" . $title . "'";
        }

        if (count($events) == 0) {
            $output = "<p>You have found no matches for " . $searchType . ", please try again</p>";
        }
    }

    $eventId = isset($_GET['id']) ? intval($_GET['id']) : 0;
    if ($eventId > 0) {
        $selectedEventResult = $db->query('select * from events where ID = :id', ['id' => $eventId])->get();
        if (!empty($selectedEventResult)) {
            $selectedEvent = $selectedEventResult[0];
        }
    }
}

require 'views/events.view.php';