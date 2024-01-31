<?php

require "connectToDatabase.php";


/* Add todo */
function addTodo($fileName, $data, $name): void
{
    if (isset($_POST["postName"])) {
        writeDatabase();
    }
    $_SESSION['AddedTodo'] = "The todo has been added";
    $_SESSION['ShowMessage'] = true;
}

/* Modify tod */
function modifyTodo($fileName, $data, $key, $newValue): void
{
    if (isset($data[$key])) {
        $data[$key] = $newValue;
        writeDatabase($fileName, $data);
    }
}

/* Move todo up dans down */
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
    writedatabase($fileName, $data);
}

/* Remove todo */
function removeTodo($fileName, $data, $taskId): void
{
    if (isset($data[$taskId])) {
        unset($data[$taskId]);
        $data = array_values($data);
        writeDatabase($fileName, $data);
    }
}

/* Reset todo file */
function resetTodo($fileName): void
{
    global $pdo;
    $deleteData = $pdo->prepare('DELETE FROM todo');
    $deleteData->execute();
}

/* Sort todo alphabetically */
function sortTodos($fileName, $data, $sortType): void
{
    if ($sortType === "AZ") {
        sort($data);
    } elseif ($sortType === "ZA") {
        rsort($data);
    }
    writeDatabase($fileName, $data);
}

/* Write data in json */
function writeDatabase(): void
{
    global $pdo;
    $insertData = $pdo->prepare('INSERT INTO todo(name) VALUES (:nom)');
    $insertData->execute(['nom' => $_POST["name"]]);

    header("Location: index.php");
    exit;
}

/* Read json file */
function readJsonData($fileName)
{
    $jsonData = file_get_contents($fileName);
    return json_decode($jsonData, true);
}