<?php

require $_SERVER["DOCUMENT_ROOT"] . "/futbol-libre-status/vendor/autoload.php";

$db = new Database();

$pages = $db->query(Database::QUERY_GET_PAGES, Database::SELECTALL);