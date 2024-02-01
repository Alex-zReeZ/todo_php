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
/* Move todo up and down */
function moveTodoUp()
{
    global $pdo;

    if (isset($_POST['upButton'])) {
        $taskId = $_POST['upButton'];

        $moveUpData = $pdo->prepare("UPDATE todo SET id = id + 1 WHERE id = :id");
        $moveUpData->execute([':id' => $taskId]);
    } elseif (isset($_POST['downButton'])) {
        $taskId = $_POST['downButton'];

        $moveDownData = $pdo->prepare("UPDATE todo SET id = id - 1 WHERE id = :id");
        $moveDownData->execute([':id' => $taskId]);
    }
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

    $stmt = $pdo->prepare('SELECT * FROM todo ORDER BY name');
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

function searchTodo()
{

}