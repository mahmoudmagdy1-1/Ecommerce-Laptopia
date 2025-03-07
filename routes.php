<?php

$router->get('/', 'HomeController@index');
//$router->get('/products/{id}', 'ProductController@index');
$router->get('/products/{category}/{id}', 'ProductController@index');
$router->get('/products/', 'ProductController@index');
$router->get('/products/{id}', 'ProductController@index');
$router->get('/product/edit/{id}', 'HomeController@products');
$router->get('/product/{id}', 'ProductController@show');
$router->get('/404', 'ErrorController@notFound');
