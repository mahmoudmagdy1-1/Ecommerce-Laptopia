<?php

namespace App\models;

use Core\Database;

class CartModel
{
    public function __construct()
    {
        $config = require basePath('config/db.php');
        $this->db = Database::getInstance($config)->getConnection();
    }


}