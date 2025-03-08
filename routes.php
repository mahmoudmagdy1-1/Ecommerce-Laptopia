<?php

$router->get('/', 'HomeController@index');


$router->get('/products/', 'ProductController@index');
$router->get('/products/{id}', 'ProductController@index');

$router->get('/product/add', 'ProductController@add');
$router->get('/product/edit/{id}', 'ProductController@edit');
$router->get('/product/{id}', 'ProductController@show');

$router->post('/product/add', 'ProductController@create');
$router->put('/product/edit/{id}', 'ProductController@update');
$router->delete('/product/delete/{id}', 'ProductController@delete');

$router->get('/404', 'ErrorController@notFound');
