<?php

class BaseController
{
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