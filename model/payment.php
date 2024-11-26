<?php
require_once "../SecurePractice/databaseSecurity.php";

class Payment {
    
    private $paymentId;
    private $cust_id;
    private $quantity;
    private $date;
    private $paymentMethod;
    private $amount;
    private $db;

    public function __construct($cust_id, $quantity, $paymentMethod, $amount)
    {
        $this->db = new databaseSecurity();
        $this->cust_id = $cust_id;
        $this->quantity = $quantity;
        $this->date = date('Y-m-d');
        $this->paymentMethod = $paymentMethod;
        $this->amount = $amount;
    }

    public function storePaymentToDatabase()
    {
        $data = [
            'cust_id' => $this->cust_id,
            'quantity' => $this->quantity,
            'date' => $this->date,
            'method' => $this->paymentMethod,
            'amount' => $this->amount 
        ];
        $table = "payment";
        
        try {
            $results = $this->db->insert($table, $data);
            $this->db->close();
            $this->paymentId = $results;
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function getPaymentFromDatabase($id) {
        try {
            $results = $this->db->query("SELECT * FROM payment WHERE payment_id = :payment_id", ["payment_id" => $id]);
            if ($results) {
                return $results;
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function getAllPaymentFromDatabase() {
        try {
            $results = $this->db->query("SELECT * FROM payment", []);
            if ($results) {
                return $results;
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function getPaymentId()
    {
        return $this->paymentId;
    }

    public function getCustId()
    {
        return $this->cust_id;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function getPaymentdate()
    {
        return $this->date;
    }
}

