<?php

namespace App\models;

use Core\Database;

class ShippingModel
{
    public function __construct()
    {
        $config = require basePath('config/_db.php');
        $this->db = Database::getInstance($config)->getConnection();
    }

    public function addShipping($data)
    {
        $query = 'INSERT INTO Shipping (order_id, address, city, state) VALUES (:order_id, :address, :city, :state)';
        $this->db->query($query, $data);
    }

    public function getShippingByOrderId($orderID)
    {
        $query = 'SELECT * FROM Shipping WHERE order_id = :order_id';
        return $this->db->query($query, ['order_id' => $orderID])->fetch();
    }

    public function updateShippingStatus($data)
    {
        $query = 'UPDATE Shipping SET status = :status WHERE order_id = :order_id';
        return $this->db->query($query, $data)->rowCount() > 0;
    }

}