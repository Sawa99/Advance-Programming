<?php

require 'functions.php';
require 'database.php';

$heading = "Module";
$config = require('config.php');
$db = new Database($config['database']);

$selectedLevel = isset($_GET['level']) ? htmlspecialchars($_GET['level']) : '';
$searchTitle = isset($_GET['title']) ? htmlspecialchars($_GET['title']) : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'level';

$id = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : '';

$module = $db->query('SELECT * FROM modules WHERE ID = :id', [
    'id' => $id
])->get();

$module = !empty($module) ? $module[0] : null;

require 'views/module.view.php';