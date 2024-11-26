<?php

class PaymentTicket
{
    private $paymentTicketId;
    private $paymentId;
    private $ticketId;
    private $quantity;
    private $db;

    public function __construct($paymentId, $ticketId, $quantity)
    {
        $this->db = new databaseSecurity();
        $this->paymentId = $paymentId;
        $this->ticketId = $ticketId;
        $this->quantity = $quantity;
    }

    public function storePaymentTicketToDatabase()
    {
        $data = [
            'payment_id' => $this->paymentId,
            'ticket_id' => $this->ticketId,
            'quantity' => $this->quantity
        ];
        $table = "payment_ticket";
        
        try {
            $results = $this->db->insert($table, $data);
            $this->db->close();
            $this->paymentTicketId = $results;
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function getPaymentTicketFromDatabase($id) {
        try {
            $results = $this->db->query("SELECT * FROM payment_ticket WHERE payment_id = :payment_id", ["payment_id" => $id]);
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

    public function getTicketId()
    {
        return $this->ticketId;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }
}