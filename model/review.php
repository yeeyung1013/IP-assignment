
<?php
//<!--SIASHUNFU-->
class Review {
    private $id;
    private $userName;
    private $userReview;
    private $userRating;
    private $userImage;
    private $datetime;
    private $status;
    private $archivedAt;
    private $adminReply;
    private $replyDatetime;
    private $userEmail;

    public function __construct(
        $id,
        $userName,
        $userReview,
        $userRating,
        $userImage = null,
        $datetime = null,
        $status = 'not read',
        $archivedAt = null,
        $adminReply = null,
        $replyDatetime = null,
        $userEmail = ''
    ) {
        $this->id = $id;
        $this->userName = $userName;
        $this->userReview = $userReview;
        $this->userRating = $userRating;
        $this->userImage = $userImage;
        $this->datetime = $datetime;
        $this->status = $status;
        $this->archivedAt = $archivedAt;
        $this->adminReply = $adminReply;
        $this->replyDatetime = $replyDatetime;
        $this->userEmail = $userEmail;
    }

    public function getId() {
        return $this->id;
    }

    public function getUserName() {
        return $this->userName;
    }

    public function setUserName($userName) {
        $this->userName = $userName;
    }

    public function getUserReview() {
        return $this->userReview;
    }

    public function setUserReview($userReview) {
        $this->userReview = $userReview;
    }

    public function getUserRating() {
        return $this->userRating;
    }

    public function setUserRating($userRating) {
        $this->userRating = $userRating;
    }

    public function getUserImage() {
        return $this->userImage;
    }

    public function setUserImage($userImage) {
        $this->userImage = $userImage;
    }

    public function getDatetime() {
        return $this->datetime;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function getArchivedAt() {
        return $this->archivedAt;
    }

    public function getAdminReply() {
        return $this->adminReply;
    }

    public function setAdminReply($adminReply) {
        $this->adminReply = $adminReply;
    }

    public function getReplyDatetime() {
        return $this->replyDatetime;
    }

    public function getUserEmail() {
        return $this->userEmail;
    }
}