<?php

namespace App\controllers;

use App\models\UserModel;
use App\models\ProductModel;
use App\models\OrderModel;
use App\models\CategoryModel;
use Core\Session;
use Core\Flash;
use Core\Validation;

class AdminController
{
    protected $userModel;
    protected $productModel;
    protected $orderModel;
    protected $categoryModel;
    protected $currentAdmin;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->productModel = new ProductModel();
        $this->orderModel = new OrderModel();
        $this->categoryModel = new CategoryModel();

        $this->currentAdmin = Session::get('user');
        // inspectAndDie($this->currentAdmin);
        // Ensure only admins can access these pages
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

    public function deleteUser($params)
    {
        $userId = $params['id'];
        if ($this->userModel->deleteUser($userId)) {
            Flash::set(Flash::SUCCESS, 'User deleted successfully');
            redirect('/admin/users');
        } else {
            Flash::set(Flash::ERROR, 'Failed to delete user');
            redirect('/admin/users');
        }
    }

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

        // Handle image upload
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

    public function deleteProduct($params)
    {
        $product_id = $params['id'];
        if(!$this->productModel->getProductById($product_id)){
            Flash::set(Flash::ERROR, 'Product not found');
            redirect('/admin/products');
        }
        else {
            $this->productModel->deleteProduct($product_id);
            $this->productModel->deleteProductImages($product_id);
            Flash::set(Flash::SUCCESS, 'Product deleted successfully');
            redirect('/admin/products');
        }
    }


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
        $status = $_POST['status'] ?? '';

        if (empty($status)) {
            Flash::set(Flash::ERROR, 'Status is required');
            redirect("/admin/orders/{$orderId}");
        }

        $success = $this->orderModel->updateOrderStatus($orderId, $status);

        if ($success) {
            Flash::set(Flash::SUCCESS, 'Order status updated successfully');
        } else {
            Flash::set(Flash::ERROR, 'Failed to update order status');
        }

        redirect("/admin/orders/{$orderId}");
    }

    // Categories Management
    public function categories()
    {
        $categories = $this->categoryModel->getAllCategories();

        loadView('admin/categories', [
            'categories' => $categories,
            'currentAdmin' => $this->currentAdmin
        ]);
    }

    public function addCategory()
    {
        loadView('categories/add-category', [
            'currentAdmin' => $this->currentAdmin
        ]);
    }

    public function createCategory()
    {
        $name = sanitize($_POST['name'] ?? '');

        if (empty($name)) {
            Flash::set(Flash::ERROR, 'Category name is required');
            redirect('/admin/categories/add');
        }

        $categoryId = $this->categoryModel->createCategory(['name' => $name]);

        if ($categoryId) {
            Flash::set(Flash::SUCCESS, 'Category added successfully');
            redirect('/admin/categories');
        } else {
            Flash::set(Flash::ERROR, 'Failed to add category');
            redirect('/admin/categories/add');
        }
    }

    public function editCategory($params)
    {
        $categoryId = $params['id'];
        $category = $this->categoryModel->getCategoryById($categoryId);

        if (!$category) {
            Flash::set(Flash::ERROR, 'Category not found');
            redirect('/categories/categories');
        }

        loadView('categories/edit-category', [
            'category' => $category,
            'currentAdmin' => $this->currentAdmin
        ]);
    }

    public function updateCategory($params)
    {
        $categoryId = $params['id'];
        $name = sanitize($_POST['name'] ?? '');

        if (empty($name)) {
            Flash::set(Flash::ERROR, 'Category name is required');
            redirect("/admin/categories/edit/{$categoryId}");
        }

        $success = $this->categoryModel->updateCategory($categoryId, ['name' => $name]);

        if ($success) {
            Flash::set(Flash::SUCCESS, 'Category updated successfully');
            redirect('/admin/categories');
        } else {
            Flash::set(Flash::ERROR, 'Failed to update category');
            redirect("/admin/categories/edit/{$categoryId}");
        }
    }

    public function deleteCategory($params)
    {
        $categoryId = $params['id'];
        $success = $this->categoryModel->deleteCategory($categoryId);

        if ($success) {
            Flash::set(Flash::SUCCESS, 'Category deleted successfully');
        } else {
            Flash::set(Flash::ERROR, 'Failed to delete category');
        }

        redirect('/admin/categories');
    }
}
