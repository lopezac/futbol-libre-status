<?php

// TODO: convertir en clase

// Return the position of the filename being accesed in an url
// TODO: mejorar agregar validacion, si no se encuentra el file segment
function getFileIndex(array $url): int
{
    $found = false;
    $fileIndex = 0;

    while (!$found && $fileIndex < count($url)) {
        if (str_ends_with($url[$fileIndex], ".php")) {
            $found = true;
        } else {
            $fileIndex++;
        }
    }

    return $fileIndex;
}