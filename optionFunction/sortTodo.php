<?php
function sortTodos($fileName, $data, $sortType): void
{
    if ($sortType === "AZ") {
        sort($data);
    } elseif ($sortType === "ZA") {
        rsort($data);
    }
    writeJsonData($fileName, $data);
}