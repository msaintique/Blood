<?php


function send_sms($phone_number, $message) {
    $url = "https://www.intouchsms.co.rw";
    $fields = array(
        'sender' => urlencode('+250780798099'),
        'recipients' => urlencode($phone_number),
        'message' => urlencode($message),
        'api_key' => '49131f101b9b7f413a60e73e335e5356370d56f6'
    );

    $fields_string = http_build_query($fields);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, count($fields));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $result = curl_exec($ch);
    curl_close($ch);
    
    return $result;
}
