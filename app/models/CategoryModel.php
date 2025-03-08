<?php

namespace App\models;

use Core\Database;

class CategoryModel
{

    public function __construct()
    {
        $config = require basePath('config/db.php');
        $this->db = Database::getInstance($config)->getConnection();
    }

    public function getAllCategories()
    {
        return $this->db->query('SELECT * FROM Categories')->fetchAll();
    }
}