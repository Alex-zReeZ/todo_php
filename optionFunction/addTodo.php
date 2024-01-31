<?php
function addTodo($fileName, $data, $name): void
{
    $data[] = $name;
    writeJsonData($fileName, $data);
    $_SESSION['AddedTodo'] = "The todo has been added";
    $_SESSION['ShowMessage'] = true;
}