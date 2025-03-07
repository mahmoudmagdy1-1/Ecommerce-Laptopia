<?php
function basePath($path) : string
{
    return __DIR__ . "/" . $path;
}

function loadView($name, $data = []) : void
{
    $viewPath = basePath("app/views/{$name}.view.php");

    if (file_exists($viewPath)) {
        extract($data);
        require $viewPath;
    } else {
        echo "View '{$name} not found!'";
    }
}

function loadPartial($name) : void
{
    require basePath("app/views/partials/{$name}.php");
}

function inspect($variable) : void
{
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
}

function inspectAndDie($variable) : void
{
    inspect($variable);
    die();
}

function redirect($route) : void{
    header("Location : {$route}");
}