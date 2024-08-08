<?php

require "vendor/autoload.php";
require "includes/config.php";

$helper = new Helper();
$full_url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$url = $helper->getUrlSubString($full_url);
$req_method = $_SERVER["REQUEST_METHOD"];
$pageController = new PageController();

// TODO: Mejorar esto del handleo de CORS
// Permitir CORS, permitir a la url local localhost:3000
header("Access-Control-Allow-Origin: http://localhost:3000");

if ($url === "/pages" && $req_method === "GET") {
    $pageController->getPosts();
} else if ($url === "/pages/update" && $req_method === "POST") {
    // TODO: aceptar query parametro de keywords= y pasarlo aca a updatePosts
    $pageController->updatePosts();
} else {
    $resBody = ["error" => "The request url was not found on our server"];
    $resHeader = ["HTTP/1.1 404 Not Found"];
    $pageController->sendResponse(json_encode($resBody), $resHeader);
}