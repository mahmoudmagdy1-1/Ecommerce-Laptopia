<?php

namespace App\models;

use Core\Database;

class ProductModel
{
    protected $db;

    public function __construct()
    {
        $config = require '../config/db.php';
        $this->db = Database::getInstance($config)->getConnection();
    }

//    public function getProductsPaginated(int $page = 1, int $limit = 10): array
//    {
//        $offset = ($page - 1) * $limit;
//        $query = 'SELECT * FROM Products ORDER BY created_at DESC LIMIT :limit OFFSET :offset';
//        $products = $this->db->query( $query,
//        [
//            'limit' => $limit,
//            'offset' => $offset
//        ]
//        )->fetchAll();
//        return $products;
//    }
//
//    public function getHomeProducts(int $limit = 3): array
//    {
//        $query = '
//        SELECT
//            p.product_id,
//            p.name,
//            p.price,
//            c.name AS category,
//            GROUP_CONCAT(pi.image_url) AS images
//        FROM Products p
//        LEFT JOIN ProductImages pi ON p.product_id = pi.product_id
//        LEFT JOIN Categories c ON p.category_id = c.category_id
//        GROUP BY p.product_id
//        ORDER BY p.created_at DESC
//        LIMIT :limit
//        ';
//        $products = $this->db->query($query,
//            [
//                'limit' => $limit
//            ]
//        )->fetchAll();
//        inspectAndDie($products);
//        return $products;
//    }


    private function fetchProducts(int $limit, int $offset = 0): array
    {
        $query = '
        SELECT 
            p.product_id,
            p.name,
            p.price,
            p.discount_percentage AS discount,
            c.name AS category,
            GROUP_CONCAT(pi.image_url) AS images,
            GROUP_CONCAT(pi.alt_text) AS images_alt
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
            p.name,
            p.price,
            p.discount_percentage AS discount,
            p.description,
            p.quantity,
            c.name AS category,
            GROUP_CONCAT(pi.image_url) AS images,
            GROUP_CONCAT(pi.alt_text) AS images_alt
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
}