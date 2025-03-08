<?php

Namespace App\controllers;

use Core\Database;
use App\models\ProductModel;

Class HomeController{
    protected $db;
    protected $productModel;

    public function __construct()
    {
//        $config = require basePath('config/db.php');
//        $this->db = Database::getInstance($config)->getConnection();
        $this->productModel = new ProductModel();
    }

    /**
     * Show the latest listings
     *
     * @return void
     */
    public function index()
    {
        $products = $this->productModel->getHomeProducts();
        loadView('home', [
            'products' => $products
        ]);
    }
}