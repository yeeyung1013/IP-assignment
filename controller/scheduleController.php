<?php
class ScheduleController {
    private $scheduleModel;

    public function __construct(Schedule $scheduleModel) {
        $this->scheduleModel = $scheduleModel;
    }

    public function createSchedule($scheduleId, $eventID, $startdate, $enddate, $time) {
        $this->scheduleModel->setSchedule($scheduleId, $eventID, $startdate, $enddate, $time);
        return $this->scheduleModel->saveSchedule();
    }

    public function updateSchedule($scheduleId, $eventID, $startdate, $enddate, $time) {
        $this->scheduleModel->setSchedule($scheduleId, $eventID, $startdate, $enddate, $time);
        return $this->scheduleModel->updateSchedule();
    }

    public function deleteSchedule($eventID) {
        return $this->scheduleModel->deleteSchedule($eventID);
    }
}
?>