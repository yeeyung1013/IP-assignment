<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 * @author Tan Chee Fung
 */
require '../../model/TicketFactory.php';

class TicketController {

    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function create($data) {
        $ticket = TicketFactory::createTicket(null, $data['price'], $data['schedule_id'], $data['image'], $data['slot'], $data['slot_sold'], $data['category']);
        $stmt = $this->pdo->prepare("INSERT INTO ticket (price, schedule_id, image, slot, slot_sold, category) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$ticket->getPrice(), $ticket->getScheduleId(), $ticket->getImage(), $ticket->getSlot(), $ticket->getSlotSold(), $ticket->getCategory()]);
    }

    public function listTickets($schedule_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM ticket WHERE schedule_id = ?");
        $stmt->execute([$schedule_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function read($ticket_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM ticket WHERE ticket_id = ?");
        $stmt->execute([$ticket_id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return new Ticket($row['ticket_id'], $row['price'], $row['schedule_id'], $row['image'], $row['slot'], $row['slot_sold'], $row['category']);
    }

    public function update($data) {
        $ticket = new Ticket($data['ticket_id'], $data['price'], $data['schedule_id'], $data['image'], $data['slot'], $data['slot_sold'], $data['category']);
        $stmt = $this->pdo->prepare("UPDATE ticket SET price = ?, image = ?, slot = ?, slot_sold = ?, category = ? WHERE ticket_id = ?");
        $stmt->execute([$ticket->getPrice(), $ticket->getImage(), $ticket->getSlot(), $ticket->getSlotSold(), $ticket->getCategory(), $ticket->getTicketId()]);
    }

    public function delete($ticket_id) {
        $stmt = $this->pdo->prepare("DELETE FROM ticket WHERE ticket_id = ?");
        $stmt->execute([$ticket_id]);
    }

    public function getUsedSlots($schedule_id) {
        $stmt = $this->pdo->prepare("SELECT SUM(slot) as total_slots FROM ticket WHERE schedule_id = :schedule_id");
        $stmt->execute(['schedule_id' => $schedule_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_slots'] ? $result['total_slots'] : 0;
    }

    public function getEventSeats($schedule_id) {
        $stmt = $this->pdo->prepare("SELECT seat FROM villain WHERE EventID = (SELECT EventID FROM schedule WHERE schedule_id = :schedule_id)");
        $stmt->execute(['schedule_id' => $schedule_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['seat'] ? $result['seat'] : 0;
    }
    
}
?>