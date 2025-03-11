<?php

$router->get('/', 'HomeController@index');


$router->get('/products/', 'ProductController@index');
$router->get('/products/{id}', 'ProductController@index');

$router->get('/product/add', 'ProductController@add', ['admin']);
$router->get('/product/edit/{id}', 'ProductController@edit', ['admin']);
$router->get('/product/{id}', 'ProductController@show');

$router->post('/product/add', 'ProductController@create', ['admin']);
$router->put('/product/edit/{id}', 'ProductController@update', ['admin']);

$router->get('/cart', 'CartController@index', ['customer', 'guest']);
$router->post('/cart/add', 'CartController@add', ['customer', 'guest']);
$router->put('/cart/edit', 'CartController@edit', ['customer', 'guest']);
$router->delete('/cart/remove/{id}', 'CartController@delete', ['customer', 'guest']);

$router->get('/checkout', 'OrderController@checkout', ['customer']);
$router->post('/checkout/order', 'OrderController@order', ['customer']);

$router->get('/orders', 'OrderController@index', ['customer']);
$router->get('/order/{id}', 'OrderController@show', ['customer']);

$router->get('/login', 'UserController@login', ['guest']);
$router->get('/profile', 'UserController@index', ['customer', 'admin']);
$router->get('/register', 'UserController@register', ['guest']);

$router->post('/login', 'UserController@authenticate', ['guest']);
$router->post('/register', 'UserController@store', ['guest']);
$router->post('/logout', 'UserController@logout', ['customer', 'admin']);

// Admin Routes
$router->get('/admin', 'AdminController@dashboard', ['admin']);
$router->get('/admin/dashboard', 'AdminController@dashboard', ['admin']);

// Admin Users Management
$router->get('/admin/users', 'AdminController@users', ['admin']);
$router->get('/admin/users/{id}', 'AdminController@userDetails', ['admin']);
$router->post('/admin/users/delete/{id}', 'AdminController@deleteUser', ['admin']);

// Admin Products Management
$router->get('/admin/products', 'AdminController@products', ['admin']);
$router->get('/admin/products/add', 'AdminController@addProduct', ['admin']);
$router->post('/admin/products/add', 'AdminController@createProduct', ['admin']);
//$router->get('/admin/products/edit/{id}', 'AdminController@editProduct', ['admin']);
//$router->post('/admin/products/edit/{id}', 'AdminController@updateProduct', ['admin']);
//$router->delete('/admin/products/delete/{id}', 'AdminController@deleteProduct', ['admin']);

// Admin Orders Management
$router->get('/admin/orders', 'AdminController@orders', ['admin']);
$router->get('/admin/orders/{id}', 'AdminController@orderDetails', ['admin']);
$router->post('/admin/orders/{id}/status', 'AdminController@updateOrderStatus', ['admin']);

// Admin Categories Management
$router->get('/admin/categories', 'AdminController@categories', ['admin']);
$router->get('/admin/categories/add', 'AdminController@addCategory', ['admin']);
$router->post('/admin/categories/add', 'AdminController@createCategory', ['admin']);
$router->get('/admin/categories/edit/{id}', 'AdminController@editCategory', ['admin']);
$router->post('/admin/categories/edit/{id}', 'AdminController@updateCategory', ['admin']);
$router->delete('/admin/categories/delete/{id}', 'AdminController@deleteCategory', ['admin']);

$router->get('/404', 'ErrorController@notFound');
