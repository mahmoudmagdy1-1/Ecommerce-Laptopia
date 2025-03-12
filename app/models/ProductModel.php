<?php

namespace App\models;

use Core\Database;

class ProductModel
{
    protected $db;

    public function __construct()
    {
        $config = require basePath('config/_db.php');
        $this->db = Database::getInstance($config)->getConnection();
    }

    private function fetchProducts(int $limit, int $offset = 0): array
    {
        $query = '
        SELECT 
            p.product_id,
            p.name,
            p.price,
            p.discount_percentage AS discount,
            c.name AS category,
            GROUP_CONCAT(pi.image_url ORDER BY pi.product_image_id DESC) AS images,
            GROUP_CONCAT(pi.alt_text ORDER BY pi.product_image_id DESC) AS images_alt
        FROM Products p
        LEFT JOIN ProductImages pi ON p.product_id = pi.product_id
        LEFT JOIN Categories c ON p.category_id = c.category_id
        GROUP BY p.product_id
        ORDER BY p.created_at DESC
        LIMIT :limit
        OFFSET :offset
    ';
        return $this->db->query($query, [
            'limit' => $limit,
            'offset' => $offset
        ])->fetchAll();
    }

    public function getHomeProducts(int $limit = 3): array
    {
        return $this->fetchProducts($limit, 0);
    }

    public function getProductsPage(int $page, int $perPage): array
    {
        $offset = ($page - 1) * $perPage;
        return $this->fetchProducts($perPage, $offset);
    }

    public function getProductByID($id)
    {
        $query = '
        SELECT 
            p.product_id,
            p.name,
            p.price,
            p.discount_percentage AS discount,
            p.description,
            p.quantity,
            c.name AS category,
            GROUP_CONCAT(pi.image_url ORDER BY pi.product_image_id DESC) AS images,
            GROUP_CONCAT(pi.alt_text ORDER BY pi.product_image_id DESC) AS images_alt
        FROM Products p
        LEFT JOIN ProductImages pi ON p.product_id = pi.product_id
        LEFT JOIN Categories c ON p.category_id = c.category_id
        WHERE p.product_id = :product_id
        GROUP BY p.product_id';
        return $this->db->query($query, [
            'product_id' => $id
        ])->fetch();
    }

    public function getAllProductsCount()
    {
        return $this->db->query('SELECT COUNT(*) AS count FROM Products')->fetch()->count;
    }

    public function getLastProductId()
    {
        return $this->db->query('SELECT MAX(product_id) AS last_id FROM Products')->fetch()->last_id;
    }

    public function createProduct($data)
    {
        $query = 'INSERT INTO Products (name, description, price, discount_percentage, quantity, category_id) VALUES (:name, :description, :price, :discount, :quantity, :category)';
        $this->db->query($query, $data);
        return $this->getLastProductId();
    }

    public function updateProduct($data)
    {
        $query = 'UPDATE Products SET name = :name, description = :description, price = :price, discount_percentage = :discount, quantity = :quantity, category_id = :category WHERE product_id = :product_id';
        $this->db->query($query, $data);
    }

    public function addProductImage($images)
    {
        $query = 'INSERT INTO ProductImages (product_id, image_url, alt_text) VALUES (:product_id, :image_url, :alt_text)';
        $this->db->query($query, $images);
    }

    public function deleteProductImages($product_id)
    {
        $query = 'DELETE FROM ProductImages WHERE product_id = :product_id';
        $this->db->query($query, ['product_id' => $product_id]);
    }

    public function deleteProduct($product_id)
    {
        // First delete related images
        $this->deleteProductImages($product_id);

        // Then delete the product
        $query = 'DELETE FROM Products WHERE product_id = :product_id';
        return $this->db->query($query, ['product_id' => $product_id])->rowCount() > 0;
    }

    public function getAllProducts()
    {
        $query = '
        SELECT 
            p.product_id,
            p.name,
            p.price,
            p.discount_percentage AS discount,
            p.quantity,
            c.name AS category,
            (SELECT pi.image_url FROM ProductImages pi WHERE pi.product_id = p.product_id ORDER BY pi.product_image_id DESC LIMIT 1) AS image
        FROM Products p
        LEFT JOIN Categories c ON p.category_id = c.category_id
        ORDER BY p.created_at DESC';

        return $this->db->query($query)->fetchAll();
    }

    public function getTotalProducts()
    {
        $query = 'SELECT COUNT(*) as count FROM Products';
        return $this->db->query($query)->fetch()->count;
    }
}
