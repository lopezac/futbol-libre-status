<?php

class PageController extends BaseController
{
    public function getPosts(): void
    {
        // TODO: quiza hacer que postModel sea una propiedad privada en vez de instanciarlo en cada metodo
        // TODO: agregar limit, tambien paginador incluso?
        $resBody = [];
        $resHeaders = [];

        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            try {
                $postModel = new PageModel();
                $pages = $postModel->getPages();

                $resBody["pages"] = $pages;
                $resHeaders[] = "Content-type: application/json";
                $resHeaders[] = "HTTP/1.1 200 OK";
            } catch (PDOException $e) {
                $resBody["error"] = $e->getMessage();
                $resHeaders[] = "HTTP/1.1 500 Internal Server Error";
            }
        } else {
            $resBody["error"] = "The method " . $_SERVER["REQUEST_METHOD"] . " is not supported";
            $resHeaders[] = "HTTP/1.1 422 Unprocessable Entity";
        }

        $this->sendOutput(json_encode($resBody), $resHeaders);
    }

    public function updatePosts(): void
    {

    }
}