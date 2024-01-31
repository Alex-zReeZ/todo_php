<?php
session_start();

/* Database connexion */
require "connectToDatabase.php";

/* Read JSON data from file */
require "readJsonData.php";

/* Write JSON data to file */
require "writeJsonData.php";

/* Add a new todo */
require "addTodo.php";

/* Reset all todos */
require "resetTodo.php";

/* Remove a todo */
require "removeTodo.php";

/* Modify a todo */
require "modifyTodo.php";

/* Sort the todo list */
require "sortTodo.php";

/* Move todo up or down */
require "moveTodo.php";

$fileName = 'name.json';
$pdo = connectToDatabase();
$data = readJsonData($fileName);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST["postName"])) {
        addTodo($fileName, $data, $_POST["name"]);
    } elseif (isset($_POST["resetButton"])) {
        resetTodo($fileName);
    } elseif (isset($_POST["removeTodo"])) {
        removeTodo($fileName, $data, $_POST['removeTodo']);
    } elseif (isset($_POST["modifyTodo"])) {
        modifyTodo($fileName, $data, $_POST['modifyTodo'], $_POST["newValue" . $_POST['modifyTodo']]);
    } elseif (isset($_POST["sortAZ"]) || isset($_POST["sortZA"])) {
        sortTodos($fileName, $data, isset($_POST["sortAZ"]) ? "AZ" : "ZA");
    } elseif (isset($_POST['upButton'])) {
        moveTodo($fileName, $data, $_POST['upButton'], 'up');
    } elseif (isset($_POST['downButton'])) {
        moveTodo($fileName, $data, $_POST['downButton'], 'down');
    }

    header("Location: index.php");
    exit;
}

$showMessage = isset($_SESSION['ShowMessage']) && $_SESSION['ShowMessage'];
if ($showMessage) {
    $_SESSION['ShowMessage'] = false;
}
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Todo list PHP</title>
</head>
<body>
<form name="form" method="post" action="">
    <h1>Add a todo</h1>
    <h3
    >Clique on todo text to edit</h3>
    <div class="todo-list">
        <?php if (!empty($data)) :
            foreach ($data as $key => $value) : ?>
                <div class='todo-row'>
                    <div class="todo-title">
                        <?= htmlspecialchars($key + 1 . '. ') ?>
                        <label>
                            <input class=hide-input name="newValue<?= $key ?>" value='<?= $value ?>'>
                        </label>
                    </div>
                    <div class="button-section">
                        <button class="btn btn-success" type="submit" name="modifyTodo" value='<?= $key ?>'>
                            confirm edit
                        </button>
                        <button class="btn btn-danger" type='submit' name='removeTodo' value='<?= $key ?>'>
                            Remove
                        </button>
                    </div>
                    <div class="up-down">
                        <button class="btn btn-primary" type="submit" name="upButton" value='<?= $key ?>'>Up</button>
                        <button class="btn btn-primary" type="submit" name="downButton" value='<?= $key ?>'>Down
                        </button>
                    </div>
                </div>
            <?php endforeach;
        endif; ?>
    </div>
    <div class="down-button">
        <button class="btn btn-secondary" type="submit" name="sortAZ">sort A to Z</button>
        <button class="btn btn-secondary" type="submit" name="sortZA">sort Z to A</button>

        <label for="name">
            <input class="form-control" id="name" type="text" name="name">
        </label>
        <button class="btn btn-primary" type="submit" name="postName">Submit</button>
        <button class="btn btn-danger" type="submit" name="resetButton">Remove All</button>
    </div>
    <br>

    <?php if ($showMessage): ?>
        <span class="session"><?= $_SESSION['AddedTodo'] ?></span>
    <?php endif; ?>
</form>
</body>
</html>
