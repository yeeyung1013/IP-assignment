<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 * @author Tan Chee Fung
 */
include '../view/admin/databaseconnect.php';
class QRCode {
    function generateQRCode($ticket_id) {
        $curl = curl_init();
        $formatted_ticket_id = "TICKET-" . $ticket_id;
        $query_params = [
            'data' => $formatted_ticket_id,
            'size' => 50,
            'margin' => 10,
            'label' => 'Ticket ID',
            'label_size' => 5,
            'label_alignment' => 'center',
            'foreground_color' => '007BFF',
            'background_color' => 'FFFFFF',
        ];
        $api_url = "https://qr-code-generator20.p.rapidapi.com/generateadvancebase64?" . http_build_query($query_params);

        curl_setopt_array($curl, [
            CURLOPT_URL => $api_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "x-rapidapi-host: qr-code-generator20.p.rapidapi.com",
                "x-rapidapi-key: 77e319a6bemsha61ae59ff1a564bp107776jsn66f02c660b2d"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo '<img src="data:image/png;base64,' . $response . '" alt="QR Code for ' . $formatted_ticket_id . '" />';
        }
    }

}
