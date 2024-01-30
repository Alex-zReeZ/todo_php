<?php
session_start();

$dsn = "sqlite:myDb.db";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, null, null, $options);

$fileName = 'name.json';

$jsonData = file_get_contents($fileName);
$data = json_decode($jsonData, true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    /* add todo */
    if (isset($_POST["postName"])) {
        $name = $_POST["name"];
        $data[] = $name;
        file_put_contents($fileName, json_encode($data));
        $_SESSION['AddedTodo'] = "The todo has been added";
        $_SESSION['ShowMessage'] = true;

        /* reset all todo*/
    } elseif (isset($_POST["resetButton"])) {
        file_put_contents($fileName, '[]');

        /* remove todo*/
    } elseif (isset($_POST["removeTodo"])) {
        $taskId = $_POST['removeTodo'];
        if (isset($data[$taskId])) {
            unset($data[$taskId]);
            $data = array_values($data);
            file_put_contents($fileName, json_encode($data));
        }

    } elseif (isset($_POST["modifyTodo"])) {
        $key = $_POST['modifyTodo'];
        $newValue = $_POST["newValue$key"];


        if (isset($data[$key])) {
            $data[$key] = $newValue;
            file_put_contents($fileName, json_encode($data));
        }
    }

    /* sort the todo list */
    if (isset($_POST["sortAZ"])) {
        sort($data);
        file_put_contents($fileName, json_encode($data));
    } elseif (isset($_POST["sortZA"])) {
        rsort($data);
        file_put_contents($fileName, json_encode($data));

    }

    if (isset($_POST['upButton'])) {
        $taskId = $_POST['upButton'];
        if ($taskId > 0) {
            $temp = $data[$taskId];
            $data[$taskId] = $data[$taskId - 1];
            $data[$taskId - 1] = $temp;
            file_put_contents($fileName, json_encode($data));
        }
    }

    if (isset($_POST['downButton'])) {
        $taskId = $_POST['downButton'];
        if ($taskId < count($data) - 1) {
            $temp = $data[$taskId];
            $data[$taskId] = $data[$taskId + 1];
            $data[$taskId + 1] = $temp;
            file_put_contents($fileName, json_encode($data));
        }
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
