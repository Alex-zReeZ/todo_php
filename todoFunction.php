<?php



function addTodo($fileName, $data, $name): void
{
    $data[] = $name;
    writeJsonData($fileName, $data);
    $_SESSION['AddedTodo'] = "The todo has been added";
    $_SESSION['ShowMessage'] = true;
}

function modifyTodo($fileName, $data, $key, $newValue): void
{
    if (isset($data[$key])) {
        $data[$key] = $newValue;
        writeJsonData($fileName, $data);
    }
}

function moveTodo($fileName, $data, $taskId, $direction): void
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
    writeJsonData($fileName, $data);
}

function removeTodo($fileName, $data, $taskId): void
{
    if (isset($data[$taskId])) {
        unset($data[$taskId]);
        $data = array_values($data);
        writeJsonData($fileName, $data);
    }
}

function resetTodo($fileName): void
{
    writeJsonData($fileName, []);
}

function sortTodos($fileName, $data, $sortType): void
{
    if ($sortType === "AZ") {
        sort($data);
    } elseif ($sortType === "ZA") {
        rsort($data);
    }
    writeJsonData($fileName, $data);
}

function writeJsonData($fileName, $data): void
{

/*    $insertData = $pdo->prepare('INSERT INTO todo(name) VALUES (:name)');
    $insertData->execute(['nom' => $_POST["todoName"], 'date' => $_POST["todoDate"]]);*/

    file_put_contents($fileName, json_encode($data));
}

function readJsonData($fileName)
{
    $jsonData = file_get_contents($fileName);
    return json_decode($jsonData, true);
}