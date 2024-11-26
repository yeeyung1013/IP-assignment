<?php

require __DIR__ . '/../vendor/autoload.php';


class paypalGateway {

    private $apiContext;

    public function __construct() {
        $client_id = "AVtHKFoiJimhOaSSm4BLEL7hHRdmkMNxVbCqbzqMfu30I-q2O3gPNcT3ocB0J5aq__zQaqkJOIJ8GYR-";
        $client_secret = "EOlekKwIOEI_kF5Kxoy3XMRfuHc5hHeHDiBGj4zQfvdUrsiMfBtuah7tytOyyne47o458lmaGnxvM9VJ";

        $this->apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential($client_id, $client_secret)
        );

        $this->apiContext->setConfig(array('mode' => 'sandbox'));
    }

    public function sendPayment($data): bool {
        $return_url = "http://localhost/villain/view/payment_successfull.php";
        $cancel_url = "http://localhost/villain/view/index.php";
        $currency = "MYR";
        $amount = $data->getAmount();

        $payer = new \PayPal\Api\Payer();
        $payer->setPaymentMethod("paypal");

        $amountObj = new \PayPal\Api\Amount();
        $amountObj->setCurrency($currency)
                  ->setTotal($amount);

        $transaction = new \PayPal\Api\Transaction();
        $transaction->setAmount($amountObj)
                    ->setDescription("Payment through PayPal");

        $redirectUrls = new \PayPal\Api\RedirectUrls();
        $redirectUrls->setReturnUrl($return_url)
                     ->setCancelUrl($cancel_url);

        $payment = new \PayPal\Api\Payment();
        $payment->setIntent("sale")
                ->setPayer($payer)
                ->setTransactions(array($transaction))
                ->setRedirectUrls($redirectUrls);

        try {
            $payment->create($this->apiContext);

            // Get the approval link and redirect the user
            $approvalUrl = $payment->getApprovalLink();
            
            // Redirect to PayPal's payment page, similar to Stripe's 303 redirect
            http_response_code(303);
            header("Location: " . $approvalUrl);

        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            echo "An error occurred: " . $ex->getData();
            return false;
        }

        return true;
    }
}