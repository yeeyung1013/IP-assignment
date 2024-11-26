<?php
require __DIR__ . '/../vendor/autoload.php';

class StripeGateway {

    public function charge($data): bool {

        $stripe_secret_key = "sk_test_51PlJygGkK3e2gOOIYqYg0vFROE8UtYo2NCrWkGRvWLe3MT4JLI1le87enXyaL2IrenkJW3kRISeh1dyZYrsmid0o00p80DuOgR";
        $success_page = "http://localhost/villain/view/payment_successfull.php";
        $cancel_page = "http://localhost/villain/view/index.php";

        \Stripe\Stripe::setApiKey($stripe_secret_key);

        $checkout_session = \Stripe\Checkout\Session::create([
            "mode" => "payment",
            "success_url" => $success_page,
            "cancel_url" => $cancel_page,
            'line_items' => [[
                "quantity" => $data->getQuantity(),
                'price_data' => [
                    "currency" => "myr",
                    "unit_amount" => $this->convertAmount($data->getAmount()),
                    'product_data' => [
                      'name' => "Total Amount",
                ],
              ],
            ]],
          ]);

          // Direct to Stripe payment page
          http_response_code(303);
          header("Location: " . $checkout_session->url);

        return true;
    }

    public function convertAmount(float $amount): float {
      return $amount * 100;
    }
}