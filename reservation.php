<?php

// ======================================================
// VELOURE CAFE - RESERVATION SYSTEM
// GOOGLE SHEET STORAGE
// ======================================================

date_default_timezone_set("Asia/Kolkata");

$today = date("Y-m-d");

$success = false;
$error = "";

$reservation_id = "";
$name = "";
$phone = "";
$email = "";
$date = "";
$time = "";
$guests = "";
$occasion = "";
$special_request = "";
$payment_method = "";
$payment_status = "Pending";

$reservation_fee = 100;


// ======================================================
// GOOGLE SHEET WEB APP URL
// ======================================================

$googleSheetURL =
"https://script.google.com/macros/s/AKfycbzRqE9u-c5RuoGC7ZA2MWp2de4Decqymz5yH6AZRdSP6XlT7HQU5FCHrmeTLoliBB51/exec";


// ======================================================
// FORM SUBMIT
// ======================================================

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"] ?? "");
    $phone = trim($_POST["phone"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $date = trim($_POST["date"] ?? "");
    $time = trim($_POST["time"] ?? "");
    $guests = trim($_POST["guests"] ?? "");
    $occasion = trim($_POST["occasion"] ?? "");
    $special_request = trim($_POST["special_request"] ?? "");
    $payment_method = trim($_POST["payment_method"] ?? "");

    $payment_status = "Pending";


    // ==================================================
    // VALIDATION
    // ==================================================

    if (
        $name === "" ||
        $phone === "" ||
        $date === "" ||
        $time === "" ||
        $guests === "" ||
        $payment_method === ""
    ) {

        $error = "Please fill all required fields.";

    } elseif (!preg_match("/^[0-9]{10}$/", $phone)) {

        $error = "Please enter a valid 10-digit mobile number.";

    } elseif ($date < $today) {

        $error = "Please select today or a future reservation date.";

    } elseif (
        $email !== "" &&
        !filter_var($email, FILTER_VALIDATE_EMAIL)
    ) {

        $error = "Please enter a valid email address.";

    } elseif (
        !is_numeric($guests) ||
        $guests < 1 ||
        $guests > 10
    ) {

        $error = "Please select between 1 and 10 guests.";

    } else {


        // ==================================================
        // RESERVATION ID
        // ==================================================

        $reservation_id =
            "RES" .
            date("YmdHis") .
            rand(100, 999);


        // ==================================================
        // RESERVATION STATUS
        // ==================================================

        $reservation_status = "Pending Confirmation";


        // ==================================================
        // CREATED DATE
        // ==================================================

        $created_at = date("d-m-Y H:i:s");


        // ==================================================
        // DATA FOR GOOGLE SHEET
        // ==================================================

        $googleData = [

            "reservation_id" => $reservation_id,

            "name" => $name,

            "phone" => $phone,

            "email" => $email,

            "date" => $date,

            "time" => $time,

            "guests" => $guests,

            "occasion" => $occasion,

            "special_request" => $special_request,

            "reservation_fee" => $reservation_fee,

            "reservation_status" => $reservation_status,

            "payment_method" => $payment_method,

            "payment_status" => $payment_status,

            "created_at" => $created_at

        ];


        // ==================================================
        // SEND TO GOOGLE SHEET
        // ==================================================

        $ch = curl_init($googleSheetURL);


        curl_setopt(
            $ch,
            CURLOPT_POST,
            true
        );


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


        curl_setopt(
            $ch,
            CURLOPT_RETURNTRANSFER,
            true
        );


        curl_setopt(
            $ch,
            CURLOPT_FOLLOWLOCATION,
            true
        );


        curl_setopt(
            $ch,
            CURLOPT_TIMEOUT,
            20
        );


        // ==================================================
        // EXECUTE REQUEST
        // ==================================================

        $googleResponse = curl_exec($ch);

        $curlError = curl_error($ch);

        curl_close($ch);


        // ==================================================
        // CHECK GOOGLE SHEET RESPONSE
        // ==================================================

        if (
            $googleResponse === false ||
            $curlError !== ""
        ) {

            $error =
                "Unable to connect to Google Sheet. Please try again.";

        } else {

            $responseData =
                json_decode(
                    $googleResponse,
                    true
                );


            if (
                is_array($responseData) &&
                isset($responseData["success"]) &&
                $responseData["success"] === false
            ) {

                $error =
                    "Reservation could not be saved to Google Sheet.";

            } else {

                $success = true;

            }

        }

    }

}

?>


<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<title>VELOURE | Reservation</title>


<!-- GOOGLE FONTS -->

<link
    href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=DM+Sans:wght@400;500;600;700&display=swap"
    rel="stylesheet"
>


<style>

/* ======================================================
   RESET
====================================================== */

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

html {
    scroll-behavior: smooth;
}

body {

    font-family: "DM Sans", sans-serif;

    background: #f6f1e8;

    color: #35251d;

    min-height: 100vh;

}


/* ======================================================
   NAVBAR
====================================================== */

.navbar {

    position: sticky;

    top: 0;

    z-index: 999;

    height: 78px;

    background: #fffaf4;

    border-bottom: 1px solid #dfd2c2;

    display: flex;

    align-items: center;

    justify-content: space-between;

    padding: 0 6%;

}

.logo {

    text-decoration: none;

    color: #35251d;

}

.logo h1 {

    font-family: "Cormorant Garamond", serif;

    font-size: 34px;

    line-height: 28px;

    letter-spacing: 5px;

}

.logo span {

    display: block;

    text-align: center;

    font-size: 8px;

    letter-spacing: 4px;

    color: #a47b4c;

    margin-top: 4px;

}

.nav-links {

    display: flex;

    gap: 18px;

}

.nav-links a {

    text-decoration: none;

    color: #35251d;

    font-size: 13px;

    font-weight: 600;

}

.nav-links a:hover {

    color: #a47b4c;

}

.back-btn {

    text-decoration: none;

    color: #35251d;

    border: 1px solid #bfa88e;

    padding: 10px 18px;

    border-radius: 25px;

    font-size: 13px;

}

.back-btn:hover {

    background: #35251d;

    color: white;

}


/* ======================================================
   CONTAINER
====================================================== */

.container {

    width: 94%;

    max-width: 1150px;

    margin: 50px auto 80px;

}


/* ======================================================
   CARD
====================================================== */

.card {

    display: grid;

    grid-template-columns: 38% 62%;

    background: white;

    border-radius: 25px;

    overflow: hidden;

    box-shadow:
        0 20px 60px rgba(53,37,29,.15);

}


/* ======================================================
   LEFT
====================================================== */

.left {

    background:
        linear-gradient(
            145deg,
            #35251d,
            #241713
        );

    color: white;

    padding: 55px 40px;

}

.left small {

    color: #d4b27f;

    letter-spacing: 4px;

    font-size: 11px;

}

.left h2 {

    font-family: "Cormorant Garamond", serif;

    font-size: 52px;

    line-height: 1;

    margin: 22px 0;

}

.left p {

    color: #ddd0c5;

    line-height: 1.8;

    font-size: 14px;

}

.info {

    margin-top: 35px;

    line-height: 2.6;

    color: #eee3da;

    font-size: 14px;

}


/* ======================================================
   FEE
====================================================== */

.fee-info {

    margin-top: 30px;

    padding: 18px;

    border: 1px solid rgba(255,255,255,.15);

    border-radius: 14px;

    background: rgba(255,255,255,.06);

}

.fee-info span {

    display: block;

    color: #d4b27f;

    font-size: 11px;

    letter-spacing: 2px;

    margin-bottom: 5px;

}

.fee-info strong {

    font-family: "Cormorant Garamond", serif;

    font-size: 32px;

    color: #fff;

}


/* ======================================================
   RIGHT
====================================================== */

.right {

    padding: 48px;

}

.right h1 {

    font-family: "Cormorant Garamond", serif;

    font-size: 48px;

    margin-bottom: 5px;

}

.subtitle {

    color: #806f61;

    margin-bottom: 28px;

    font-size: 14px;

}


/* ======================================================
   ERROR
====================================================== */

.error {

    background: #ffe0e0;

    color: #a52d2d;

    padding: 14px;

    border-radius: 10px;

    margin-bottom: 20px;

    font-size: 14px;

    font-weight: 600;

}


/* ======================================================
   FORM
====================================================== */

.row {

    display: grid;

    grid-template-columns: 1fr 1fr;

    gap: 16px;

}

.group {

    margin-bottom: 18px;

}

label {

    display: block;

    font-weight: 600;

    font-size: 13px;

    margin-bottom: 7px;

}

input,
select,
textarea {

    width: 100%;

    padding: 14px;

    border: 1px solid #d9cbbb;

    border-radius: 10px;

    background: #fffdf9;

    color: #35251d;

    font-family: inherit;

    font-size: 14px;

    outline: none;

}

input:focus,
select:focus,
textarea:focus {

    border-color: #a47b4c;

    box-shadow:
        0 0 0 3px
        rgba(164,123,76,.12);

}

textarea {

    min-height: 95px;

    resize: vertical;

}


/* ======================================================
   PAYMENT
====================================================== */

.payment {

    background: #f6f1e8;

    padding: 18px;

    border-radius: 12px;

    margin-bottom: 20px;

}

.payment h3 {

    font-family: "Cormorant Garamond", serif;

    font-size: 24px;

    margin-bottom: 15px;

}

.payment-row {

    display: flex;

    gap: 10px;

}

.payment-option {

    flex: 1;

}

.payment-row input {

    display: none;

}

.payment-row label {

    border: 1px solid #d2c2b1;

    padding: 13px 8px;

    text-align: center;

    border-radius: 10px;

    cursor: pointer;

    background: white;

}

.payment-row label:hover {

    border-color: #a47b4c;

}

.payment-row input:checked + label {

    background: #35251d;

    color: white;

    border-color: #35251d;

}


/* ======================================================
   UPI QR
====================================================== */

.qr-payment {

    display: none;

    background: #fffaf4;

    border: 1px solid #d9cbbb;

    padding: 25px;

    border-radius: 15px;

    margin-bottom: 20px;

    text-align: center;

}

.qr-payment.show {

    display: block;

}

.qr-payment h3 {

    font-family: "Cormorant Garamond", serif;

    font-size: 28px;

    margin-bottom: 8px;

}

.qr-payment p {

    color: #806f61;

    font-size: 13px;

    margin-bottom: 12px;

}

.upi-qr {

    width: 200px;

    height: 200px;

    object-fit: contain;

    display: block;

    margin: 15px auto;

    border-radius: 10px;

    border: 1px solid #dfd2c2;

    background: white;

    padding: 8px;

}

.qr-amount {

    background: #f6f1e8;

    padding: 12px;

    border-radius: 10px;

    margin: 10px 0;

}

.qr-amount span {

    display: block;

    color: #806f61;

    font-size: 12px;

    margin-bottom: 5px;

}

.qr-amount strong {

    font-family: "Cormorant Garamond", serif;

    font-size: 32px;

    color: #a47b4c;

}

.qr-note {

    font-size: 11px !important;

}


/* ======================================================
   BUTTON
====================================================== */

.submit-btn {

    width: 100%;

    border: none;

    background: #35251d;

    color: white;

    padding: 16px;

    border-radius: 12px;

    font-size: 15px;

    font-weight: 700;

    cursor: pointer;

}

.submit-btn:hover {

    background: #a47b4c;

}


/* ======================================================
   SUCCESS
====================================================== */

.success {

    max-width: 700px;

    margin: 60px auto;

    background: white;

    padding: 50px;

    border-radius: 25px;

    text-align: center;

    box-shadow:
        0 20px 60px rgba(53,37,29,.15);

}

.success-icon {

    width: 80px;

    height: 80px;

    background: #35251d;

    color: white;

    border-radius: 50%;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 40px;

    margin: auto;

}

.success h1 {

    font-family: "Cormorant Garamond", serif;

    font-size: 45px;

    margin: 20px 0 8px;

}

.success > p {

    color: #806f61;

}

.details {

    text-align: left;

    background: #f6f1e8;

    padding: 22px;

    border-radius: 14px;

    margin: 28px 0;

}

.details p {

    margin: 11px 0;

    font-size: 14px;

    border-bottom: 1px solid #dfd2c2;

    padding-bottom: 8px;

}

.home-btn {

    display: inline-block;

    background: #35251d;

    color: white;

    text-decoration: none;

    padding: 14px 28px;

    border-radius: 25px;

    font-weight: 600;

}


/* ======================================================
   FOOTER
====================================================== */

footer {

    background: #241713;

    color: white;

    text-align: center;

    padding: 40px 20px;

}

.footer-logo {

    font-family: "Cormorant Garamond", serif;

    font-size: 35px;

    letter-spacing: 5px;

}

footer p {

    margin-top: 8px;

    opacity: .6;

    font-size: 12px;

}


/* ======================================================
   RESPONSIVE
====================================================== */

@media (max-width: 900px) {

    .nav-links {
        display: none;
    }

    .card {
        grid-template-columns: 1fr;
    }

    .row {
        grid-template-columns: 1fr;
    }

}

@media (max-width: 600px) {

    .navbar {
        padding: 0 15px;
    }

    .logo h1 {
        font-size: 27px;
    }

    .container {
        width: 96%;
        margin-top: 25px;
    }

    .left {
        padding: 40px 25px;
    }

    .left h2 {
        font-size: 43px;
    }

    .right {
        padding: 30px 20px;
    }

    .right h1 {
        font-size: 40px;
    }

    .payment-row {
        flex-direction: column;
    }

    .success {
        padding: 30px 20px;
    }

    .success h1 {
        font-size: 36px;
    }

    .upi-qr {
        width: 170px;
        height: 170px;
    }

}

</style>

</head>


<body>


<!-- ======================================================
     NAVBAR
====================================================== -->

<nav class="navbar">

    <a href="index.php" class="logo">

        <h1>VELOURE</h1>

        <span>ARTISAN CAFÉ</span>

    </a>


    <div class="nav-links">

        <a href="index.php">Home</a>

        <a href="about.php">About</a>

        <a href="menu.php">Menu</a>

        <a href="offers.php">Offers</a>

        <a href="gallery.php">Gallery</a>

        <a href="services.php">Services</a>

        <a href="reservation.php">Reservation</a>

        <a href="reviews.php">Reviews</a>

    </div>


    <a href="offers.php" class="back-btn">
        ← Back
    </a>

</nav>



<div class="container" id="booking">


<?php if ($success): ?>


<!-- ======================================================
     SUCCESS
====================================================== -->

<div class="success">

    <div class="success-icon">
        ✓
    </div>

    <h1>
        Reservation Confirmed!
    </h1>

    <p>
        Thank you for choosing VELOURE Café.
    </p>


    <div class="details">

        <p>
            <strong>Reservation ID:</strong>
            <?php echo htmlspecialchars($reservation_id); ?>
        </p>

        <p>
            <strong>Name:</strong>
            <?php echo htmlspecialchars($name); ?>
        </p>

        <p>
            <strong>Mobile:</strong>
            <?php echo htmlspecialchars($phone); ?>
        </p>


        <?php if ($email !== ""): ?>

        <p>
            <strong>Email:</strong>
            <?php echo htmlspecialchars($email); ?>
        </p>

        <?php endif; ?>


        <p>
            <strong>Date:</strong>
            <?php echo htmlspecialchars($date); ?>
        </p>

        <p>
            <strong>Time:</strong>
            <?php echo htmlspecialchars($time); ?>
        </p>

        <p>
            <strong>Guests:</strong>
            <?php echo htmlspecialchars($guests); ?>
        </p>

        <p>
            <strong>Occasion:</strong>
            <?php
            echo htmlspecialchars(
                $occasion !== ""
                ? $occasion
                : "Not specified"
            );
            ?>
        </p>


        <?php if ($special_request !== ""): ?>

        <p>
            <strong>Special Request:</strong>
            <?php echo htmlspecialchars($special_request); ?>
        </p>

        <?php endif; ?>


        <p>
            <strong>Payment Method:</strong>
            <?php echo htmlspecialchars($payment_method); ?>
        </p>

        <p>
            <strong>Payment Status:</strong>
            <?php echo htmlspecialchars($payment_status); ?>
        </p>

        <p>
            <strong>Reservation Fee:</strong>
            ₹<?php echo $reservation_fee; ?>
        </p>

        <p>
            <strong>Reservation Status:</strong>
            Pending Confirmation
        </p>

    </div>


    <a href="index.php" class="home-btn">
        Back to Home
    </a>

</div>


<?php else: ?>


<!-- ======================================================
     RESERVATION FORM
====================================================== -->

<div class="card">


    <!-- LEFT -->

    <div class="left">

        <small>
            RESERVE YOUR EXPERIENCE
        </small>

        <h2>
            Your Table,<br>
            Your Moment.
        </h2>

        <p>
            Reserve your table at VELOURE Café
            and enjoy handcrafted coffee,
            delicious cuisine and an elegant
            ambience.
        </p>


        <div class="info">

            ☕ Premium Coffee & Cuisine<br>

            🕐 9:00 AM – 11:00 PM<br>

            ✨ Elegant Café Ambience<br>

            🎉 Perfect for Celebrations

        </div>


        <div class="fee-info">

            <span>
                RESERVATION FEE
            </span>

            <strong>
                ₹<?php echo $reservation_fee; ?>
            </strong>

        </div>

    </div>



    <!-- RIGHT -->

    <div class="right">

        <h1>
            Reserve a Table
        </h1>

        <p class="subtitle">
            Enter your details to confirm your reservation.
        </p>


        <?php if ($error !== ""): ?>

        <div class="error">
            <?php echo htmlspecialchars($error); ?>
        </div>

        <?php endif; ?>


        <form
            method="POST"
            action="reservation.php#booking"
            id="reservationForm"
        >


            <!-- NAME + PHONE -->

            <div class="row">

                <div class="group">

                    <label>
                        Customer Name *
                    </label>

                    <input
                        type="text"
                        name="name"
                        value="<?php echo htmlspecialchars($name); ?>"
                        placeholder="Enter your full name"
                        maxlength="60"
                        required
                    >

                </div>


                <div class="group">

                    <label>
                        Mobile Number *
                    </label>

                    <input
                        type="tel"
                        name="phone"
                        value="<?php echo htmlspecialchars($phone); ?>"
                        placeholder="10-digit mobile number"
                        maxlength="10"
                        pattern="[0-9]{10}"
                        inputmode="numeric"
                        required
                    >

                </div>

            </div>


            <!-- EMAIL -->

            <div class="group">

                <label>
                    Email Address
                </label>

                <input
                    type="email"
                    name="email"
                    value="<?php echo htmlspecialchars($email); ?>"
                    placeholder="Enter your email"
                >

            </div>


            <!-- DATE + TIME -->

            <div class="row">

                <div class="group">

                    <label>
                        Reservation Date *
                    </label>

                    <input
                        type="date"
                        name="date"
                        value="<?php echo htmlspecialchars($date); ?>"
                        min="<?php echo $today; ?>"
                        required
                    >

                </div>


                <div class="group">

                    <label>
                        Reservation Time *
                    </label>

                    <input
                        type="time"
                        name="time"
                        value="<?php echo htmlspecialchars($time); ?>"
                        min="09:00"
                        max="23:00"
                        required
                    >

                </div>

            </div>


            <!-- GUESTS + OCCASION -->

            <div class="row">

                <div class="group">

                    <label>
                        Number of Guests *
                    </label>

                    <select
                        name="guests"
                        required
                    >

                        <option value="">
                            Select guests
                        </option>


                        <?php for ($i = 1; $i <= 10; $i++): ?>

                        <option
                            value="<?php echo $i; ?>"
                            <?php
                            echo ($guests == $i)
                            ? "selected"
                            : "";
                            ?>
                        >

                            <?php echo $i; ?>

                            <?php
                            echo ($i == 1)
                            ? " Guest"
                            : " Guests";
                            ?>

                        </option>

                        <?php endfor; ?>

                    </select>

                </div>


                <div class="group">

                    <label>
                        Occasion
                    </label>

                    <select name="occasion">

                        <option value="">
                            Select occasion
                        </option>

                        <option value="Casual Visit">
                            Casual Visit
                        </option>

                        <option value="Birthday">
                            Birthday
                        </option>

                        <option value="Anniversary">
                            Anniversary
                        </option>

                        <option value="Date">
                            Date
                        </option>

                        <option value="Business Meeting">
                            Business Meeting
                        </option>

                        <option value="Family Gathering">
                            Family Gathering
                        </option>

                    </select>

                </div>

            </div>


            <!-- SPECIAL REQUEST -->

            <div class="group">

                <label>
                    Special Request
                </label>

                <textarea
                    name="special_request"
                    placeholder="Any special request?"
                    maxlength="500"
                ><?php echo htmlspecialchars($special_request); ?></textarea>

            </div>


            <!-- PAYMENT -->

            <div class="payment">

                <h3>
                    Payment Method
                </h3>


                <div class="payment-row">


                    <div class="payment-option">

                        <input
                            type="radio"
                            name="payment_method"
                            id="cash"
                            value="Cash"
                            <?php
                            echo ($payment_method === "Cash")
                            ? "checked"
                            : "";
                            ?>
                            required
                        >

                        <label for="cash">
                            💵 Cash
                        </label>

                    </div>


                    <div class="payment-option">

                        <input
                            type="radio"
                            name="payment_method"
                            id="upi"
                            value="UPI"
                            <?php
                            echo ($payment_method === "UPI")
                            ? "checked"
                            : "";
                            ?>
                        >

                        <label for="upi">
                            📱 UPI
                        </label>

                    </div>


                    <div class="payment-option">

                        <input
                            type="radio"
                            name="payment_method"
                            id="card"
                            value="Card"
                            <?php
                            echo ($payment_method === "Card")
                            ? "checked"
                            : "";
                            ?>
                        >

                        <label for="card">
                            💳 Card
                        </label>

                    </div>

                </div>

            </div>


            <!-- UPI QR -->

            <div
                class="qr-payment"
                id="qrPayment"
            >

                <h3>
                    📱 UPI Payment
                </h3>

                <p>
                    Scan the QR code below to pay the reservation fee.
                </p>


                <img
                    src="images/upi-qr.jpg"
                    alt="VELOURE UPI QR Code"
                    class="upi-qr"
                    onerror="this.style.display='none';"
                >


                <div class="qr-amount">

                    <span>
                        Reservation Amount
                    </span>

                    <strong>
                        ₹<?php echo $reservation_fee; ?>
                    </strong>

                </div>


                <p class="qr-note">

                    After payment, please keep your
                    transaction confirmation.

                </p>

            </div>


            <!-- SUBMIT -->

            <button
                type="submit"
                class="submit-btn"
            >
                Confirm Reservation
            </button>


        </form>

    </div>

</div>


<?php endif; ?>

</div>


<!-- ======================================================
     FOOTER
====================================================== -->

<footer>

    <div class="footer-logo">
        VELOURE
    </div>

    <p>
        © 2026 VELOURE Artisan Café.
        All Rights Reserved.
    </p>

</footer>


<!-- ======================================================
     JAVASCRIPT
====================================================== -->

<script>

document.addEventListener(
    "DOMContentLoaded",
    function () {

        const form =
            document.getElementById(
                "reservationForm"
            );

        if (!form) {
            return;
        }


        // ==================================================
        // UPI QR SHOW / HIDE
        // ==================================================

        const paymentOptions =
            document.querySelectorAll(
                'input[name="payment_method"]'
            );

        const qrPayment =
            document.getElementById(
                "qrPayment"
            );


        paymentOptions.forEach(
            function (radio) {

                radio.addEventListener(
                    "change",
                    function () {

                        if (
                            this.value === "UPI"
                        ) {

                            qrPayment.classList.add(
                                "show"
                            );

                        } else {

                            qrPayment.classList.remove(
                                "show"
                            );

                        }

                    }
                );

            }
        );


        // ==================================================
        // FORM VALIDATION
        // ==================================================

        form.addEventListener(
            "submit",
            function (event) {

                const phone =
                    form.querySelector(
                        'input[name="phone"]'
                    ).value.trim();


                if (
                    !/^[0-9]{10}$/.test(phone)
                ) {

                    event.preventDefault();

                    alert(
                        "Please enter a valid 10-digit mobile number."
                    );

                    return;

                }


                const date =
                    form.querySelector(
                        'input[name="date"]'
                    ).value;


                if (!date) {

                    event.preventDefault();

                    alert(
                        "Please select a reservation date."
                    );

                    return;

                }


                const payment =
                    form.querySelector(
                        'input[name="payment_method"]:checked'
                    );


                if (!payment) {

                    event.preventDefault();

                    alert(
                        "Please select a payment method."
                    );

                    return;

                }

            }
        );


        // ==================================================
        // SHOW QR IF UPI SELECTED
        // ==================================================

        const selectedPayment =
            document.querySelector(
                'input[name="payment_method"]:checked'
            );


        if (
            selectedPayment &&
            selectedPayment.value === "UPI"
        ) {

            qrPayment.classList.add(
                "show"
            );

        }

    }
);

</script>


</body>

</html>