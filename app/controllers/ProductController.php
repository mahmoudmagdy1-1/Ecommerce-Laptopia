<?php

namespace App\controllers;

use Core\Database;
use Core\Validation;
use App\models\ProductModel;
use App\models\CategoryModel;

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

    public function show($params)
    {
        $product = $this->productModel->getProductByID($params["id"]);
        if (!$product) {
            ErrorController::notFound("Product not found");
        } else {
            loadView('products/show',
                [
                    'product' => $product,
                    'product_id' => $params["id"]
                ]
            );
        }
    }

    public function add($params)
    {
        $categories = (new CategoryModel())->getAllCategories();
        loadView('products/add',
            [
                'categories' => $categories
            ]);
    }

    public function edit($params)
    {
        $product = $this->productModel->getProductByID($params["id"]);
        $categories = (new CategoryModel())->getAllCategories();
        loadView('products/edit',
            [
                'product' => $product,
                'categories' => $categories,
                'product_id' => $params["id"]
            ]);
    }

    public function processProductData($params)
    {
        // If editing, use the product ID from the params, otherwise it's a new product
        $product_id = isset($params['id']) ? $params['id'] : null;

        // Define required fields
        $requiredFields = [
            'name',
            'description',
            'price',
            'discount',
            'quantity',
            'category'
        ];

        // Initialize data and errors arrays
        $data = [];
        $errors = [];
        $images = [];

        // Process POST data
        foreach ($_POST as $key => $value) {
            if (in_array($key, $requiredFields)) {
                $data[$key] = sanitize($value);
            }
        }

        // Validation checks for each required field
        foreach ($requiredFields as $field) {
            if (!strlen($data[$field]) || !Validation::string($data[$field])) {
                $errors[$field] = ucfirst($field) . ' is required';
            }
        }

        if (!Validation::intVal($data["price"], 1)) {
            $errors["price"] = "Price must be greater than 0";
        }
        if (!Validation::intVal($data["quantity"], 1)) {
            $errors["quantity"] = "Quantity must be greater than 0";
        }
        if (!Validation::intVal($data["discount"], 0, 100)) {
            $errors["discount"] = "Discount must be between 0 and 100";
        }
        if (!Validation::string($data["name"], 1, 100)) {
            $errors["name"] = "Name must be between 1 and 100 characters";
        }
        if (!Validation::string($data["description"], 1, 1000)) {
            $errors["description"] = "Description must be at most 1000 characters";
        }

        // Handle image uploads if there are any
        if (isset($_FILES["images"])) {
            $allowed_types = ['image/png', 'image/jpeg', 'image/jpg', 'image/webp'];
            foreach ($_FILES["images"]["error"] as $key => $error) {
                if ($error == UPLOAD_ERR_OK) {
                    $tmp_name = $_FILES["images"]["tmp_name"][$key];
                    $name = $_FILES["images"]["name"][$key];
                    $type = $_FILES["images"]["type"][$key];
                    if (in_array($type, $allowed_types)) {
                        $images[] = $name;
                        move_uploaded_file($tmp_name, basePath("public/assets/img/product/$name"));
                    } else {
                        $errors["image"] = "Only png, jpeg and webp images are allowed";
                    }
                }
            }
        } else {
            // If no images were uploaded, it's required for new products
            if ($product_id === null) {
                $errors["image"] = "At least 1 image is required";
            }
        }

        return [
            'data' => $data,
            'errors' => $errors,
            'images' => $images
        ];
    }


    public function create($params)
    {
        // Call the shared method to process the product data
        $result = $this->processProductData($params);
        $data = $result['data'];
        $errors = $result['errors'];
        $images = $result['images'];

        // If there are errors, show the form again with error messages
        if (!empty($errors)) {
            loadView('products/add', [
                'errors' => $errors,
                'data' => $data
            ]);
        } else {
            // Create the product and associate the images
            $this->productModel->createProduct($data, $images);
            $new_id = $this->productModel->getLastProductId();

            // Add images to the product
            foreach ($images as $image) {
                $this->productModel->addProductImage([
                    'product_id' => $new_id,
                    'image_url' => $image,
                    'alt_text' => $data["name"]
                ]);
            }

            // Redirect to the newly created product page
            header("Location: /product/$new_id");
        }
    }


    public function update($params)
    {
        $product_id = $params['id'];

        // Fetch the existing product data by ID
        $product = $this->productModel->getProductById($product_id);

        // If product doesn't exist, return an error (optional)
        if (!$product) {
            ErrorController::notFound("Product not found");
        }

        // Call the shared method to process the product data
        $result = $this->processProductData(['id' => $product_id]);
        $data = $result['data'];
        $errors = $result['errors'];
        $images = $result['images'];

        // If there are errors, show the form again with error messages
        if (!empty($errors)) {
            loadView('products/edit', [
                'errors' => $errors,
                'data' => $data,
                'product' => $product
            ]);
        } else {
            // Update the product with the new data
            $this->productModel->updateProduct($product_id, $data);

            // Handle image updates (if new images were uploaded)
            if (!empty($images)) {
                // Delete old images or handle image update logic
                $this->productModel->deleteProductImages($product_id);

                // Add the new images
                foreach ($images as $image) {
                    $this->productModel->addProductImage([
                        'product_id' => $product_id,
                        'image_url' => $image,
                        'alt_text' => $data["name"]
                    ]);
                }
            }

            // Redirect to the updated product page
            header("Location: /product/$product_id");
        }
    }

    public function delete($params)
    {
        $product_id = $params['id'];

        $this->productModel->deleteProductImages($product_id);
        $this->productModel->deleteProduct($product_id);

        header("Location: /products");
    }
}