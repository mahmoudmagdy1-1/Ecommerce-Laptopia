<?php

namespace App\controllers;

use Core\Database;
use App\models\ProductModel;

class ProductController
{
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
    public function index($params)
    {
        $this->productModel->getAllProductsCount();
        extract($params);
        $product_count = $this->productModel->getAllProductsCount();
        $products_per_page = 9;
        $max_page_count = ceil($product_count / $products_per_page);
        if (!isset($id)) {
            $id = 1;
        }
        $products = $this->productModel->getProductsPage($id, $products_per_page);
        if (!$products) {
            ErrorController::notFound("Products not found");
        } else {
            loadView('products/index',
                [
                    'products' => $products,
                    'id' => $id,
                    "last_page" => $max_page_count
                ]
            );
        }
    }

    /**
     * Show the products details
     *
     * @param int $id
     * @return void
     */
    public function show($params)
    {
        $product = $this->productModel->getProductByID($params["id"]);
        if (!$product) {
            ErrorController::notFound("Product not found");
        } else {
            loadView('products/show',
                [
                    'product' => $product
                ]
            );
        }
    }


}