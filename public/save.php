<?php
$path = dirname(__FILE__);

if (!isset($_POST['action'])
    || !isset($_POST['image_name'])) {
        die("No action");
}

$action    = $_POST['action'];
$imageName = $_POST['image_name'];

$pathImage = "{$path}/upload/images/{$action}";
rename("{$path}/upload/temp/{$imageName}", "{$pathImage}/{$imageName}");
