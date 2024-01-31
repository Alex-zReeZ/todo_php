<?php
function writeJsonData($fileName, $data): void
{
    file_put_contents($fileName, json_encode($data));
}