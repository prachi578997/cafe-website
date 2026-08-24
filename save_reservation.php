<?php

// ======================================================
// RESERVATION STORAGE
// ======================================================

// First try PHP temporary directory
$dataFolder = sys_get_temp_dir() . DIRECTORY_SEPARATOR . "veloure_data";

// Create folder if needed
if (!is_dir($dataFolder)) {
    @mkdir($dataFolder, 0777, true);
}

// If folder is not writable, use /tmp
if (!is_dir($dataFolder) || !is_writable($dataFolder)) {

    $dataFolder = "/tmp/veloure_data";

    if (!is_dir($dataFolder)) {
        @mkdir($dataFolder, 0777, true);
    }
}


// ======================================================
// FINAL STORAGE CHECK
// ======================================================

if (!is_dir($dataFolder)) {
    die("Reservation storage folder could not be created.");
}

if (!is_writable($dataFolder)) {
    die("Reservation storage is not writable. Please try again.");
}


// ======================================================
// CSV FILE
// ======================================================

$file = $dataFolder . DIRECTORY_SEPARATOR . "reservation.csv";


// ======================================================
// CHECK NEW FILE
// ======================================================

$isNewFile = !file_exists($file) || filesize($file) === 0;


// ======================================================
// OPEN CSV FILE
// ======================================================

$handle = @fopen($file, "a");


// ======================================================
// CHECK FILE OPEN
// ======================================================

if ($handle === false) {

    die(
        "Reservation could not be saved. Please try again."
    );
}


// ======================================================
// LOCK FILE
// ======================================================

if (!flock($handle, LOCK_EX)) {

    fclose($handle);

    die(
        "Reservation could not be saved. Please try again."
    );
}


// ======================================================
// CSV HEADER
// ======================================================

if ($isNewFile) {

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

    if (fputcsv($handle, $header) === false) {

        flock($handle, LOCK_UN);
        fclose($handle);

        die(
            "Unable to create reservation file."
        );
    }
}


// ======================================================
// SAVE RESERVATION DATA
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


$success = fputcsv(
    $handle,
    $reservationData
);


// ======================================================
// UNLOCK FILE
// ======================================================

flock($handle, LOCK_UN);


// ======================================================
// CLOSE FILE
// ======================================================

fclose($handle);


// ======================================================
// CHECK CSV SAVE
// ======================================================

if ($success === false) {

    die(
        "Reservation could not be saved. Please try again."
    );
}


// ======================================================
// GOOGLE SHEET CONNECTION
// ======================================================

$googleSheetURL = "https://script.google.com/macros/s/AKfycbzRqE9u-c5RuoGC7ZA2MWp2de4Decqymz5yH6AZRdSP6XlT7HQU5FCHrmeTLoliBB51/exec";


$googleData = [

    "name" => $name,

    "phone" => $phone,

    "date" => $date,

    "time" => $time,

    "guests" => $guestsNumber,

    "payment_method" => $paymentMethod,

    "payment_status" => $paymentStatus

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

curl_setopt($ch, CURLOPT_TIMEOUT, 15);


// ======================================================
// EXECUTE GOOGLE SHEET REQUEST
// ======================================================

$googleResponse = curl_exec($ch);


// ======================================================
// CLOSE CURL
// ======================================================

curl_close($ch);


// ======================================================
// RESERVATION SAVED SUCCESSFULLY
// ======================================================

echo "Reservation saved successfully.";

?>