<?php

function str_contains_keyword(string $line, array $words): bool
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