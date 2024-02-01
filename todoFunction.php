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
function modifyTodo(): void
{
    global $pdo;

        $taskId = $_POST['modifyTodo'];
        $newValueKey = 'newValue_' . $taskId;

    if (isset($_POST[$newValueKey])) {
        $updatedValue = $_POST[$newValueKey];

        $updateData = $pdo->prepare('UPDATE todo SET name = :updatedValue WHERE id = :id');
        $updateData->execute(['id' => $taskId, 'updatedValue' => $updatedValue]);
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
function sortTodosAZ(): void
{

    global $pdo, $row;

    $stmt = $pdo->prepare('SELECT * FROM todo ORDER BY name ASC');
    $stmt->execute();

    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function sortTodosZA(): void
{
    global $pdo, $row;

    $stmt = $pdo->prepare('SELECT * FROM todo ORDER BY name DESC');
    $stmt->execute();

    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

