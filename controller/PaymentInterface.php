<?php
interface PaymentInterface
{
    public function processPayment($data): bool;
}
