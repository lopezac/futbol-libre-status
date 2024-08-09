<?php

class PageController extends BaseController
{
    private PageModel $pageModel;

    public function __construct() {
        $this->pageModel = new PageModel($_GET["keywords"] ?? "futbol libre");
    }

    public function getPages(): void
    {
        // TODO: agregar limit, tambien paginador incluso?
        $resBody = [];
        $resHeaders = [];

        try {
            $pages = $this->pageModel->getPages();

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
            $newPages = $this->pageModel->getNewPages();

            if (count($newPages) > 0) {
                $res = $this->pageModel->deletePages();

                if ($res === true) {
                    $this->pageModel->insertPages($newPages);

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