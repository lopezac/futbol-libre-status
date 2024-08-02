<?php

require $_SERVER["DOCUMENT_ROOT"] . "/futbol-libre-status/vendor/autoload.php";

$db = new Database();
$conn = new Connection();

if (isset($_POST["submitReload"])) {
    // Borrar todas las paginas de la base de datos
    $db->query(Database::QUERY_DELETE_ALL_PAGES, Database::EXECUTE);

    // TODO: verificar los fields que esten llenos
    $pages = $conn->get_pages($_POST["keywords"]);
    if (count($pages)) {
        foreach ($pages as $page) {
            $valuesToBind = [
                [":status", $page["status"]],
                [":url", $page["url"]]
            ];
            $db->query(Database::QUERY_INSERT_PAGE, Database::EXECUTE, $valuesToBind);
        }
        header("Location: index.php");
    }
}

