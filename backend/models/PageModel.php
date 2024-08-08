<?php

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\GuzzleException;

include "./keywords_data.php";

class PageModel extends DatabaseModel
{
    private string $search_keywords;
    private const MAX_PAGES_TO_SEARCH = 1;
    private HttpClient $client;

    // TODO: es necesario esto cuando no se agrega nada al construct¿??
    public function __construct(string $search_keywords = "futbol libre")
    {
        parent::__construct();
        $this->search_keywords = $search_keywords;
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

        for ($pager = 0; $pager < self::MAX_PAGES_TO_SEARCH; $pager++) {
            $pages = array_merge($pages, $this->getPagesFromBrowserRequest($pager));
        }

        return $pages;
    }

    private function getPagesFromBrowserRequest(int $pager): array
    {
        $url = $this->getSearchUrl($pager, 4);
        $pages = [];

        try {
            $res = $this->client->request("GET", $url, ["timeout" => 10]);
            $valid_urls = $this->getValidUrls($res->getBody());

            foreach ($valid_urls as $url) {
                $status = $this->getPageStatus($url);
// TODO: chequear si contenido de la pagina dice bloqueado o algo, y si tarda mucho la pagina en responder
                // TODO: sacar status de la base de datos, no sirve de mucho
                if ($status === 1) {
                    $pages[] = [
                        "status" => $status,
                        "url" => $url
                    ];
                }
            }
        } catch (GuzzleException $e) {
        } // TODO: esta bien hacer esto de un catch vacio??

        return $pages;
    }

    private function getSearchUrl(int $pager, int $option = 1): string
    {
        $url = "";

        // Soporta actualmente 4 motores de busqueda
        // Ordenados ascendentemente por eficiencia, siendo el 1 el mas eficiente
        switch ($option) {
            // Goo.ne.jp search engine
            case 1:
                $url = "https://search.goo.ne.jp/web.jsp?MT=" .
                    $this->search_keywords .
                    "&mode=0&sbd=goo001&IE=utf-8&OE=utf-8&nominify=1&FR=" .
                    $pager .
                    "0&DC=10&from=pager_web";
                break;
            // Yahoo.com search engine
            case 2:
                $url = "https://search.yahoo.com/search;_ylt=AwrEuUtkQrFmh7glJahXNyoA;_ylu=Y29sbwNiZjEEcG9zAzEEdnRpZAMEc2VjA3BhZ2luYXRpb24-?fr=sfp&fr2=p%3As%2Cv%3Asfp%2Cm%3Asb-top&p=";
                    str_replace(" ", "+", $this->search_keywords) .
                    "&b=" .
                    $pager .
                    "1&pz=7&bct=0&xargs=0";
                break;
            // Seznam.cz search engine
            case 3:
                $url = "https://www.mojeek.com/search?q=" .
                    str_replace(" ", "+", $this->search_keywords) .
                    "&s=" .
                    ($pager + 1) .
                    "1";
                break;
            // Mojeek.com search engine
            case 4:
                $url = "https://search.seznam.cz/?q=" .
                    str_replace(" ", "%20", $this->search_keywords) .
                    "&count=10&pId=poVw0cpAPenB35eAcSZl&from=" .
                    $pager .
                    "0";
            default:
        }

        return $url;
    }

    private function getValidUrls(string $body): array
    {
        $dom = new DomDocument();
        $urls = [];

        $dom->loadHTML($body);
        // TODO: intentar agregar un xpath o algo para validar sin funcion helper
        foreach ($dom->getElementsByTagName("a") as $anchor) {
            $url = $anchor->getAttribute("href");

            if ($this->validUrl($url) && !in_array($url, $urls, true)) {
                $urls[] = $url;
            }
        }

        return $urls;
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