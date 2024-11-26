<?php

require_once "PaymentInterface.php";

class StripeAdapter implements PaymentInterface {

    private $stripeGateway;

    public function __construct(StripeGateway $stripeGateway) {
        $this->stripeGateway = $stripeGateway;
    }
    
    public function processPayment($data): bool {
        return $this->stripeGateway->charge($data);
    }

}