<?php
function moveTodo($fileName, $data, $taskId, $direction): void
{
    if ($direction === 'up' && $taskId > 0) {
        $temp = $data[$taskId];
        $data[$taskId] = $data[$taskId - 1];
        $data[$taskId - 1] = $temp;
    } elseif ($direction === 'down' && $taskId < count($data) - 1) {
        $temp = $data[$taskId];
        $data[$taskId] = $data[$taskId + 1];
        $data[$taskId + 1] = $temp;
    }
    writeJsonData($fileName, $data);
}