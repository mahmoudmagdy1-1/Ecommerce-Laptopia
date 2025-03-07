<?php

Namespace App\controllers;
class ErrorController
{
    public static function notFound($message = "Page not found")
    {
        http_response_code(404);

        loadView('error', [
            'status' => '404',
            'message' => $message
        ]);
    }
}