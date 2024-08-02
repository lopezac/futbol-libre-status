<?php

include $_SERVER["DOCUMENT_ROOT"] . "/futbol-libre-status/extra/helper.php";

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

libxml_use_internal_errors(true);

class Connection
{
    private const UNWANTED_KEYWORDS = ["login", "twitter", "depor", "youtube", "apk", "mercadolibre", "canchaenmancha", "diariojornada", "memo", "tycsports", "comercioyjusticia", "elobservador", "tiempoar", "https://futbollibreenvivo.org"];
    private const WANTED_KEYWORDS = ["futbol", "pelota", "libre", "todos", "roja", "pirlo", "directa"];
    private Client $client;

    public function __construct()
    {
        $this->client = new Client(
            ["timeout" => 1]
        );
    }

    public function get_pages(string $phrase, int $amount_pages = 5): array
    {
        $total_pages = [];

        for ($i = 1; $i <= $amount_pages; $i++) {
            $page = $this->get_page($phrase, $i);
            $total_pages = array_merge($total_pages, $page);
            // usar array_unique aca
        }

        return $total_pages;
    }

    public function get_page(string $phrase, int $page = 0): array
    {
        $pages = [];
        $phrase = str_replace(" ", "%20", $phrase);

        $url = "https://search.goo.ne.jp/web.jsp?MT=" .
             $phrase .
            "&mode=0&sbd=goo001&IE=utf-8&OE=utf-8&nominify=2&FR=" .
            $page - 1 .
            "0&DC=10&from=pager_web";

        try {
            $res = $this->client->request("GET", $url, ["timeout" => 10]);
            $clean_urls = $this->get_clean_urls($res->getBody());

            foreach ($clean_urls as $url) {
                $status = $this->get_page_status($url);
                // chequear si contenido de la pagina dice bloqueado o algo, en tal caso 404 o 500 nose
                // si tarda mucho la pagina en responder tendria que ser 404
                $pages[] = [
                    "status" => $status,
                    "url" => $url
                ];
            }
        } catch (GuzzleException $e) {
            echo "Error haciendo request a " . $url . "<br>";
            echo "Mensaje del error: " . $e->getMessage() . "<br>";
        }

        return $pages;
    }

    public function get_clean_urls(string $body): array
    {
        $dom = new DomDocument();
        $dom->loadHTML($body);

        $urls = [];
        // intentar agregar un xpath o algo para validar sin funcion helper
        foreach ($dom->getElementsByTagName("a") as $anchor) {
            $url = $anchor->getAttribute("href");
            if ($this->valid_url($url)) {
                $urls[] = $url;
            }
        }

        return array_unique($urls);
    }

    public function valid_url(string $string): bool
    {
        return str_starts_with($string, "http") && str_contains_keyword($string, self::WANTED_KEYWORDS) &&
            !str_contains_keyword($string, self::UNWANTED_KEYWORDS);
    }

    public function get_page_status(string $url): int
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