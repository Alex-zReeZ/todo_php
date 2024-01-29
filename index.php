<?php
require "AddTodo.php";

$fileName = 'name.json';

$jsonData = file_get_contents($fileName);
$data = json_decode($jsonData);


if (isset($_POST["postName"])) {
    $name = $_POST["name"];
    $data[] = $name;
    file_put_contents($fileName, json_encode($data));
    header("Location: index.php");

} elseif (isset($_POST["resetButton"])) {
    file_put_contents($fileName, '');
    header("Location: index.php");
}


?>


<!--

ajout todo, supprimer todo, modif la todo, fleche pour déplacer haut bas,
boutton pour trier dans alphabétique, et inverse, element de triage -> get

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
<h1> BONJOUR </h1>
<form name="form" method="post" action="">
    <h2>Add a todo :</h2>
    <div class="todo-list">
        <?php
        if (!empty($data)) {
            foreach ($data as $key => $value) {
                echo "<div class='todo-row'>" . $value . "</div>";
            }
        } ?>
    </div>

    <label for="">
        <input id="name" type="text" name="name">
    </label>
    <button type="submit" name="postName"> submit</button>
    <button type="submit" name="resetButton"> reset all</button>
</form>

</body>
</html>