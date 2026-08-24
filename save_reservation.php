<?php

// ======================================================
// VELOURE CAFE - SAVE RESERVATION
// ======================================================

date_default_timezone_set("Asia/Kolkata");

// ------------------------------------------------------
// Only POST request allowed
// ------------------------------------------------------

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Invalid request.");
}


// ------------------------------------------------------
// Get form data
// ------------------------------------------------------

$name = trim($_POST["name"] ?? "");
$phone = trim($_POST["phone"] ?? "");
$email = trim($_POST["email"] ?? "");
$date = trim($_POST["date"] ?? "");
$time = trim($_POST["time"] ?? "");
$guests = trim($_POST["guests"] ?? "");
$occasion = trim($_POST["occasion"] ?? "");
$message = trim($_POST["message"] ?? "");


// ------------------------------------------------------
// Validation
// ------------------------------------------------------

if (
    $name === "" ||
    $phone === "" ||
    $date === "" ||
    $time === "" ||
    $guests === ""
) {
    die("Please fill all required details.");
}


if (!preg_match("/^[0-9]{10}$/", $phone)) {
    die("Please enter a valid 10 digit mobile number.");
}


if (!filter_var($email, FILTER_VALIDATE_EMAIL) && $email !== "") {
    die("Please enter a valid email address.");
}


// ------------------------------------------------------
// Guests validation
// ------------------------------------------------------

$guestsNumber = intval($guests);

if ($guestsNumber < 1 || $guestsNumber > 10) {
    die("Invalid number of guests.");
}


// ------------------------------------------------------
// Date validation
// ------------------------------------------------------

$today = date("Y-m-d");

if ($date < $today) {
    die("Please select today or a future date.");
}


// ------------------------------------------------------
// CSV FILE PATH
// ------------------------------------------------------

// reservation.csv will be created in the same folder
// as save_reservation.php

$file = __DIR__ . "/reservation.csv";


// ------------------------------------------------------
// Create CSV file if it does not exist
// ------------------------------------------------------

$isNewFile = !file_exists($file) || filesize($file) === 0;


// ------------------------------------------------------
// Open CSV file
// ------------------------------------------------------

$handle = fopen($file, "a");


if ($handle === false) {

    die(
        "Unable to save reservation. Please check folder permission."
    );
}


// ------------------------------------------------------
// Lock file before writing
// ------------------------------------------------------

if (!flock($handle, LOCK_EX)) {

    fclose($handle);

    die(
        "Unable to save reservation. Please try again."
    );
}


// ------------------------------------------------------
// CSV HEADER
// ------------------------------------------------------

if ($isNewFile) {

    fputcsv($handle, [
        "Reservation ID",
        "Date & Time",
        "Customer Name",
        "Mobile Number",
        "Email",
        "Reservation Date",
        "Reservation Time",
        "Guests",
        "Occasion",
        "Special Request",
        "Status"
    ]);
}


// ------------------------------------------------------
// Reservation ID
// ------------------------------------------------------

$reservationID =
    "VR-" .
    date("YmdHis") .
    "-" .
    rand(100, 999);


// ------------------------------------------------------
// Save reservation
// ------------------------------------------------------

fputcsv($handle, [

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

    "Confirmed"

]);


// ------------------------------------------------------
// Unlock + Close
// ------------------------------------------------------

flock($handle, LOCK_UN);

fclose($handle);


// ------------------------------------------------------
// SUCCESS PAGE
// ------------------------------------------------------

?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1.0"
>

<title>
Reservation Confirmed | VELOURE Café
</title>

<link
href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=DM+Sans:wght@400;500;600;700&display=swap"
rel="stylesheet"
>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{

    min-height:100vh;

    display:flex;

    align-items:center;

    justify-content:center;

    padding:20px;

    background:#f6f1e8;

    color:#35251d;

    font-family:"DM Sans",sans-serif;

}

.success-box{

    width:100%;

    max-width:650px;

    background:#fff;

    padding:55px 40px;

    border-radius:25px;

    text-align:center;

    box-shadow:
        0 25px 70px
        rgba(53,37,29,.15);

}

.success-icon{

    width:80px;

    height:80px;

    margin:0 auto 20px;

    display:flex;

    align-items:center;

    justify-content:center;

    border-radius:50%;

    background:#e7f5e7;

    color:#287a32;

    font-size:40px;

}

.success-box h1{

    font-family:"Cormorant Garamond",serif;

    font-size:50px;

    margin-bottom:10px;

}

.success-box h1 span{

    color:#a47b4c;

}

.success-box p{

    color:#75665b;

    line-height:1.7;

    font-size:14px;

}

.booking-id{

    margin:25px 0;

    padding:18px;

    background:#f7f1e9;

    border-radius:12px;

}

.booking-id small{

    display:block;

    color:#8a7768;

    font-size:11px;

    letter-spacing:2px;

    margin-bottom:5px;

}

.booking-id strong{

    font-size:20px;

    color:#a47b4c;

}

.details{

    margin:20px 0;

    text-align:left;

    border-top:1px solid #eadfd3;

}

.detail-row{

    display:flex;

    justify-content:space-between;

    gap:20px;

    padding:12px 0;

    border-bottom:1px solid #eadfd3;

    font-size:13px;

}

.detail-row span{

    color:#806f61;

}

.detail-row strong{

    text-align:right;

}

.home-btn{

    display:inline-block;

    margin-top:25px;

    padding:13px 25px;

    border-radius:30px;

    background:#35251d;

    color:#fff;

    text-decoration:none;

    font-weight:600;

    font-size:13px;

}

.home-btn:hover{

    background:#a47b4c;

}

</style>

</head>

<body>


<div class="success-box">


    <div class="success-icon">
        ✓
    </div>


    <h1>
        Reservation <span>Confirmed!</span>
    </h1>


    <p>
        Thank you, <?php echo htmlspecialchars($name); ?>.
        Your table has been successfully reserved at
        VELOURE Café.
    </p>


    <div class="booking-id">

        <small>
            RESERVATION ID
        </small>

        <strong>
            <?php echo htmlspecialchars($reservationID); ?>
        </strong>

    </div>


    <div class="details">


        <div class="detail-row">

            <span>
                Reservation Date
            </span>

            <strong>
                <?php echo htmlspecialchars($date); ?>
            </strong>

        </div>


        <div class="detail-row">

            <span>
                Reservation Time
            </span>

            <strong>
                <?php echo htmlspecialchars($time); ?>
            </strong>

        </div>


        <div class="detail-row">

            <span>
                Guests
            </span>

            <strong>
                <?php echo htmlspecialchars($guestsNumber); ?>
            </strong>

        </div>


        <?php if ($occasion !== ""): ?>

        <div class="detail-row">

            <span>
                Occasion
            </span>

            <strong>
                <?php echo htmlspecialchars($occasion); ?>
            </strong>

        </div>

        <?php endif; ?>


    </div>


    <p>
        Your reservation information has been saved successfully.
    </p>


    <a
        href="menu.php"
        class="home-btn"
    >
        ← Back to Menu
    </a>


    <a
        href="index.php"
        class="home-btn"
        style="margin-left:8px;"
    >
        Home
    </a>


</div>


</body>

</html>