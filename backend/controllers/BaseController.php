<?php

class BaseController
{
    public function getQueryParams(): array
    {
        parse_str($_SERVER["QUERY_STRING"], $query);
        return $query;
    }

    // We return a 404 not found header when the controller action is not found
    // TODO: Quiza no sea necesario este __call????
    public function __call(string $name, array $arguments): void
    {
        $this->sendResponse(
            json_encode(["error" => "The requested action is not supported"]), ["HTTP/1.1 404 Not Found"]
        );
    }

    public function sendResponse(string $data, array $headers): void
    {
        // We remove the Set-Cookie because it is not required
        header_remove("Set-Cookie");

        foreach ($headers as $header) {
            header($header);
        }

        echo $data;
    }
}