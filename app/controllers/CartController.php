<?php

namespace App\controllers;

use App\models\ProductModel;
use App\models\CartModel;
use Core\Session;
use Core\Validation;
use Core\Flash;

class CartController
{
    protected $cartModel;
    protected $productModel;
    protected $currentUser;

    public function __construct()
    {
        $this->cartModel = new CartModel();
        $this->productModel = new ProductModel();
        $this->currentUser = Session::get('user') ?? null;
    }

    public function index()
    {
        if ($this->currentUser) {
            $cartID = $this->cartModel->getCartID($this->currentUser['id']);
            $cartObjects = $this->cartModel->getCartItems($cartID);
            $cart = [];
            foreach ($cartObjects as $item) {
                $cart[] = [
                    "product_id" => $item->product_id,
                    "quantity" => $item->quantity
                ];
            }
        } else {
            $cart = Session::get('cart') ?? [];
        }

        $products = [];
        foreach ($cart as $item) {
            $products[$item['product_id']] = $this->productModel->getProductById($item['product_id']);
        }
//        inspectAndDie($cart);
        loadView("cart", [
            'products' => $products,
            'cart' => $cart
        ]);
    }

    public function add()
    {
        // Gather and sanitize required fields from POST.
        $requiredFields = ['product_id', 'quantity'];
        $data = [];
        foreach ($requiredFields as $field) {
            $data[$field] = isset($_POST[$field]) ? sanitize($_POST[$field]) : null;
        }

        // Validate the input.
        $errors = [];
        if (!Validation::intVal($data['quantity'], 1, 100)) {
            $errors[] = 'Quantity must be at least 1 and at most 100';
        }
        if (!$this->productModel->getProductById($data['product_id'])) {
            $errors[] = 'Product not found';
        }
        if (!empty($errors)) {
            foreach ($errors as $message) {
                Flash::set(Flash::ERROR, $message);
            }
            redirect("/product/{$data['product_id']}");
        } else {
            // Update session cart.
            $cart = Session::get('cart') ?? [];
            $product_exists = false;
            // Loop by reference so that changes update the array.
            foreach ($cart as &$item) {
                if ($item['product_id'] == $data["product_id"]) {
                    $item['quantity'] = (int)$item['quantity'] + (int)$data["quantity"];
                    $product_exists = true;
                    break;
                }
            }
            unset($item);
            if (!$product_exists) {
                $cart[] = [
                    'product_id' => $data["product_id"],
                    'quantity' => $data["quantity"]
                ];
            }

            Session::set('cart', $cart);

            if ($this->currentUser) {
                $this->cartModel->mergeCart($this->currentUser['id']);
            }
            Flash::set(Flash::SUCCESS, 'Product added to cart');
            redirect('/product/' . $data['product_id']);
        }
    }

    public function delete($params)
    {
        $product_id = $params['id'];

        // Remove item from session cart.
        $cart = Session::get('cart') ?? [];
        foreach ($cart as $key => $item) {
            if ($item['product_id'] == $product_id) {
                unset($cart[$key]);
            }
        }
        Session::set('cart', $cart);

        // If the user is logged in, remove from the database as well.
        if ($this->currentUser) {
            $this->cartModel->deleteFromCart([
                'user_id' => $this->currentUser['id'],
                'product_id' => $product_id
            ]);
        }

        Flash::set(Flash::SUCCESS, 'Product removed from cart');
        redirect('/cart');
    }

    public function edit()
    {
// Gather and sanitize required fields from POST.
        $requiredFields = ['product_id', 'quantity'];
        $data = [];
//        inspectAndDie(Session::get('cart'));
        foreach ($requiredFields as $field) {
            $data[$field] = isset($_POST[$field]) ? sanitize($_POST[$field]) : null;
        }

        // Validate the input.
        $errors = [];
        if (!Validation::intVal($data['quantity'], 1, 100)) {
            $errors[] = 'Quantity must be at least 1 and at most 100';
        }
        if (!$this->productModel->getProductById($data['product_id'])) {
            $errors[] = 'Product not found';
        }
        if (!empty($errors)) {
            foreach ($errors as $message) {
                Flash::set(Flash::ERROR, $message);
            }
            redirect("/cart");
        } else {
            // Update session cart.
            $cart = Session::get('cart') ?? [];
            // Loop by reference so that changes update the array.
            foreach ($cart as &$item) {
                if ($item['product_id'] == $data["product_id"]) {
                    $item['quantity'] = (int)$data["quantity"];
                }
            }
            unset($item);
            Session::set('cart', $cart);

            if ($this->currentUser) {
                $cartId = $this->cartModel->getCartID($this->currentUser['id']);
                $this->cartModel->editFromCart([
                    'user_id' => $this->currentUser['id'],
                    'product_id' => $data['product_id'],
                    'quantity' => $data['quantity']
                ]);
//                $this->cartModel->mergeCart($this->currentUser['id']);
            }
            Flash::set(Flash::SUCCESS, 'Product quantity updated');
            redirect('/cart');
        }
    }
}
