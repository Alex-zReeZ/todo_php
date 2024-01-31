<?php
function removeTodo($fileName, $data, $taskId): void
{
    if (isset($data[$taskId])) {
        unset($data[$taskId]);
        $data = array_values($data);
        writeJsonData($fileName, $data);
    }
}