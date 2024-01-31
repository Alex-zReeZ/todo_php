<?php
function readJsonData($fileName)
{
    $jsonData = file_get_contents($fileName);
    return json_decode($jsonData, true);
}