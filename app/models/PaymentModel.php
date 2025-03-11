<?php

namespace App\models;

use Core\Database;

class PaymentModel
{
    public function __construct()
    {
        $config = require basePath('config/db.php');
        $this->db = Database::getInstance($config)->getConnection();
    }

    public function makePayment($data)
    {
        $query = 'INSERT INTO Payments (order_id, method) VALUES (:order_id, :method)';
        $this->db->query($query, $data);
    }

    public function getPaymentByOrderId($orderID)
    {
        $query = 'SELECT * FROM Payments WHERE order_id = :order_id';
        return $this->db->query($query, ['order_id' => $orderID])->fetch();
    }
}