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

function loadPartial($name, $data = []) : void
{
    $viewPath = basePath("app/views/partials/{$name}.php");

    if (file_exists($viewPath)) {
        extract($data);
        require $viewPath;
    } else {
        echo "View '{$name} not found!'";
    }
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
    header("Location: {$route}");
}

function sanitize($value)
{
    return htmlspecialchars(trim($value));
}

function groupCartItems($cart) {
    $result = [];

    foreach ($cart as $item) {
        $id = $item['product_id'];
        $qty = (int)$item['quantity']; // convert to int

        // If product_id not added yet, initialize it.
        if (!isset($result[$id])) {
            $result[$id] = [
                'product_id' => $id,
                'quantity' => 0,
            ];
        }

        // Sum up the quantity.
        $result[$id]['quantity'] += $qty;
    }
    return $result;
}