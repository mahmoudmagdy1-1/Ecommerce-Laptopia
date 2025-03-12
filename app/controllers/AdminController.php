<?php

namespace App\controllers;

use App\models\UserModel;
use App\models\ProductModel;
use App\models\OrderModel;
use App\models\CategoryModel;
use App\models\ShippingModel;
use App\models\PaymentModel;
use Core\Session;
use Core\Flash;

class AdminController
{
    protected $userModel;
    protected $productModel;
    protected $orderModel;
    protected $categoryModel;
    protected $currentAdmin;
    protected $shippingModel;
    protected $paymentModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->productModel = new ProductModel();
        $this->orderModel = new OrderModel();
        $this->categoryModel = new CategoryModel();
        $this->shippingModel = new ShippingModel();
        $this->paymentModel = new PaymentModel();
        $this->currentAdmin = Session::get('user');
        if ($this->currentAdmin['role'] !== 'admin') {
            redirect('/login');
        }
    }

    // Dashboard
    public function dashboard()
    {
        $totalUsers = $this->userModel->getTotalUsers();
        $totalProducts = $this->productModel->getTotalProducts();
        $totalOrders = $this->orderModel->getTotalOrders();
        $recentOrders = $this->orderModel->getRecentOrders(5);

        loadView('admin/dashboard', [
            'totalUsers' => $totalUsers,
            'totalProducts' => $totalProducts,
            'totalOrders' => $totalOrders,
            'recentOrders' => $recentOrders,
            'currentAdmin' => $this->currentAdmin
        ]);
    }

    // Users Management
    public function users()
    {
        $users = $this->userModel->getAllUsers();

        loadView('admin/users', [
            'users' => $users,
            'currentAdmin' => $this->currentAdmin
        ]);
    }

    public function userDetails($params)
    {
        $userId = $params['id'];
        $user = $this->userModel->getUserById($userId);
        $userOrders = $this->orderModel->getOrdersByUserId($userId);

        if (!$user) {
            Flash::set(Flash::ERROR, 'User not found');
            redirect('/admin/users');
        }

        loadView('admin/user-details', [
            'user' => $user,
            'userOrders' => $userOrders,
            'currentAdmin' => $this->currentAdmin
        ]);
    }

//    public function deleteUser($params)
//    {
//        $userId = $params['id'];
//        if ($this->userModel->deleteUser($userId)) {
//            Flash::set(Flash::SUCCESS, 'User deleted successfully');
//            redirect('/admin/users');
//        } else {
//            Flash::set(Flash::ERROR, 'Failed to delete user');
//            redirect('/admin/users');
//        }
//    }

    // Products Management
    public function products()
    {
        $products = $this->productModel->getAllProducts();
        $categories = $this->categoryModel->getAllCategories();

        loadView('admin/products', [
            'products' => $products,
            'categories' => $categories,
            'currentAdmin' => $this->currentAdmin
        ]);
    }

    public function addProduct()
    {
        $categories = $this->categoryModel->getAllCategories();

        loadView('admin/add-product', [
            'categories' => $categories,
            'currentAdmin' => $this->currentAdmin
        ]);
    }

    public function createProduct()
    {
        $requiredFields = ['name', 'price', 'quantity', 'category_id', 'description'];
        $data = [];
        $errors = [];

        foreach ($_POST as $key => $value) {
            if (in_array($key, $requiredFields)) {
                $data[$key] = sanitize($value);
            }
        }

        // Validate fields
        if (empty($data['name'])) {
            $errors['name'] = 'Product name is required';
        }

        if (empty($data['price']) || !is_numeric($data['price'])) {
            $errors['price'] = 'Valid price is required';
        }

        if (empty($data['quantity']) || !is_numeric($data['quantity'])) {
            $errors['quantity'] = 'Valid quantity is required';
        }

        if (empty($data['category_id'])) {
            $errors['category_id'] = 'Category is required';
        }

        if (empty($data['description'])) {
            $errors['description'] = 'Description is required';
        }

        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'public/assets/img/products/';
            $fileName = time() . '_' . basename($_FILES['image']['name']);
            $uploadPath = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                $data['image'] = $fileName;
            } else {
                $errors['image'] = 'Failed to upload image';
            }
        } else {
            $errors['image'] = 'Product image is required';
        }

        if (!empty($errors)) {
            foreach ($errors as $field => $message) {
                Flash::set(Flash::ERROR, $message);
            }
            redirect('/admin/products/add');
        } else {
            $productId = $this->productModel->createProduct($data);

            if ($productId) {
                Flash::set(Flash::SUCCESS, 'Product added successfully');
                redirect('/admin/products');
            } else {
                Flash::set(Flash::ERROR, 'Failed to add product');
                redirect('/admin/products/add');
            }
        }
    }

    public function editProduct($params)
    {
        $productId = $params['id'];
        $product = $this->productModel->getProductById($productId);
        $categories = $this->categoryModel->getAllCategories();

        if (!$product) {
            Flash::set(Flash::ERROR, 'Product not found');
            redirect('/admin/products');
        }

        loadView('admin/edit-product', [
            'product' => $product,
            'categories' => $categories,
            'currentAdmin' => $this->currentAdmin
        ]);
    }

    public function updateProduct($params)
    {
        $productId = $params['id'];
        $requiredFields = ['name', 'price', 'quantity', 'category_id', 'description'];
        $data = [];
        $errors = [];

        foreach ($_POST as $key => $value) {
            if (in_array($key, $requiredFields)) {
                $data[$key] = sanitize($value);
            }
        }

        // Validate fields
        if (empty($data['name'])) {
            $errors['name'] = 'Product name is required';
        }

        if (empty($data['price']) || !is_numeric($data['price'])) {
            $errors['price'] = 'Valid price is required';
        }

        if (empty($data['quantity']) || !is_numeric($data['quantity'])) {
            $errors['quantity'] = 'Valid quantity is required';
        }

        if (empty($data['category_id'])) {
            $errors['category_id'] = 'Category is required';
        }

        if (empty($data['description'])) {
            $errors['description'] = 'Description is required';
        }

        // Handle image upload if a new image is provided
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'public/assets/img/products/';
            $fileName = time() . '_' . basename($_FILES['image']['name']);
            $uploadPath = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                $data['image'] = $fileName;
            } else {
                $errors['image'] = 'Failed to upload image';
            }
        }

        if (!empty($errors)) {
            foreach ($errors as $field => $message) {
                Flash::set(Flash::ERROR, $message);
            }
            redirect("/admin/products/edit/{$productId}");
        } else {
            $success = $this->productModel->updateProduct($productId, $data);

            if ($success) {
                Flash::set(Flash::SUCCESS, 'Product updated successfully');
                redirect('/admin/products');
            } else {
                Flash::set(Flash::ERROR, 'Failed to update product');
                redirect("/admin/products/edit/{$productId}");
            }
        }
    }

