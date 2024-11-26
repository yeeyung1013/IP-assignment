<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 * @author Tan Chee Fung
 */

require_once 'Ticket.php';
class VIPTicket extends Ticket {
    public function __construct($ticket_id, $price, $schedule_id, $image, $slot, $slot_sold) {
        parent::__construct($ticket_id, $price, $schedule_id, $image, $slot, $slot_sold, "VIP");
    }
}
?>