<?php

$fileName = 'name.json';
$data = [];

if (isset($_POST["postName"])) {
    $name = $_POST["name"];

    $jsonData = file_get_contents($fileName);
    $data = json_decode($jsonData);

    $data[] = $name;

    file_put_contents($fileName, json_encode($data));


    echo json_encode($data);
} elseif (isset($_POST["resetButton"])) {
    file_put_contents($fileName, '[]');



    echo json_encode([]);
} else {
    $jsonData = file_get_contents($fileName);
    echo $jsonData;
}

?>

<!--ajout todo, supprimer todo, modif la todo, fleche pour déplacer haut bas,
boutton pour trier dans alphabétique, et inverse, element de triage -> get
-->
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<h1> BONJOUR </h1>
<form name="form" method="post" action="">
    <h2>what's your name :</h2>

    <label for="">
        <input id="name" type="text" name="name">
    </label>
    <button type="submit" name="postName"> submit your input</button>
    <button type="submit" name="resetButton"> reset file </button>
</form>
</body>
</html>