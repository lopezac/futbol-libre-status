<?php

class PageController extends BaseController
{
    public function getPosts(): void
    {
        // TODO: quiza hacer que postModel sea una propiedad privada en vez de instanciarlo en cada metodo
        // TODO: agregar limit, tambien paginador incluso?
        $resBody = [];
        $resHeaders = [];

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

        $this->sendResponse(json_encode($resBody), $resHeaders);
    }

    public function updatePosts(): void
    {
        $resBody = [];
        $resHeaders = [];

        try {
            $pageModel = new PageModel();
            $newPages = $pageModel->getNewPages();

            if (count($newPages) > 0) {
                $res = $pageModel->deletePages();

                if ($res === true) {
                    $pageModel->insertPages($newPages);

                    $resBody["message"] = "Pages updated successfully!";
                    $resHeaders[] = "HTTP/1.1 200 OK";
                } else {
                    $resBody["error"] = "Error deleting pages";
                    $resHeaders[] = "HTTP/1.1 500 Internal Server Error";
                }
            } else {
                $resBody["error"] = "No new pages could be found!, an error occurred";
                $resHeaders[] = "HTTP/1.1 500 Internal Server Error";
            }
        } catch (PDOException $e) {
            $resBody["error"] = $e->getMessage();
            $resHeaders[] = "HTTP/1.1 500 Internal Server Error";
        }

        $this->sendResponse(json_encode($resBody), $resHeaders);
    }
}