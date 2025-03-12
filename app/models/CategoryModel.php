<?php

namespace App\models;

use Core\Database;

class CategoryModel
{
    protected $db;

    public function __construct()
    {
        $config = require basePath('config/_db.php');
        $this->db = Database::getInstance($config)->getConnection();
    }

    public function getAllCategories()
    {
        $query = 'SELECT * FROM Categories ORDER BY name ASC';
        return $this->db->query($query)->fetchAll();
    }

    public function getCategoryById($categoryId)
    {
        $query = 'SELECT * FROM Categories WHERE category_id = :category_id';
        return $this->db->query($query, ['category_id' => $categoryId])->fetch();
    }

    public function createCategory($data)
    {
        $query = 'INSERT INTO Categories (name) VALUES (:name)';
        $this->db->query($query, ['name' => $data['name']]);
        return $this->db->lastInsertId();
    }

    public function updateCategory($categoryId, $data)
    {
        $query = 'UPDATE Categories SET name = :name WHERE category_id = :category_id';
        $params = [
            'name' => $data['name'],
            'category_id' => $categoryId
        ];
        return $this->db->query($query, $params)->rowCount() > 0;
    }

//    public function deleteCategory($categoryId)
//    {
//        $checkQuery = 'SELECT COUNT(*) as count FROM Products WHERE category_id = :category_id';
//        $result = $this->db->query($checkQuery, ['category_id' => $categoryId])->fetch();
//
//        if ($result->count > 0) {
//            return false;
//        }
//
//        $query = 'DELETE FROM Categories WHERE category_id = :category_id';
//        return $this->db->query($query, ['category_id' => $categoryId])->rowCount() > 0;
//    }
}
