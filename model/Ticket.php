<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

/**
 * 
 *
 * @author Tan Chee Fung
 */

class Ticket {
    private $ticket_id;
    private $price;
    private $schedule_id;
    private $image;
    private $slot;
    private $slot_sold;
    private $category;

    public function __construct($ticket_id, $price, $schedule_id, $image, $slot, $slot_sold, $category) {
        $this->ticket_id = $ticket_id;
        $this->price = $price;
        $this->schedule_id = $schedule_id;
        $this->image = $image;
        $this->slot = $slot;
        $this->slot_sold = $slot_sold;
        $this->category = $category;
    }

    public function getTicketId() {
        return $this->ticket_id;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getScheduleId() {
        return $this->schedule_id;
    }

    public function getImage() {
        return $this->image;
    }

    public function getSlot() {
        return $this->slot;
    }

    public function getSlotSold() {
        return $this->slot_sold;
    }

    public function getCategory() {
        return $this->category;
    }
    
    public function setPrice($price) {
        $this->price = $price;
    }

    public function setImage($image) {
        $this->image = $image;
    }

    public function setSlot($slot) {
        $this->slot = $slot;
    }

    public function setSlotSold($slot_sold) {
        $this->slot_sold = $slot_sold;
    }

    public function setCategory($category) {
        $this->category = $category;
    }
}
?>