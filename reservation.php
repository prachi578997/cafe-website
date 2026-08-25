<?php

// ======================================================
// VELOURE CAFE - RESERVATION SYSTEM
// MENU + SERVICES + GALLERY
// GOOGLE SHEET + UPI QR
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
// SELECTED ITEMS
// ======================================================

$selected_items = [];

$menu_total = 0;
$service_total = 0;
$gallery_total = 0;

$items_total = 0;
$grand_total = $reservation_fee;


// ======================================================
// GOOGLE SHEET URL
// ======================================================

$googleSheetURL =
"https://script.google.com/macros/s/AKfycbzRqE9u-c5RuoGC7ZA2MWp2de4Decqymz5yH6AZRdSP6XlT7HQU5FCHrmeTLoliBB51/exec";


// ======================================================
// FORM SUBMIT
// ======================================================

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // ==================================================
    // BASIC DETAILS
    // ==================================================

    $name = trim($_POST["name"] ?? "");

    $phone = trim($_POST["phone"] ?? "");

    $email = trim($_POST["email"] ?? "");

    $date = trim($_POST["date"] ?? "");

    $time = trim($_POST["time"] ?? "");

    $guests = trim($_POST["guests"] ?? "");

    $occasion = trim($_POST["occasion"] ?? "");

    $special_request =
        trim($_POST["special_request"] ?? "");

    $payment_method =
        trim($_POST["payment_method"] ?? "");

    $payment_status = "Pending";


    // ==================================================
    // GET SELECTED ITEMS
    // ==================================================

    $reservation_items_json =
        $_POST["reservation_items"] ?? "[]";


    $decoded_items =
        json_decode(
            $reservation_items_json,
            true
        );


    if (is_array($decoded_items)) {

        foreach ($decoded_items as $item) {

            $itemName =
                trim($item["name"] ?? "");

            $itemPrice =
                (float)($item["price"] ?? 0);

            $quantity =
                (int)($item["quantity"] ?? 1);

            $itemType =
                strtolower(
                    trim(
                        $item["type"] ?? "menu"
                    )
                );


            // ------------------------------------------
            // ALLOWED TYPES
            // ------------------------------------------

            if (
                !in_array(
                    $itemType,
                    [
                        "menu",
                        "service",
                        "gallery"
                    ],
                    true
                )
            ) {

                $itemType = "menu";

            }


            // ------------------------------------------
            // VALID ITEM
            // ------------------------------------------

            if (
                $itemName !== "" &&
                $itemPrice > 0 &&
                $quantity > 0
            ) {

                $itemTotal =
                    $itemPrice * $quantity;


                $selected_items[] = [

                    "name" =>
                        $itemName,

                    "price" =>
                        $itemPrice,

                    "quantity" =>
                        $quantity,

                    "type" =>
                        $itemType,

                    "total" =>
                        $itemTotal

                ];


                // --------------------------------------
                // TYPE TOTAL
                // --------------------------------------

                if ($itemType === "menu") {

                    $menu_total +=
                        $itemTotal;

                }

                elseif ($itemType === "service") {

                    $service_total +=
                        $itemTotal;

                }

                elseif ($itemType === "gallery") {

                    $gallery_total +=
                        $itemTotal;

                }

            }

        }

    }


    // ==================================================
    // ITEMS TOTAL
    // ==================================================

    $items_total =
        $menu_total +
        $service_total +
        $gallery_total;


    // ==================================================
    // GRAND TOTAL
    // ==================================================

    $grand_total =
        $items_total +
        $reservation_fee;


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

        $error =
            "Please fill all required fields.";

    }

    elseif (
        !preg_match(
            "/^[0-9]{10}$/",
            $phone
        )
    ) {

        $error =
            "Please enter a valid 10-digit mobile number.";

    }

    elseif (
        $date < $today
    ) {

        $error =
            "Please select today or a future reservation date.";

    }

    elseif (
        $email !== "" &&
        !filter_var(
            $email,
            FILTER_VALIDATE_EMAIL
        )
    ) {

        $error =
            "Please enter a valid email address.";

    }

    elseif (
        !is_numeric($guests) ||
        $guests < 1 ||
        $guests > 10
    ) {

        $error =
            "Please select between 1 and 10 guests.";

    }

    else {

        // ==================================================
        // RESERVATION ID
        // ==================================================

        $reservation_id =
            "RES" .
            date("YmdHis") .
            rand(100, 999);


        // ==================================================
        // STATUS
        // ==================================================

        $reservation_status =
            "Pending Confirmation";


        // ==================================================
        // CREATED AT
        // ==================================================

        $created_at =
            date("d-m-Y H:i:s");


        // ==================================================
        // ITEMS TEXT FOR GOOGLE SHEET
        // ==================================================

        $selected_items_text = "";

        if (!empty($selected_items)) {

            $itemParts = [];


            foreach ($selected_items as $item) {

                $typeLabel = "Menu";


                if ($item["type"] === "service") {

                    $typeLabel = "Service";

                }

                elseif ($item["type"] === "gallery") {

                    $typeLabel = "Gallery";

                }


                $itemParts[] =
                    $typeLabel .
                    " - " .
                    $item["name"] .
                    " x " .
                    $item["quantity"] .
                    " = ₹" .
                    number_format(
                        $item["total"]
                    );

            }


            $selected_items_text =
                implode(
                    " | ",
                    $itemParts
                );

        }

        else {

            $selected_items_text =
                "No item selected";

        }


        // ==================================================
        // GOOGLE SHEET DATA
        // ==================================================

        $googleData = [

            "reservation_id" =>
                $reservation_id,

            "name" =>
                $name,

            "phone" =>
                $phone,

            "email" =>
                $email,

            "date" =>
                $date,

            "time" =>
                $time,

            "guests" =>
                $guests,

            "occasion" =>
                $occasion,

            "special_request" =>
                $special_request,

            "selected_items" =>
                $selected_items_text,

            "menu_total" =>
                $menu_total,

            "service_total" =>
                $service_total,

            "gallery_total" =>
                $gallery_total,

            "items_total" =>
                $items_total,

            "reservation_fee" =>
                $reservation_fee,

            "grand_total" =>
                $grand_total,

            "reservation_status" =>
                $reservation_status,

            "payment_method" =>
                $payment_method,

            "payment_status" =>
                $payment_status,

            "created_at" =>
                $created_at

        ];


        // ==================================================
        // SEND GOOGLE SHEET
        // ==================================================

        $ch =
            curl_init(
                $googleSheetURL
            );


        curl_setopt(
            $ch,
            CURLOPT_POST,
            true
        );


        curl_setopt(
            $ch,
            CURLOPT_POSTFIELDS,
            json_encode(
                $googleData,
                JSON_UNESCAPED_UNICODE
            )
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
        // EXECUTE
        // ==================================================

        $googleResponse =
            curl_exec($ch);


        $curlError =
            curl_error($ch);


        curl_close($ch);


        // ==================================================
        // GOOGLE RESPONSE
        // ==================================================

        if (
            $googleResponse === false ||
            $curlError !== ""
        ) {

            $error =
                "Unable to connect to Google Sheet. Please try again.";

        }

        else {

            $responseData =
                json_decode(
                    $googleResponse,
                    true
                );


            if (
                is_array($responseData) &&
                isset(
                    $responseData["success"]
                ) &&
                $responseData["success"] === false
            ) {

                $error =
                    "Reservation could not be saved to Google Sheet.";

            }

            else {

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


<link
    href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=DM+Sans:wght@400;500;600;700&display=swap"
    rel="stylesheet"
>


<style>

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

html {
    scroll-behavior: smooth;
}

body {

    font-family:
        "DM Sans",
        sans-serif;

    background:
        #f6f1e8;

    color:
        #35251d;

    min-height:
        100vh;

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

    border-bottom:
        1px solid #dfd2c2;

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

    font-family:
        "Cormorant Garamond",
        serif;

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

    grid-template-columns:
        38% 62%;

    background: white;

    border-radius: 25px;

    overflow: hidden;

    box-shadow:
        0 20px 60px
        rgba(53,37,29,.15);

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

    font-family:
        "Cormorant Garamond",
        serif;

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

    border:
        1px solid
        rgba(255,255,255,.15);

    border-radius: 14px;

    background:
        rgba(255,255,255,.06);

}

.fee-info span {

    display: block;

    color: #d4b27f;

    font-size: 11px;

    letter-spacing: 2px;

    margin-bottom: 5px;

}

.fee-info strong {

    font-family:
        "Cormorant Garamond",
        serif;

    font-size: 32px;

    color: white;

}


/* ======================================================
   RIGHT
====================================================== */

.right {

    padding: 48px;

}

.right h1 {

    font-family:
        "Cormorant Garamond",
        serif;

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

    grid-template-columns:
        1fr 1fr;

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

    border:
        1px solid #d9cbbb;

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
   SELECTED ITEMS
====================================================== */

.selected-items-box {

    background: #f6f1e8;

    border:
        1px solid #d9cbbb;

    padding: 20px;

    border-radius: 15px;

    margin-bottom: 20px;

}

.selected-items-box h3 {

    font-family:
        "Cormorant Garamond",
        serif;

    font-size: 28px;

    margin-bottom: 15px;

}

.selected-item {

    display: flex;

    justify-content:
        space-between;

    align-items: center;

    gap: 15px;

    padding: 12px 0;

    border-bottom:
        1px solid #dfd2c2;

    font-size: 13px;

}

.selected-item-name {

    font-weight: 600;

}

.item-type {

    color: #a47b4c;

    font-size: 11px;

    font-weight: 700;

    letter-spacing: 1px;

    text-transform: uppercase;

}

.selected-item-price {

    color: #a47b4c;

    font-weight: 700;

    text-align: right;

}

.no-items {

    color: #806f61;

    font-size: 13px;

    padding: 10px 0;

}

.items-total {

    display: flex;

    justify-content:
        space-between;

    padding-top: 12px;

    font-size: 14px;

}

.items-total strong {

    color: #a47b4c;

}

.grand-total {

    display: flex;

    justify-content:
        space-between;

    margin-top: 15px;

    padding-top: 15px;

    border-top:
        2px solid #d2c2b1;

    font-size: 20px;

    font-weight: 700;

}

.grand-total strong {

    color: #35251d;

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

    font-family:
        "Cormorant Garamond",
        serif;

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

    border:
        1px solid #d2c2b1;

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
   QR
====================================================== */

.qr-payment {

    display: none;

    background: #fffaf4;

    border:
        1px solid #d9cbbb;

    padding: 25px;

    border-radius: 15px;

    margin-bottom: 20px;

    text-align: center;

}

.qr-payment.show {

    display: block;

}

.qr-payment h3 {

    font-family:
        "Cormorant Garamond",
        serif;

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

    border:
        1px solid #dfd2c2;

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

    font-family:
        "Cormorant Garamond",
        serif;

    font-size: 32px;

    color: #a47b4c;

}

.qr-note {

    font-size: 11px !important;

}


/* ======================================================
   SUBMIT
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

    max-width: 800px;

    margin: 60px auto;

    background: white;

    padding: 50px;

    border-radius: 25px;

    text-align: center;

    box-shadow:
        0 20px 60px
        rgba(53,37,29,.15);

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

    font-family:
        "Cormorant Garamond",
        serif;

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

    border-bottom:
        1px solid #dfd2c2;

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

    font-family:
        "Cormorant Garamond",
        serif;

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

    <a
        href="index.php"
        class="logo"
    >

        <h1>
            VELOURE
        </h1>

        <span>
            ARTISAN CAFÉ
        </span>

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


    <a
        href="menu.php"
        class="back-btn"
    >
        ← Back
    </a>

</nav>



<div
    class="container"
    id="booking"
>


<?php if ($success): ?>


<!-- ======================================================
     SUCCESS PAGE
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

            <strong>
                Reservation ID:
            </strong>

            <?php
            echo htmlspecialchars(
                $reservation_id
            );
            ?>

        </p>


        <p>

            <strong>
                Name:
            </strong>

            <?php
            echo htmlspecialchars(
                $name
            );
            ?>

        </p>


        <p>

            <strong>
                Mobile:
            </strong>

            <?php
            echo htmlspecialchars(
                $phone
            );
            ?>

        </p>


        <?php if ($email !== ""): ?>

        <p>

            <strong>
                Email:
            </strong>

            <?php
            echo htmlspecialchars(
                $email
            );
            ?>

        </p>

        <?php endif; ?>


        <p>

            <strong>
                Date:
            </strong>

            <?php
            echo htmlspecialchars(
                $date
            );
            ?>

        </p>


        <p>

            <strong>
                Time:
            </strong>

            <?php
            echo htmlspecialchars(
                $time
            );
            ?>

        </p>


        <p>

            <strong>
                Guests:
            </strong>

            <?php
            echo htmlspecialchars(
                $guests
            );
            ?>

        </p>


        <p>

            <strong>
                Occasion:
            </strong>

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

            <strong>
                Special Request:
            </strong>

            <?php
            echo htmlspecialchars(
                $special_request
            );
            ?>

        </p>

        <?php endif; ?>


        <!-- ==================================================
             SELECTED ITEMS
        =================================================== -->

        <?php if (!empty($selected_items)): ?>


        <p>

            <strong>
                Selected Items:
            </strong>

            <br><br>


            <?php foreach (
                $selected_items as $item
            ): ?>


                <span
                    style="
                        color:#a47b4c;
                        font-size:11px;
                        font-weight:700;
                        text-transform:uppercase;
                    "
                >

                    <?php

                    echo htmlspecialchars(
                        ucfirst(
                            $item["type"]
                        )
                    );

                    ?>

                </span>


                -

                <?php

                echo htmlspecialchars(
                    $item["name"]
                );

                ?>

                ×

                <?php
                echo (int)$item["quantity"];
                ?>

                —

                ₹<?php

                echo number_format(
                    $item["total"]
                );

                ?>


                <br><br>


            <?php endforeach; ?>


        </p>


        <p>

            <strong>
                Menu Total:
            </strong>

            ₹<?php
            echo number_format(
                $menu_total
            );
            ?>

        </p>


        <p>

            <strong>
                Services Total:
            </strong>

            ₹<?php
            echo number_format(
                $service_total
            );
            ?>

        </p>


        <p>

            <strong>
                Gallery Total:
            </strong>

            ₹<?php
            echo number_format(
                $gallery_total
            );
            ?>

        </p>


        <p>

            <strong>
                Items Total:
            </strong>

            ₹<?php
            echo number_format(
                $items_total
            );
            ?>

        </p>


        <?php else: ?>


        <p>

            <strong>
                Selected Items:
            </strong>

            No item selected.

        </p>


        <?php endif; ?>


        <p>

            <strong>
                Reservation Fee:
            </strong>

            ₹<?php
            echo number_format(
                $reservation_fee
            );
            ?>

        </p>


        <p>

            <strong>
                Grand Total:
            </strong>

            ₹<?php
            echo number_format(
                $grand_total
            );
            ?>

        </p>


        <p>

            <strong>
                Payment Method:
            </strong>

            <?php
            echo htmlspecialchars(
                $payment_method
            );
            ?>

        </p>


        <p>

            <strong>
                Payment Status:
            </strong>

            <?php
            echo htmlspecialchars(
                $payment_status
            );
            ?>

        </p>


        <p>

            <strong>
                Reservation Status:
            </strong>

            Pending Confirmation

        </p>


    </div>


    <a
        href="index.php"
        class="home-btn"
    >
        Back to Home
    </a>

</div>


<?php else: ?>


<!-- ======================================================
     RESERVATION FORM
====================================================== -->

<div class="card">


    <!-- ==================================================
         LEFT
    =================================================== -->

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

                ₹<?php
                echo number_format(
                    $reservation_fee
                );
                ?>

            </strong>

        </div>

    </div>



    <!-- ==================================================
         RIGHT
    =================================================== -->

    <div class="right">

        <h1>
            Reserve a Table
        </h1>


        <p class="subtitle">

            Enter your details to confirm
            your reservation.

        </p>


        <?php if ($error !== ""): ?>

        <div class="error">

            <?php
            echo htmlspecialchars(
                $error
            );
            ?>

        </div>

        <?php endif; ?>


        <form
            method="POST"
            action="reservation.php#booking"
            id="reservationForm"
        >


            <!-- ==================================================
                 HIDDEN ITEMS
            =================================================== -->

            <input
                type="hidden"
                name="reservation_items"
                id="reservationItems"
                value="[]"
            >


            <!-- ==================================================
                 SELECTED ITEMS BOX
            =================================================== -->

            <div class="selected-items-box">

                <h3>
                    Selected Items
                </h3>


                <div id="selectedItemsList">

                    <p class="no-items">
                        No item selected.
                    </p>

                </div>


                <div class="items-total">

                    <span>
                        Items Total
                    </span>

                    <strong id="itemsTotal">
                        ₹0
                    </strong>

                </div>


                <div class="items-total">

                    <span>
                        Reservation Fee
                    </span>

                    <strong>
                        ₹<?php
                        echo number_format(
                            $reservation_fee
                        );
                        ?>
                    </strong>

                </div>


                <div class="grand-total">

                    <span>
                        Grand Total
                    </span>

                    <strong id="grandTotal">

                        ₹<?php
                        echo number_format(
                            $reservation_fee
                        );
                        ?>

                    </strong>

                </div>

            </div>



            <!-- ==================================================
                 NAME + PHONE
            =================================================== -->

            <div class="row">


                <div class="group">

                    <label>
                        Customer Name *
                    </label>

                    <input
                        type="text"
                        name="name"
                        value="<?php
                        echo htmlspecialchars(
                            $name
                        );
                        ?>"
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
                        value="<?php
                        echo htmlspecialchars(
                            $phone
                        );
                        ?>"
                        placeholder="10-digit mobile number"
                        maxlength="10"
                        pattern="[0-9]{10}"
                        inputmode="numeric"
                        required
                    >

                </div>

            </div>



            <!-- ==================================================
                 EMAIL
            =================================================== -->

            <div class="group">

                <label>
                    Email Address
                </label>

                <input
                    type="email"
                    name="email"
                    value="<?php
                    echo htmlspecialchars(
                        $email
                    );
                    ?>"
                    placeholder="Enter your email"
                >

            </div>



            <!-- ==================================================
                 DATE + TIME
            =================================================== -->

            <div class="row">


                <div class="group">

                    <label>
                        Reservation Date *
                    </label>

                    <input
                        type="date"
                        name="date"
                        value="<?php
                        echo htmlspecialchars(
                            $date
                        );
                        ?>"
                        min="<?php
                        echo $today;
                        ?>"
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
                        value="<?php
                        echo htmlspecialchars(
                            $time
                        );
                        ?>"
                        min="09:00"
                        max="23:00"
                        required
                    >

                </div>

            </div>



            <!-- ==================================================
                 GUESTS + OCCASION
            =================================================== -->

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


                        <?php
                        for (
                            $i = 1;
                            $i <= 10;
                            $i++
                        ):
                        ?>

                        <option
                            value="<?php echo $i; ?>"
                            <?php
                            echo (
                                $guests == $i
                            )
                            ? "selected"
                            : "";
                            ?>
                        >

                            <?php echo $i; ?>

                            <?php
                            echo (
                                $i == 1
                            )
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

                    <select
                        name="occasion"
                    >

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



            <!-- ==================================================
                 SPECIAL REQUEST
            =================================================== -->

            <div class="group">

                <label>
                    Special Request
                </label>

                <textarea
                    name="special_request"
                    placeholder="Any special request?"
                    maxlength="500"
                ><?php
                echo htmlspecialchars(
                    $special_request
                );
                ?></textarea>

            </div>



            <!-- ==================================================
                 PAYMENT
            =================================================== -->

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
                            echo (
                                $payment_method === "Cash"
                            )
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
                            echo (
                                $payment_method === "UPI"
                            )
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
                            echo (
                                $payment_method === "Card"
                            )
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



            <!-- ==================================================
                 UPI
            =================================================== -->

            <div
                class="qr-payment"
                id="qrPayment"
            >

                <h3>
                    📱 UPI Payment
                </h3>

                <p>
                    Scan the QR code below to pay.
                </p>


                <img
                    src="images/upi-qr.jpg"
                    alt="VELOURE UPI QR Code"
                    class="upi-qr"
                    onerror="
                        this.style.display='none';
                    "
                >


                <div class="qr-amount">

                    <span>
                        Reservation Amount
                    </span>

                    <strong>

                        ₹<?php
                        echo number_format(
                            $reservation_fee
                        );
                        ?>

                    </strong>

                </div>


                <p class="qr-note">

                    After payment, please keep your
                    transaction confirmation.

                </p>

            </div>



            <!-- ==================================================
                 SUBMIT
            =================================================== -->

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
        // ELEMENTS
        // ==================================================

        const reservationItemsInput =
            document.getElementById(
                "reservationItems"
            );


        const selectedItemsList =
            document.getElementById(
                "selectedItemsList"
            );


        const itemsTotalElement =
            document.getElementById(
                "itemsTotal"
            );


        const grandTotalElement =
            document.getElementById(
                "grandTotal"
            );


        // ==================================================
        // LOAD ITEMS
        // ==================================================

        let selectedReservations = [];


        try {

            selectedReservations =
                JSON.parse(
                    localStorage.getItem(
                        "veloureReservations"
                    )
                ) || [];

        } catch (error) {

            selectedReservations = [];

        }


        // ==================================================
        // CLEAN ITEMS
        // ==================================================

        if (
            !Array.isArray(
                selectedReservations
            )
        ) {

            selectedReservations = [];

        }


        // ==================================================
        // DISPLAY ITEMS
        // ==================================================

        function displaySelectedItems() {


            if (
                selectedReservations.length === 0
            ) {

                selectedItemsList.innerHTML =
                    '<p class="no-items">' +
                    'No item selected.' +
                    '</p>';


                itemsTotalElement.textContent =
                    "₹0";


                grandTotalElement.textContent =
                    "₹<?php echo $reservation_fee; ?>";


                reservationItemsInput.value =
                    "[]";


                return;

            }


            let total = 0;


            selectedItemsList.innerHTML =
                "";


            selectedReservations.forEach(
                function(item) {


                    const name =
                        String(
                            item.name || ""
                        );


                    const price =
                        Number(
                            item.price || 0
                        );


                    const quantity =
                        Number(
                            item.quantity || 1
                        );


                    const type =
                        String(
                            item.type || "menu"
                        );


                    const itemTotal =
                        price *
                        quantity;


                    total +=
                        itemTotal;


                    // --------------------------------------
                    // TYPE NAME
                    // --------------------------------------

                    let typeLabel =
                        "Menu";


                    if (
                        type === "service"
                    ) {

                        typeLabel =
                            "Service";

                    }

                    else if (
                        type === "gallery"
                    ) {

                        typeLabel =
                            "Gallery";

                    }


                    // --------------------------------------
                    // ITEM ROW
                    // --------------------------------------

                    const div =
                        document.createElement(
                            "div"
                        );


                    div.className =
                        "selected-item";


                    // --------------------------------------
                    // NAME
                    // --------------------------------------

                    const nameDiv =
                        document.createElement(
                            "div"
                        );


                    nameDiv.className =
                        "selected-item-name";


                    nameDiv.innerHTML =
                        '<span class="item-type">' +
                        typeLabel +
                        '</span><br>' +
                        escapeHtml(name) +
                        ' × ' +
                        quantity;


                    // --------------------------------------
                    // PRICE
                    // --------------------------------------

                    const priceDiv =
                        document.createElement(
                            "div"
                        );


                    priceDiv.className =
                        "selected-item-price";


                    priceDiv.textContent =
                        "₹" +
                        itemTotal.toLocaleString(
                            "en-IN"
                        );


                    div.appendChild(
                        nameDiv
                    );


                    div.appendChild(
                        priceDiv
                    );


                    selectedItemsList.appendChild(
                        div
                    );

                }
            );


            // ==================================================
            // TOTAL
            // ==================================================

            const grandTotal =
                total +
                <?php echo (float)$reservation_fee; ?>;


            itemsTotalElement.textContent =
                "₹" +
                total.toLocaleString(
                    "en-IN"
                );


            grandTotalElement.textContent =
                "₹" +
                grandTotal.toLocaleString(
                    "en-IN"
                );


            reservationItemsInput.value =
                JSON.stringify(
                    selectedReservations
                );

        }


        // ==================================================
        // ESCAPE HTML
        // ==================================================

        function escapeHtml(value) {

            return String(value)
                .replace(
                    /&/g,
                    "&amp;"
                )
                .replace(
                    /</g,
                    "&lt;"
                )
                .replace(
                    />/g,
                    "&gt;"
                )
                .replace(
                    /"/g,
                    "&quot;"
                )
                .replace(
                    /'/g,
                    "&#039;"
                );

        }


        // ==================================================
        // DISPLAY
        // ==================================================

        displaySelectedItems();


        // ==================================================
        // PAYMENT
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
            function(radio) {

                radio.addEventListener(
                    "change",
                    function() {


                        if (
                            this.value === "UPI"
                        ) {

                            qrPayment.classList.add(
                                "show"
                            );

                        }

                        else {

                            qrPayment.classList.remove(
                                "show"
                            );

                        }

                    }
                );

            }
        );


        // ==================================================
        // SHOW QR IF SELECTED
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


        // ==================================================
        // SUBMIT
        // ==================================================

        form.addEventListener(
            "submit",
            function(event) {


                reservationItemsInput.value =
                    JSON.stringify(
                        selectedReservations
                    );


                // ------------------------------------------
                // PHONE
                // ------------------------------------------

                const phone =
                    form.querySelector(
                        'input[name="phone"]'
                    ).value.trim();


                if (
                    !/^[0-9]{10}$/.test(
                        phone
                    )
                ) {

                    event.preventDefault();

                    alert(
                        "Please enter a valid 10-digit mobile number."
                    );

                    return;

                }


                // ------------------------------------------
                // DATE
                // ------------------------------------------

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


                // ------------------------------------------
                // PAYMENT
                // ------------------------------------------

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


                // ------------------------------------------
                // UPI
                // ------------------------------------------

                if (
                    payment.value === "UPI"
                ) {


                    const total =
                        selectedReservations.reduce(
                            function(sum, item) {

                                return sum +
                                    (
                                        Number(
                                            item.price || 0
                                        ) *
                                        Number(
                                            item.quantity || 1
                                        )
                                    );

                            },
                            <?php
                            echo (float)$reservation_fee;
                            ?>
                        );


                    const confirmPayment =
                        confirm(

                            "Grand Total: ₹" +
                            total.toLocaleString(
                                "en-IN"
                            ) +

                            "\n\n" +

                            "Please complete the UPI payment using the QR code." +

                            "\n\n" +

                            "Continue with reservation?"

                        );


                    if (!confirmPayment) {

                        event.preventDefault();

                    }

                }

            }
        );

    }
);

</script>


</body>

</html>