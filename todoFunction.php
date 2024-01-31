<?php

require "connectToDatabase.php";


/* Add todo */
function addTodo(): void
{
    $_SESSION['AddedTodo'] = "The todo has been added";
    $_SESSION['ShowMessage'] = true;
    writeDatabase();
}

/* Modify tod */
function modifyTodo($data, $key, $newValue): void
{
    if (isset($data[$key])) {
        $data[$key] = $newValue;
        writedatabase();
    }
}

/* Move todo up dans down */
function moveTodo($data, $taskId, $direction): void
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
    writedatabase();
}

/* Remove todo */
function removeTodo($taskId): void
{
    global $pdo;
    $deleteData = $pdo->prepare('DELETE FROM todo WHERE id = :id;');
    $deleteData->execute(['id' => $taskId]);
}


/* Reset todo file */
function resetTodo(): void
{
    global $pdo;
    $deleteData = $pdo->prepare('DELETE FROM todo');
    $deleteData->execute();
}

/* Sort todo alphabetically */
function sortTodos($data, $sortType): void
{
    global $pdo;
    if ($sortType === "AZ") {
        sort($data);
    } elseif ($sortType === "ZA") {
        rsort($data);
    }
    writeDatabase();
}

/* Write data in json */
function writeDatabase(): void
{
    global $pdo;
    $insertData = $pdo->prepare('INSERT INTO todo(name, id) VALUES (:name, :id)');
    $insertData->execute(['name' => $_POST["name"]]);

    header("Location: index.php");
    exit;
}

