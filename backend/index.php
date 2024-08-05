<?php

require 'vendor/autoload.php';
require "includes/config.php";
require "includes/Helper.php";

$helper = new Helper();
$full_url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$url = $helper->getUrlSubString($full_url);
$req_method = $_SERVER["REQUEST_METHOD"];
$pageController = new PageController();

if ($url === "/pages" && $req_method === "GET") {
    $pageController->getPosts();
} else if ($url === "/pages/update" && $req_method === "POST") {
    $pageController->updatePosts();
} else {
    $resBody = ["error" => "The request url was not found on our server"];
    $resHeader = ["HTTP/1.1 404 Not Found"];
    $pageController->sendResponse(json_encode($resBody), $resHeader);
}