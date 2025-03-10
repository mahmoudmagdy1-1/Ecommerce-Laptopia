<?php

$router->get('/', 'HomeController@index');


$router->get('/products/', 'ProductController@index');
$router->get('/products/{id}', 'ProductController@index');

$router->get('/product/add', 'ProductController@add', ['admin']);
$router->get('/product/edit/{id}', 'ProductController@edit', ['admin']);
$router->get('/product/{id}', 'ProductController@show');

$router->post('/product/add', 'ProductController@create', ['admin']);
$router->put('/product/edit/{id}', 'ProductController@update', ['admin']);
$router->delete('/product/delete/{id}', 'ProductController@delete', ['admin']);

$router->get('/cart', 'CartController@index', ['customer', 'guest']);
$router->post('/cart/add', 'CartController@add', ['customer', 'guest']);
$router->put('/cart/edit', 'CartController@edit', ['customer', 'guest']);
$router->delete('/cart/remove/{id}', 'CartController@delete', ['customer', 'guest']);
//$router->put('/product/edit/{id}', 'ProductController@update', ['admin']);
//$router->delete('/product/delete/{id}', 'ProductController@delete', ['admin']);

$router->get('/cart/checkout', 'CartController@checkout', ['customer', 'guest']);

$router->get('/login', 'UserController@login', ['guest']);
$router->get('/profile', 'UserController@index', ['customer', 'admin']);
$router->get('/register', 'UserController@register', ['guest']);

$router->post('/login', 'UserController@authenticate', ['guest']);
$router->post('/register', 'UserController@store', ['guest']);
$router->post('/logout', 'UserController@logout', ['customer', 'admin']);


$router->get('/404', 'ErrorController@notFound');