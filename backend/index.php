<?php

require 'vendor/autoload.php';
require "includes/config.php";
require "includes/helper.php";

$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$url = explode("/", $url);
$fileIdx = getFileIndex($url);
$model = $url[$fileIdx + 1] ?? "";
// TODO: tendria que ser una constante??
$validModels = ["pages"];
// TODO: retornar un mensaje tambien cuando no es un modelo valido
if (!isset($model) || !in_array($model, $validModels)) {
    header("HTTP/1.1 404 Not Found");
    exit();
}

if ($model === "pages") {
    $pageController = new PageController();
    $action = $url[$fileIdx + 2] ?? "";

    if ($action === "") {
        $pageController->getPosts();
    } else if ($action === "update") {
        $pageController->updatePosts();
    }
}