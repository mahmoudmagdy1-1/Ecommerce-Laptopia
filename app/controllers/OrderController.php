<?php

namespace App\controllers;

use App\models\OrderModel;
use App\models\ProductModel;
use App\models\PaymentModel;
use App\models\ShippingModel;
use App\models\CartModel;
use Core\Session;
use Core\Validation;
use Core\Flash;

class OrderController
{
    protected $orderModel;
    protected $cartModel;
    protected $productModel;
    protected $shippingModel;
    protected $paymentModel;
    protected $currentUser;

    public function __construct()
    {
        $this->orderModel = new OrderModel();
        $this->cartModel = new CartModel();
        $this->productModel = new ProductModel();
        $this->paymentModel = new PaymentModel();
        $this->shippingModel = new ShippingModel();
        $this->currentUser = Session::get('user');
    }

    public function index()
    {
        $orders = $this->orderModel->getOrdersByUserId($this->currentUser['id']);

        $orderData = array_map(function ($order) {
            $shipping = $this->shippingModel->getShippingByOrderId($order->order_id);
            $payment = $this->paymentModel->getPaymentByOrderId($order->order_id);
            $items = $this->orderModel->getOrderItems($order->order_id);

            $total = array_reduce($items, function ($carry, $item) {
                $product = $this->productModel->getProductByID(id: $item->product_id);
                return $carry + $product->price * $item->quantity;
            }, 0) + 20.00;

            return [
                'id' => $order->order_id,
                'date' => $order->created_at,
                'shipping_status' => $shipping->status ?? 'Pending',
                'payment_status' => $payment->status ?? 'Pending',
                'total' => $total
            ];
        }, $orders);

        loadView('orders/index', [
            'orders' => $orderData,
            'currentUser' => $this->currentUser
        ]);
    }

    //    public function show()
    //    {
    //        loadView('orders/show');
    //    }

    public function checkout()
    {
        $cartID = $this->cartModel->getCartID($this->currentUser['id']);
        $cartItems = $this->cartModel->getCartItems($cartID);
        if (!$cartItems) {
            redirect('/cart');
        }
        $products = [];
        foreach ($cartItems as $item) {
            $product = $this->productModel->getProductByID(id: $item->product_id);
            $product_price = round($product->price - ($product->price * ($product->discount / 100)), 2);
            $product_total = round($product_price * $item->quantity, 2);
            $products[] = [
                'name' => $product->name,
                'price' => $product_price,
                'quantity' => $item->quantity,
                'total' => $product_total
            ];
        }
        loadView(
            'checkout',
            [
                'products' => $products
            ]
        );
    }

    public function order()
    {
//                inspectAndDie($_POST);
        $requiredFields = [
            'address',
            'city',
            'state',
        ];
        $data = [];
        $errors = [];
        foreach ($_POST as $key => $value) {
            if (in_array($key, $requiredFields)) {
                $data[$key] = sanitize($value);
            }
        }
        if (isset($_POST['payment_method'])) {
            $data['payment_method'] = sanitize($_POST['payment_method']);
        }
        foreach ($requiredFields as $field) {
            if (!strlen($data[$field]) || !Validation::string($data[$field])) {
                $errors[] = $field . ' is required';
            }
        }
        if (!empty($errors)) {
            foreach ($errors as $message) {
                Flash::set(Flash::ERROR, $message);
            }
            redirect('/checkout');
        } else {
            $this->orderModel->makeOrder($this->currentUser['id']);
            $orderID = $this->orderModel->getLastOrderId($this->currentUser['id']);
            $cartID = $this->cartModel->getCartID($this->currentUser['id']);
            $cartItems = $this->cartModel->getCartItems($cartID);
            //            $cart = [];
            foreach ($cartItems as $item) {
                $cart = [
                    'order_id' => $orderID,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                ];
                //                inspect($cart);
                $this->orderModel->addOrderItem($cart);
            }
            //            inspectAndDie($cart);
            $this->paymentModel->makePayment(['order_id' => $orderID, 'method' => $data['payment_method']]);
            $this->shippingModel->addShipping(['order_id' => $orderID, 'address' => $data['address'], 'city' => $data['city'], 'state' => $data['state']]);
            $this->cartModel->clearCart($this->currentUser['id']);
            Flash::set(Flash::SUCCESS, 'Order placed successfully');
            redirect('/');
        }
    }

    public function show($params)
    {
        $orderID = $params['id'];
        $order = $this->orderModel->getOrderById($orderID);
        $errors = [];

        if (!$order || $order->user_id !== $this->currentUser['id']) {
            $errors[] = 'Order not found or you do not have permission to view this order';
        }

        if (!empty($errors)) {
            foreach ($errors as $error => $message) {
                Flash::set(Flash::ERROR, $message);
            }
            redirect('/orders');
        } else {
            $orderItems = $this->orderModel->getOrderItems($orderID);
            $shipping = $this->shippingModel->getShippingByOrderId($orderID);
            $payment = $this->paymentModel->getPaymentByOrderId($orderID);

            // Prepare products data for the view
            $products = [];
            foreach ($orderItems as $item) {
                $product = $this->productModel->getProductByID($item->product_id);
                $products[] = [
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $item->quantity,
                    'total' => $product->price * $item->quantity
                ];
            }

            loadView("orders/show", [
                'orderID' => $orderID,
                'orderDate' => $order->created_at,
                'products' => $products,
                'shipping' => $shipping,
                'payment' => $payment,
                'currentUser' => $this->currentUser,
                'shippingCost' => 20
            ]);
        }
    }
}
