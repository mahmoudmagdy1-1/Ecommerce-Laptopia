<?php

namespace App\controllers;

use App\models\ProductModel;
use App\models\CartModel;
use Core\Session;
use Core\Validation;
use Core\Flash;


class CartController
{
    protected $cartModel = '';
    protected $productModel = '';
    public function __construct()
    {
        $cartModel = new CartModel();
        $productModel = new ProductModel();
    }

//    public function index()
//    {
//        $products = ProductModel::all();
//        return view('cart.index', compact('products'));
//    }

    public function add(){
        $requiredFields = [
            'product_id',
            'quantity'
        ];
        foreach($_POST as $key => $value){
            if(in_array($key, $requiredFields)){
                $data[$key] = sanitize($value);
            }
        }
        $errors = [];
        if(!Validation::intVal($data['quantity'], 1)){
            $errors[] = 'Quantity must be at least 1';
        }
        inspectAndDie($productModel);
//        if(!$productModel->getProductById($data['product_id'])){
//
//        }
//        $product_id = $_POST['product_id'];
//        $cart = new CartModel();
//        $cart->addProduct($product_id);
//        Flash::success('Product added to cart');
//        redirect('/cart');
    }
}

