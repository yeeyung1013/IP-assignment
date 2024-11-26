<?php

require_once "PaymentInterface.php";

class PaypalAdapter implements PaymentInterface {

    private $paypalGateway;

    public function __construct(PaypalGateway $paypalGateway) {
        $this->paypalGateway = $paypalGateway;
    }

    public function processPayment($data): bool {
        return $this->paypalGateway->sendPayment($data);
    }

}