//    public function deleteProduct($params)
//    {
//        $product_id = $params['id'];
//        if (!$this->productModel->getProductById($product_id)) {
//            Flash::set(Flash::ERROR, 'Product not found');
//            redirect('/admin/products');
//        } else {
//            $this->productModel->deleteProduct($product_id);
//            $this->productModel->deleteProductImages($product_id);
//            Flash::set(Flash::SUCCESS, 'Product deleted successfully');
//            redirect('/admin/products');
//        }
//    }


    // Orders Management
    public function orders()
    {
        $orders = $this->orderModel->getAllOrders();

        loadView('admin/orders', [
            'orders' => $orders,
            'currentAdmin' => $this->currentAdmin
        ]);
    }

    public function orderDetails($params)
    {
        $orderId = $params['id'];
        $order = $this->orderModel->getOrderById($orderId);
        $orderItems = $this->orderModel->getOrderItems($orderId);
        $shipping = $this->orderModel->getShippingByOrderId($orderId);
        $payment = $this->orderModel->getPaymentByOrderId($orderId);
        $user = $this->userModel->getUserById($order->user_id);
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
        if (!$order) {
            Flash::set(Flash::ERROR, 'Order not found');
            redirect('/admin/orders');
        }

        loadView('admin/order-details', [
            'order' => $order,
            'products' => $products,
            'orderItems' => $orderItems,
            'shipping' => $shipping,
            'payment' => $payment,
            'user' => $user,
            'currentAdmin' => $this->currentAdmin
        ]);
    }

    public function updateOrderStatus($params)
    {
        $orderId = $params['id'];
        $shipping_status = $_POST['shipping_status'] ?? '';
        $payment_status = $_POST['payment_status'] ?? '';

        $validShippingStatuses = ['Pending', 'Shipped', 'Delivered', 'Returned', 'Cancelled'];
        $validPaymentStatuses = ['Pending', 'Success', 'Failed'];

        if ($shipping_status && in_array($shipping_status, $validShippingStatuses)) {
            $this->shippingModel->updateShippingStatus(['order_id' => $orderId, 'status' => $shipping_status]);
            Flash::set(Flash::SUCCESS, 'Shipping status updated successfully');
        } elseif ($payment_status && in_array($payment_status, $validPaymentStatuses)) {
            $this->paymentModel->updateStatus(['order_id' => $orderId, 'status' => $payment_status]);
            Flash::set(Flash::SUCCESS, 'Payment status updated successfully');
        } else {
            Flash::set(Flash::ERROR, 'Invalid status');
        }

        redirect("/admin/orders/{$orderId}");
    }


}
