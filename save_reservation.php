<?php

// ======================================================
// RESERVATION DATA
// ======================================================

$reservationID     = $reservationID ?? uniqid("RES-");
$name              = trim($name ?? "");
$phone             = trim($phone ?? "");
$email             = trim($email ?? "");
$date              = trim($date ?? "");
$time              = trim($time ?? "");
$guestsNumber      = trim($guestsNumber ?? "");
$occasion          = trim($occasion ?? "");
$message           = trim($message ?? "");
$paymentMethod     = trim($paymentMethod ?? "");
$paymentStatus     = trim($paymentStatus ?? "Pending");
$reservationStatus = trim($reservationStatus ?? "Confirmed");


// ======================================================
// GOOGLE SHEET WEB APP URL
// ======================================================

$googleSheetURL =
"https://script.google.com/macros/s/AKfycbzRqE9u-c5RuoGC7ZA2MWp2de4Decqymz5yH6AZRdSP6XlT7HQU5FCHrmeTLoliBB51/exec";


// ======================================================
// DATA TO GOOGLE SHEET
// ======================================================

$googleData = [

    "reservation_id"  => $reservationID,
    "name"            => $name,
    "phone"           => $phone,
    "email"           => $email,
    "date"            => $date,
    "time"            => $time,
    "guests"          => $guestsNumber,
    "occasion"        => $occasion,
    "message"         => $message,
    "payment_method"  => $paymentMethod,
    "payment_status"  => $paymentStatus,
    "reservation_status" => $reservationStatus

];


// ======================================================
// SEND DATA TO GOOGLE SHEET
// ======================================================

$ch = curl_init($googleSheetURL);

curl_setopt($ch, CURLOPT_POST, true);

curl_setopt(
    $ch,
    CURLOPT_POSTFIELDS,
    json_encode($googleData)
);

curl_setopt(
    $ch,
    CURLOPT_HTTPHEADER,
    [
        "Content-Type: application/json"
    ]
);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

curl_setopt($ch, CURLOPT_TIMEOUT, 20);


// ======================================================
// EXECUTE REQUEST
// ======================================================

$googleResponse = curl_exec($ch);

$curlError = curl_error($ch);

$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

curl_close($ch);


// ======================================================
// CHECK GOOGLE SHEET CONNECTION
// ======================================================

if ($googleResponse === false || !empty($curlError)) {

    die(
        "Reservation could not be saved. Please try again."
    );
}


// ======================================================
// CHECK RESPONSE
// ======================================================

$responseData = json_decode($googleResponse, true);

if (
    is_array($responseData) &&
    isset($responseData["success"]) &&
    $responseData["success"] === false
) {

    die(
        "Reservation could not be saved to Google Sheet."
    );
}


// ======================================================
// SUCCESS
// ======================================================

echo "Reservation saved successfully.";

?>