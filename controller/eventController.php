<?php
class EventController {
    private $eventModel;
    private $notificationStrategy;

    public function __construct(Event $eventModel, NotificationStrategy $strategy = null) {
        $this->eventModel = $eventModel;
        $this->notificationStrategy = $strategy;
    }

    public function createEvent($eventID, $eventName,$location, $description, $startDate, $seat) {
        $this->eventModel->setEvent($eventID, $eventName,$location, $description, $startDate, $seat);
        
        if ($this->eventModel->eventAlreadyCreated()) {
            return false;
        }

        if ($this->eventModel->createEvent() && $this->notificationStrategy) {
            $message = "A new event has been created: " . $eventName;
            $this->notificationStrategy->sendNotification($message);
        }

        return true;
    }

    public function updateEvent($eventID, $eventName,$location, $description, $startDate, $seat) {
        $this->eventModel->setEvent($eventID, $eventName,$location, $description, $startDate, $seat);
        return $this->eventModel->updateEvent();
    }

    public function deleteEvent($eventID) {
        return $this->eventModel->deleteEvent($eventID);
    }

    public function getEventDetails($eventID) {
        return $this->eventModel->getEventById($eventID);
    }
}
?>