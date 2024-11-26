<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 * @author Tan Chee Fung
 */

require_once 'StandardTicket.php';
require_once 'VIPTicket.php';
require_once 'VVIPTicket.php';
require_once 'SuperVIPTicket.php';
class TicketFactory {
    public static function createTicket($ticket_id, $price, $schedule_id, $image, $slot, $slot_sold, $category) {
        switch ($category) {
            case 'Standard':
                return new StandardTicket($ticket_id, $price, $schedule_id, $image, $slot, $slot_sold);
            case 'VIP':
                return new VIPTicket($ticket_id, $price, $schedule_id, $image, $slot, $slot_sold);
            case 'VVIP':
                return new VVIPTicket($ticket_id, $price, $schedule_id, $image, $slot, $slot_sold);
            case 'SuperVIP':
                return new SuperVIPTicket($ticket_id, $price, $schedule_id, $image, $slot, $slot_sold);
            default:
                throw new Exception("Invalid ticket category");
        }
    }
}
?>