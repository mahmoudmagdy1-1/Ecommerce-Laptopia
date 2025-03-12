<?php

Namespace App\controllers;

use App\models\ProductModel;

Class HomeController{
    protected $productModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
    }

    public function index()
    {
        $products = $this->productModel->getHomeProducts();
        loadView('home', [
            'products' => $products
        ]);
    }
}