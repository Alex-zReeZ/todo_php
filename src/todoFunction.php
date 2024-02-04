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
function moveTodoUp(): void
{
    global $pdo;

    if (isset($_POST['upButton'])) {
        $taskId = $_POST['upButton'];

        $currentTodo = $pdo->prepare("SELECT id FROM todo WHERE id = :id");
        $currentTodo->execute([':id' => $taskId]);
        $currentPosition = $currentTodo->fetch(PDO::FETCH_ASSOC)['id'];

        if ($currentPosition > 1) {


            $abovePosition = $currentPosition - 1;
            $aboveTodo = $pdo->prepare("SELECT id FROM todo WHERE id = :id");
            $aboveTodo->execute(['id' => $abovePosition]);
            $aboveTodoId = $aboveTodo->fetch(PDO::FETCH_ASSOC)['id'];

            $moveUpData = $pdo->prepare("UPDATE todo SET id = :tempPosition WHERE id = :id");
            $moveUpData->execute(['id' => $taskId, ':tempPosition' => -1]);

            $moveAboveData = $pdo->prepare("UPDATE todo SET id = :currentPosition WHERE id = :id");
            $moveAboveData->execute(['id' => $aboveTodoId, ':currentPosition' => $currentPosition]);

            $moveTempData = $pdo->prepare("UPDATE todo SET id = :abovePosition WHERE id = :id");
            $moveTempData->execute(['id' => $taskId, ':abovePosition' => $abovePosition]);
        }
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

/* Sort todo inversly alphabetically */
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

/* search a todo in database */
function searchTodo()
{

}