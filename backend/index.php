<?php

require "vendor/autoload.php";

$helper = new Helper();
$full_url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$url = $helper->getUrlSubString($full_url);
$req_method = $_SERVER["REQUEST_METHOD"];
$pageController = new PageController();

// Permitir CORS, de la URL de frontend de desarrollo y produccion respectivamente
header("Access-Control-Allow-Origin: " . $_ENV["FRONTEND_URL"]);

if ($url === "/pages" && $req_method === "GET") {
    $pageController->getPages();
} else if ($url === "/pages/update" && $req_method === "POST") {
    $pageController->updatePosts();
} else {
    $resBody = ["error" => "The request url was not found on our server"];
    $resHeader = ["HTTP/1.1 404 Not Found"];
    $pageController->sendResponse(json_encode($resBody), $resHeader);
}