<?php
function resetTodo($fileName): void
{
    writeJsonData($fileName, []);
}