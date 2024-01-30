<?php
session_start();


$fileName = 'name.json';

$jsonData = file_get_contents($fileName);
$data = json_decode($jsonData, true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST["postName"])) {
        $name = $_POST["name"];
        $data[] = $name;
        file_put_contents($fileName, json_encode($data));
        $_SESSION['AddedTodo'] = "the todo has been added";
        header("Location: index.php");
        exit;
    } elseif (isset($_POST["resetButton"])) {
        file_put_contents($fileName, '[]');
        header("Location: index.php");
        exit;
    } elseif (isset($_POST["removeTodo"])) {
        $taskId = $_POST['removeTodo'];
        if (isset($data[$taskId])) {
            unset($data[$taskId]);
            file_put_contents($fileName, json_encode($data));
        }
        header("Location: index.php");
        exit;
    }

    if (isset($_POST["sortAZ"])) {
        sort($data);
        file_put_contents($fileName, json_encode($data));
        header("Location: index.php");
        exit;
    } elseif (isset($_POST["sortZA"])) {
        rsort($data);
        file_put_contents($fileName, json_encode($data));
        header("Location: index.php");
        exit;
    }
}
?>

<!--

ajout todo, supprimer todo, modif la todo, fleche pour déplacer haut bas,
button pour trier dans alphabétique, et inverse, element de triage -> get

-->

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
<form name="form" method="post" action="">
    <h1>Add a todo :</h1>
    <div class="todo-list">
        <?php if (!empty($data)) :
            foreach ($data as $key => $value) : ?>
                <div class='todo-row'>
                    <span class="todo-title"><?= htmlspecialchars($key + 1 . '. ' . $value) ?></span>
                    <div class="button-section">
                        <button type="submit" name="modifyTodo" value='<?= $key ?>'>
                            edit
                        </button>
                        <button class="remove-button" type='submit' name='removeTodo' value='<?= $key ?>'>
                            Remove
                        </button>
                    </div>
                </div>
            <?php endforeach;
        endif; ?>
    </div>

    <button type="submit" name="sortAZ">sort A to Z</button>
    <button type="submit" name="sortZA">sort Z to A</button>

    <label for="name">
        <input id="name" type="text" name="name">
    </label>
    <button type="submit" name="postName">Submit</button>
    <button class="remove-button" type="submit" name="resetButton">Remove All</button>
    <br>
    <span class="session"><?= $_SESSION['AddedTodo'] ?></span>
</form>
</body>
</html>


