<?php

class Helper
{
    // TODO: this can be replaced maybe by some array func like map?
    public function strContainsKeyword(string $line, array $words): bool
    {
        $result = false;
        $i = 0;

        while ($i < count($words) && !$result) {
            if (str_contains($line, $words[$i])) {
                $result = true;
            }
            $i++;
        }

        return $result;
    }

    public function getUrlSubString(string $url): string|bool
    {
        // TODO: replace $entrypoint con magic constant
        $entrypoint = "index.php";
        $pos = strrpos($url, $entrypoint);
        $result = false;

        if ($pos !== false) {
            $result = substr($url, $pos + strlen($entrypoint));
        }

        return $result;
    }
}
