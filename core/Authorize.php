<?php

namespace Core;
use Core\Session;
class Authorize
{

    public function handle($middlewares)
    {
        $userRole = Session::get("user")['role'] ?? null;
        $isAuthorized = false;

        foreach ($middlewares as $middleware) {
            if ($middleware === 'guest') {
                $isAuthorized = ($userRole === null);
            } else {
                $isAuthorized = ($userRole === $middleware);
            }
            if ($isAuthorized) {
                break;
            }
        }
        if (!$isAuthorized) {
            redirect('/');
        }
    }
}