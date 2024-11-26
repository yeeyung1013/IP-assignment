
<?php
//<!--SIASHUNFU-->
class ReviewCaretaker {

    private $mementoList = [];

    public function saveMemento(ReviewMemento $memento) {
        array_push($this->mementoList, $memento);
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $_SESSION["memento_list"] = $this->mementoList;  
    }

    public function getLastSavedMemento() {
        if (!empty($this->mementoList)) {
            return array_pop($this->mementoList);
        }
        return null;
    }

    public function getMemento($id) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        foreach ($this->mementoList as $key => $memento) {
             $state = json_decode($memento->getState());
            if ($state->id == $id) {
                unset($this->mementoList[$key]);

                $_SESSION["memento_list"] = $this->mementoList;
                return $memento;
            }
        }
    }
    
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
           session_start();
       }

        if (isset($_SESSION["memento_list"])) {
            $this->mementoList = $_SESSION["memento_list"];
        } else {
            $this->mementoList = [];  
        }
    }
}
