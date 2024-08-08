<?php

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\GuzzleException;

include "./keywords_data.php";

class PageModel extends DatabaseModel
{
    private const SEARCH_KEYWORDS = "futbol libre";
    private const MAX_PAGES_TO_SEARCH = 10;
    private HttpClient $client;

    // TODO: es necesario esto cuando no se agrega nada al construct¿??
    public function __construct()
    {
        parent::__construct();
        $this->client = new HttpClient(["timeout" => 1]);
    }

    public function getPages(): array
    {
        $query = "SELECT * FROM pages";
        return $this->selectAll($query);
    }

    public function deletePages(): bool
    {
        $result = true;

        try {
            $query = "DELETE FROM pages";
            $this->execute($query);
        } catch (PDOException $e) {
            $result = false;
        }

        return $result;
    }

    public function insertPages(array $pages): void
    {
        foreach ($pages as $page) {
            $query = "INSERT INTO pages (url, status) VALUES (:url, :status)";
            $params = [
                [":url", $page["url"]], [":status", $page["status"]]
            ];
            $this->execute($query, $params);
        }
    }

    // TODO: getNewPages tendria que ir al modelo, o al controlador?
    public function getNewPages(): array
    {
        $pages = [];

        for ($i = 0; $i < self::MAX_PAGES_TO_SEARCH; $i++) {
            array_merge($pages, $this->getPagesFromBrowserRequest($i));
        }

        return $pages;
    }

    private function getPagesFromBrowserRequest(int $pager): array
    {
        $url = $this->getSearchUrl($pager);
        $pages = [];

        try {
            $res = $this->client->request("GET", $url, ["timeout" => 10]);
            $valid_urls = $this->getValidUrls($res->getBody());

            foreach ($valid_urls as $url) {
                $status = $this->getPageStatus($url);
// TODO: chequear si contenido de la pagina dice bloqueado o algo, y si tarda mucho la pagina en responder
                $pages[] = [
                    "status" => $status,
                    "url" => $url
                ];
            }
        } catch (GuzzleException $e) {
        } // TODO: esta bien hacer esto de un catch vacio??

        return $pages;
    }

    private function getSearchUrl(int $pager): string
    {
        switch ($option) {
            case 1:
                break;
            case 2:
                break;
            case 3:
                break;
            case 4:
                break;
        }
        // TODO: convertir SEARCH_KEYWORDS en un parametro, asi modularizable
        return "https://search.goo.ne.jp/web.jsp?MT=" .
            self::SEARCH_KEYWORDS .
            "&mode=0&sbd=goo001&IE=utf-8&OE=utf-8&nominify=1&FR=" .
            $pager .
            "0&DC=10&from=pager_web";
    }

    private function getValidUrls(string $body): array
    {
        $dom = new DomDocument();
        $urls = [];

        $dom->loadHTML($body);
        // TODO: intentar agregar un xpath o algo para validar sin funcion helper
        foreach ($dom->getElementsByTagName("a") as $anchor) {
            $url = $anchor->getAttribute("href");

            if ($this->validUrl($url)) {
                $urls[] = $url;
            }
        }

        return array_unique($urls);
    }

    private function validUrl(string $url): bool
    {
        $helper = new Helper();
        $hostname = parse_url($url, PHP_URL_HOST);

        return $helper->strContainsKeyword($hostname, WANTED_KEYWORDS) &&
            !$helper->strContainsKeyword($url, UNWANTED_KEYWORDS) &&
            !$helper->strContainsKeyword($url, UNWANTED_URLS);
    }

    public function getPageStatus(string $url): int
    {
        $status = 1;

        try {
            $this->client->request("GET", $url);
        } catch (GuzzleException $e) {
            $status = 0;
        }

        return $status;
    }
}