<?php

// ======================================================
// RESERVATION DATA
// ======================================================

$reservationID     = $reservationID ?? uniqid("RES-");
$name              = $name ?? "";
$phone             = $phone ?? "";
$email             = $email ?? "";
$date              = $date ?? "";
$time              = $time ?? "";
$guestsNumber      = $guestsNumber ?? "";
$occasion          = $occasion ?? "";
$message           = $message ?? "";
$paymentMethod     = $paymentMethod ?? "";
$paymentStatus     = $paymentStatus ?? "Pending";
$reservationStatus = $reservationStatus ?? "Confirmed";


// ======================================================
// CSV FILE - SAME WEBSITE FOLDER
// ======================================================

$file = __DIR__ . DIRECTORY_SEPARATOR . "reservation.csv";


// ======================================================
// OPEN CSV
// ======================================================

$handle = @fopen($file, "a");

if ($handle === false) {

    die(
        "Unable to save reservation. Please check folder permission."
    );
}


// ======================================================
// LOCK FILE
// ======================================================

if (!flock($handle, LOCK_EX)) {

    fclose($handle);

    die(
        "Unable to save reservation. Please try again."
    );
}


// ======================================================
// CSV HEADER
// ======================================================

if (filesize($file) === 0) {

    $header = [
        "Reservation ID",
        "Saved Date & Time",
        "Customer Name",
        "Mobile Number",
        "Email",
        "Reservation Date",
        "Reservation Time",
        "Guests",
        "Occasion",
        "Special Request",
        "Payment Method",
        "Payment Status",
        "Reservation Status"
    ];

    fputcsv($handle, $header);
}


// ======================================================
// RESERVATION DATA
// ======================================================

$reservationData = [

    $reservationID,
    date("Y-m-d H:i:s"),
    $name,
    $phone,
    $email,
    $date,
    $time,
    $guestsNumber,
    $occasion,
    $message,
    $paymentMethod,
    $paymentStatus,
    $reservationStatus

];


// ======================================================
// SAVE CSV
// ======================================================

$success = fputcsv($handle, $reservationData);


// ======================================================
// UNLOCK + CLOSE
// ======================================================

flock($handle, LOCK_UN);
fclose($handle);


// ======================================================
// CHECK CSV
// ======================================================

if ($success === false) {

    die(
        "Reservation could not be saved. Please try again."
    );
}


// ======================================================
// GOOGLE SHEET
// ======================================================

$googleSheetURL =
"https://script.google.com/macros/s/AKfycbzRqE9u-c5RuoGC7ZA2MWp2de4Decqymz5yH6AZRdSP6XlT7HQU5FCHrmeTLoliBB51/exec";


$googleData = [

    "name" => $name,
    "phone" => $phone,
    "date" => $date,
    "time" => $time,
    "guests" => $guestsNumber,
    "payment_method" => $paymentMethod,
    "payment_status" => $paymentStatus

];


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
curl_setopt($ch, CURLOPT_TIMEOUT, 15);

$googleResponse = curl_exec($ch);

curl_close($ch);


// ======================================================
// SUCCESS
// ======================================================

echo "Reservation saved successfully.";

?>