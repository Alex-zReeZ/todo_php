<?php
session_start();
require "connectToDatabase.php";
require "todoFunction.php";
global $row;

/* connect to json and in the futur the database */
/*$pdo = connectToDatabase();*/


/* Call the functions */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST["postName"])) {
        addTodo();
    } elseif (isset($_POST["resetButton"])) {
        resetTodo();
    } elseif (isset($_POST["removeTodo"])) {
        removeTodo($_POST['removeTodo']);
    } elseif (isset($_POST["modifyTodo"])) {
        modifyTodo();
    } elseif (isset($_POST['upButton'])) {
        moveTodo($_POST['upButton'], 'up');
    } elseif (isset($_POST['downButton'])) {
        moveTodo($_POST['downButton'], 'down');
    }
    header("Location: index.php");
    exit;
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET["sortAZ"])) {
        sortTodosAZ();
    } elseif (isset($_GET["sortZA"])) {
        sortTodosZA();
    }
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
    <h3>Click on todo to edit text</h3>
    <div class="todo-list">
        <?php
        $test = 1;
        if (!empty($row)) :
            foreach ($row as $todo) :
                ?>
                <div class="todo-row">
                    <form action="" method="post">
                        <div class="todo-title">
                            <?php echo htmlspecialchars($test++ . '. '); ?>
                            <label>
                                <input class="hide-input" name="newValue_<?= $todo['id'] ?>"
                                       value="<?= $todo['name'] ?>">
                            </label>
                        </div>
                        <div class="button-section">
                            <button class="btn btn-success" type="submit" name="modifyTodo" value="<?= $todo['id'] ?>">
                                Confirm edit
                            </button>
                            <button class="btn btn-danger" type='submit' name='removeTodo' value='<?= $todo['id'] ?>'>
                                Remove
                            </button>
                        </div>
                        <div class="up-down">
                            <button class="btn btn-primary" type="submit" name="upButton" value='<?= $todo['id'] ?>'>
                                Up
                            </button>
                            <button class="btn btn-primary" type="submit" name="downButton" value='<?= $todo['id'] ?>'>
                                Down
                            </button>
                        </div>
                    </form>
                </div>
            <?php
            endforeach;
        endif;
        ?>
    </div>
    <div class="down-button">
        <div class="formsort">
            <form action="" method="get">
                <button class="btn btn-secondary" type="submit" name="sortAZ">sort A to Z</button>
                <button class="btn btn-secondary" type="submit" name="sortZA">sort Z to A</button>
            </form>
        </div>
        <form action="" method="post">
            <label for="name">
                <input class="form-control" id="name" type="text" name="name">
            </label>
            <button class="btn btn-primary" type="submit" name="postName">Submit</button>
        </form>
        <form action="" method="post">
            <button class="btn btn-danger" type="submit" name="resetButton">Remove All</button>
        </form>
    </div>

    <br>

    <?php if ($showMessage): ?>
        <span class="session"><?= $_SESSION['AddedTodo'] ?></span>
    <?php endif; ?>
</form>

</body>
</html>
