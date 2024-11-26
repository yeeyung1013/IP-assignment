<?php

class MFAObserver implements SplObserver {

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Send OTP to the user via the Node.js API
    public function sendOTP($email) {
        $url = 'http://localhost:3000/send-otp';
        $data = ['email' => $email];

        $options = [
            'http' => [
                'header' => "Content-type: application/json\r\n",
                'method' => 'POST',
                'content' => json_encode($data),
            ],
        ];

        $context = stream_context_create($options);
        // Error handling for file_get_contents()
        $result = file_get_contents($url, false, $context);

        if ($result === false) {
            $error = error_get_last(); // Fetch the last error
            throw new Exception("HTTP request failed: " . $error['message']);
        }

        // Decode the JSON response
        return json_decode($result, true); // Return as an associative array
    }

    // Verify the OTP provided by the user via the Node.js API
    public function verifyOTP($email, $otp) {
        $url = 'http://localhost:3000/verify-otp';
        $data = json_encode(['email' => $email, 'otp' => $otp]); // Ensure correct JSON structure

        $options = [
            'http' => [
                'header' => "Content-type: application/json\r\n",
                'method' => 'POST',
                'content' => $data,
                'ignore_errors' => true, // This will allow us to get the response even on error
            ],
        ];

        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context); // Suppress warnings for better error handling

        if ($result === false) {
            $error = error_get_last(); // Get the last error
            throw new Exception("Failed to verify OTP: " . $error['message']);
        }

        // Check the HTTP response code
        $http_response_header = isset($http_response_header) ? $http_response_header : [];
        $status_line = explode(' ', $http_response_header[0]);
        $status_code = $status_line[1];

        // Log the HTTP status code for debugging
        error_log("HTTP Response Code: " . $status_code);

        // Parse the response
        $response = json_decode($result);

        // Log the response for debugging
        error_log("Response: " . print_r($response, true));

        // Ensure the response is well-formed
        if (isset($response->success) && isset($response->message)) {
            return $response; // Return the parsed response
        } else {
            throw new Exception("Unexpected response format.");
        }
        return json_decode($result, true); // Return as an associative array
    }

    public function update(\SplSubject $subject): void {
        
    }

}
?>
