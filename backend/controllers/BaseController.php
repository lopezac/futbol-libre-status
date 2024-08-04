<?php

class BaseController
{
    public function getQueryParams(): array
    {
        parse_str($_SERVER["QUERY_STRING"], $query);
        return $query;
    }

    // We return a 404 not found header when the controller action is not found
    public function __call(string $name, array $arguments): void
    {
        $this->sendOutput(
            json_encode(["message" => "The requested action is not supported"]), ["HTTP/1.1 404 Not Found"]
        );
    }

    public function sendOutput(string $data, array $headers): void
    {
        // We remove the Set-Cookie because it is not required
        header_remove("Set-Cookie");

        foreach ($headers as $header) {
            header($header);
        }

        echo $data;
    }
}