<?php

namespace App\controllers;

use Core\Validation;
use Core\Flash;
use App\models\ProductModel;
use App\models\CategoryModel;

class ProductController
{
    protected $productModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
    }

    public function index($params)
    {
        extract($params);
        $product_count = $this->productModel->getAllProductsCount();
        $products_per_page = 9;
        $max_page_count = ceil($product_count / $products_per_page);
        if (!isset($id)) {
            $id = 1;
        }
        if ($id > $max_page_count) {
            ErrorController::notFound("Page not found");
        } else {
            $products = $this->productModel->getProductsPage($id, $products_per_page);
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
        $product_id = isset($params['id']) ?? $params['id'];

        $requiredFields = [
            'name',
            'description',
            'price',
            'discount',
            'quantity',
            'category'
        ];

        $data = [];
        $errors = [];
        $images = [];

        foreach ($_POST as $key => $value) {
            if (in_array($key, $requiredFields)) {
                $data[$key] = sanitize($value);
            }
        }

        foreach ($requiredFields as $field) {
            if (!strlen($data[$field]) || !Validation::string($data[$field])) {
                $errors[$field] = ucfirst($field) . ' is required';
            }
        }

        if (!Validation::intVal($data["price"], 1)) {
            $errors["price"] = "Price is required and must be greater than 0";
        }
        if (!Validation::intVal($data["quantity"], 1)) {
            $errors["quantity"] = "Quantity must be greater than 0";
        }
        if (!Validation::intVal($data["discount"], 0, 100)) {
            $errors["discount"] = "Discount must be between 0 and 100";
        }
        if (!Validation::string($data["name"], 0, 100)) {
            $errors["name"] = "Name must be between 1 and 100 characters";
        }
        if (!Validation::string($data["description"], 0, 1000)) {
            Flash::set(Flash::ERROR, "Description must be at most 1000 characters");
        }

        if (count(array_filter($_FILES["images"]["name"])) > 0) {
            $allowed_types = ['image/png', 'image/jpeg', 'image/jpg', 'image/webp'];
            foreach ($_FILES["images"]["error"] as $key => $error) {
                if ($error == UPLOAD_ERR_OK) {
                    $tmp_name = $_FILES["images"]["tmp_name"][$key];
                    $name = $_FILES["images"]["name"][$key];
                    $type = $_FILES["images"]["type"][$key];
                    if (in_array($type, $allowed_types)) {
                        $images[] = $name;
                        inspectAndDie(move_uploaded_file($tmp_name, basePath("public/assets/img/product/$name")));

                    } else {
                        $errors["image"] = "Only png, jpeg and webp images are allowed";
                    }
                }
            }
        } else {
            if (!$product_id) {
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
        $result = $this->processProductData($params);
        $data = $result['data'];
        $errors = $result['errors'];
        $images = $result['images'];
        if (!empty($errors)) {
            foreach ($errors as $error => $message) {
                Flash::set(Flash::ERROR, $message);
            }
            redirect("/product/add");
        } else {
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

            redirect("/product/$new_id");
        }
    }


    public function update($params)
    {
        $product_id = $params['id'];
        $product = $this->productModel->getProductById($product_id);

        if (!$product) {
            ErrorController::notFound("Product not found");
        }

        $result = $this->processProductData(['id' => $product_id]);
        $data = $result['data'];
        $errors = $result['errors'];
        $images = $result['images'];

        if (!empty($errors)) {
            loadView('products/edit', [
                'errors' => $errors,
                'data' => $data,
                'product' => $product
            ]);
        } else {
            $data['product_id'] =  $product_id;
            $this->productModel->updateProduct($data);
            if (!empty($images)) {
                $this->productModel->deleteProductImages($product_id);

                foreach ($images as $image) {
                    $this->productModel->addProductImage([
                        'product_id' => $product_id,
                        'image_url' => $image,
                        'alt_text' => $data["name"]
                    ]);
                }
            }

            redirect("/product/$product_id");
        }
    }
}