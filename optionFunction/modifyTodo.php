<?php
function modifyTodo($fileName, $data, $key, $newValue): void
{
    if (isset($data[$key])) {
        $data[$key] = $newValue;
        writeJsonData($fileName, $data);
    }
}
