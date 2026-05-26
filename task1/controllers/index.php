<?php
require 'functions.php';
require 'database.php';

$heading = "Home";

$config = require('config.php');

$modulesDb = new Database($config['database']);
$eventsDb = new Database($config['events_database']);

$featuredModules = $modulesDb
    ->query(
        'select ID, level, title, imageURL from modules where level = :level order by rand() limit 3',
        ['level' => 5]
    )
    ->get();

$upcomingEvents = $eventsDb
    ->query(
        'select id, type, event_title, start_datetime, location, imageURL from events where start_datetime >= now() order by start_datetime asc'
    )
    ->get();

require "views/index.view.php";
