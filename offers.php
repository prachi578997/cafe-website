<?php

// ======================================================
// VELOURE CAFE - EXCLUSIVE OFFERS + ORDER + PAYMENT
// ======================================================

date_default_timezone_set("Asia/Kolkata");

$offers = [

    "OFFER01" => [
        "title" => "Morning Bliss",
        "discount" => 20,
        "price" => 299,
        "old_price" => 399,
        "icon" => "☕",
        "description" => "Start your day with freshly brewed coffee and a delicious breakfast combo."
    ],

    "OFFER02" => [
        "title" => "Sweet Escape",
        "discount" => 25,
        "price" => 449,
        "old_price" => 599,
        "icon" => "🍰",
        "description" => "Enjoy our premium dessert collection with a perfect coffee pairing."
    ],

    "OFFER03" => [
        "title" => "Couple Special",
        "discount" => 30,
        "price" => 999,
        "old_price" => 1399,
        "icon" => "🥂",
        "description" => "A romantic table setup with signature drinks, desserts and a memorable ambience."
    ],

    "OFFER04" => [
        "title" => "Family Feast",
        "discount" => 15,
        "price" => 1299,
        "old_price" => 1499,
        "icon" => "👨‍👩‍👧‍👦",
        "description" => "Bring your family together with our specially curated sharing platter."
    ],

    "OFFER05" => [
        "title" => "Celebration Package",
        "discount" => 20,
        "price" => 1799,
        "old_price" => 2299,
        "icon" => "🎉",
        "description" => "Celebrate birthdays and special moments with our premium celebration package."
    ],

    "OFFER06" => [
        "title" => "Veloure Nights",
        "discount" => 40,
        "price" => 799,
        "old_price" => 1299,
        "icon" => "🌙",
        "description" => "Enjoy an elegant evening with signature dishes and premium ambience."
    ]

];


// ======================================================
// ORDER VARIABLES
// ======================================================

$order_success = false;
$order_error = "";

$order_id = "";
$customer_name = "";
$customer_phone = "";
$selected_offer = "";
$payment_method = "";
$payment_status = "Pending";


// ======================================================
// ORDER SUBMIT
// ======================================================

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $customer_name =
        trim($_POST["customer_name"] ?? "");

    $customer_phone =
        trim($_POST["customer_phone"] ?? "");

    $selected_offer =
        trim($_POST["offer_id"] ?? "");

    $payment_method =
        trim($_POST["payment_method"] ?? "");


    // ==================================================
    // VALIDATION
    // ==================================================

    if (
        $customer_name === "" ||
        $customer_phone === "" ||
        $selected_offer === "" ||
        $payment_method === ""
    ) {

        $order_error =
            "Please fill all required fields.";

    }

    elseif (
        !preg_match(
            "/^[0-9]{10}$/",
            $customer_phone
        )
    ) {

        $order_error =
            "Please enter a valid 10-digit mobile number.";

    }

    elseif (
        !isset($offers[$selected_offer])
    ) {

        $order_error =
            "Invalid offer selected.";

    }

    else {

        $offer = $offers[$selected_offer];


        // ==================================================
        // ORDER ID
        // ==================================================

        $order_id =
            "ORD" .
            date("YmdHis") .
            rand(100,999);


        // ==================================================
        // PAYMENT STATUS
        // ==================================================

        if ($payment_method === "UPI") {

            // UPI payment will remain pending
            // until actual payment verification
            $payment_status = "Pending";

        }

        elseif ($payment_method === "Cash") {

            $payment_status = "Cash on Visit";

        }

        elseif ($payment_method === "Card") {

            $payment_status = "Card Payment Pending";

        }


        // ==================================================
        // CREATED DATE
        // ==================================================

        $created_at =
            date("d-m-Y H:i:s");


        // ==================================================
        // ORDER CSV
        // ==================================================

        $csv_file =
            __DIR__ . "/order.csv";


        // ==================================================
        // CSV HEADERS
        // ==================================================

        $headers = [

            "Order ID",
            "Customer Name",
            "Mobile",
            "Offer ID",
            "Offer Name",
            "Offer Price",
            "Original Price",
            "Discount",
            "Payment Method",
            "Payment Status",
            "Order Status",
            "Created At"

        ];


        // ==================================================
        // ORDER DATA
        // ==================================================

        $data = [

            $order_id,
            $customer_name,
            $customer_phone,
            $selected_offer,
            $offer["title"],
            $offer["price"],
            $offer["old_price"],
            $offer["discount"] . "%",
            $payment_method,
            $payment_status,
            "Pending",
            $created_at

        ];


        // ==================================================
        // OPEN CSV
        // ==================================================

        $file_exists =
            file_exists($csv_file);

        $file =
            fopen($csv_file, "a");


        if ($file === false) {

            $order_error =
                "Unable to save order. Please check folder permission.";

        }

        else {

            if (flock($file, LOCK_EX)) {


                // ==========================================
                // CSV HEADER
                // ==========================================

                if (
                    !$file_exists ||
                    filesize($csv_file) === 0
                ) {

                    fwrite(
                        $file,
                        "\xEF\xBB\xBF"
                    );

                    fputcsv(
                        $file,
                        $headers
                    );

                }


                // ==========================================
                // SAVE ORDER
                // ==========================================

                fputcsv(
                    $file,
                    $data
                );

                fflush($file);

                flock(
                    $file,
                    LOCK_UN
                );

                fclose($file);


                $order_success = true;

            }

            else {

                fclose($file);

                $order_error =
                    "Unable to access order file.";

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

<title>
VELOURE | Exclusive Offers
</title>


<link
    rel="preconnect"
    href="https://fonts.googleapis.com"
>


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

    background: #0b0b0b;

    color: white;

    font-family:
        "DM Sans",
        sans-serif;

    overflow-x: hidden;

}


/* ======================================================
   NAVBAR
====================================================== */

nav {

    width: 100%;

    padding: 20px 8%;

    display: flex;

    justify-content: space-between;

    align-items: center;

    position: fixed;

    top: 0;
    left: 0;

    z-index: 1000;

    background:
        rgba(10,10,10,.90);

    backdrop-filter:
        blur(14px);

    border-bottom:
        1px solid
        rgba(214,168,95,.12);

}


.logo {

    font-family:
        "Cormorant Garamond",
        serif;

    font-size: 32px;

    font-weight: 700;

    letter-spacing: 5px;

    color: #d6a85f;

}


nav ul {

    display: flex;

    align-items: center;

    gap: 24px;

    list-style: none;

}


nav ul li a {

    text-decoration: none;

    color: white;

    font-size: 14px;

    font-weight: 500;

    transition: .3s;

}


nav ul li a:hover {

    color: #d6a85f;

}


/* ======================================================
   HERO
====================================================== */

.hero {

    min-height: 75vh;

    display: flex;

    justify-content: center;

    align-items: center;

    text-align: center;

    padding: 140px 20px 80px;

    background:

        linear-gradient(
            rgba(0,0,0,.55),
            rgba(0,0,0,.85)
        ),

        url("images/offers-bg.jpg")
        center/cover no-repeat;

}


.hero-content {

    max-width: 850px;

    animation:
        heroReveal 1.2s ease both;

}


.hero span {

    color: #d6a85f;

    font-size: 13px;

    font-weight: 600;

    letter-spacing: 6px;

}


.hero h1 {

    margin: 18px 0;

    font-family:
        "Cormorant Garamond",
        serif;

    font-size:
        clamp(55px,8vw,100px);

    line-height: .95;

}


.hero p {

    max-width: 650px;

    margin: auto;

    color: #ddd;

    line-height: 1.8;

}


/* ======================================================
   OFFERS
====================================================== */

.offers {

    padding: 100px 8%;

}


.section-title {

    text-align: center;

    margin-bottom: 65px;

}


.section-title span {

    color: #d6a85f;

    font-size: 13px;

    font-weight: 600;

    letter-spacing: 5px;

}


.section-title h2 {

    margin-top: 12px;

    font-family:
        "Cormorant Garamond",
        serif;

    font-size: 52px;

}


/* ======================================================
   GRID
====================================================== */

.offer-container {

    display: grid;

    grid-template-columns:
        repeat(3,1fr);

    gap: 30px;

}


/* ======================================================
   CARD
====================================================== */

.offer-card {

    position: relative;

    padding: 40px 30px;

    min-height: 390px;

    display: flex;

    flex-direction: column;

    border:
        1px solid
        rgba(214,168,95,.25);

    border-radius: 22px;

    background:
        linear-gradient(
            145deg,
            #191919,
            #0d0d0d
        );

    overflow: hidden;

    opacity: 0;

    transform:
        translateY(60px);

    transition:
        .7s ease;

}


.offer-card.show {

    opacity: 1;

    transform:
        translateY(0);

}


.offer-card:hover {

    transform:
        translateY(-10px);

    border-color:
        #d6a85f;

    box-shadow:
        0 25px 60px
        rgba(214,168,95,.15);

}


/* ======================================================
   BADGE
====================================================== */

.badge {

    position: absolute;

    top: 20px;

    right: -38px;

    padding: 8px 42px;

    background: #d6a85f;

    color: #111;

    font-size: 11px;

    font-weight: 700;

    transform:
        rotate(45deg);

}


/* ======================================================
   EMOJI
====================================================== */

.offer-icon {

    width: 75px;

    height: 75px;

    display: flex;

    align-items: center;

    justify-content: center;

    margin-bottom: 22px;

    border-radius: 50%;

    background:
        rgba(214,168,95,.10);

    border:
        1px solid
        rgba(214,168,95,.25);

    font-size: 38px;

    transition: .4s;

}


.offer-card:hover
.offer-icon {

    transform:
        rotateY(180deg)
        scale(1.08);

}


/* ======================================================
   TITLE
====================================================== */

.offer-card h3 {

    font-family:
        "Cormorant Garamond",
        serif;

    font-size: 30px;

    margin-bottom: 12px;

}


/* ======================================================
   DESCRIPTION
====================================================== */

.offer-card p {

    color: #aaa;

    line-height: 1.7;

    font-size: 14px;

    margin-bottom: 25px;

}


/* ======================================================
   PRICE
====================================================== */

.price {

    font-size: 34px;

    color: #d6a85f;

    font-weight: 700;

}


.old-price {

    color: #777;

    text-decoration:
        line-through;

    font-size: 15px;

    margin-left: 8px;

}


/* ======================================================
   BUTTON
====================================================== */

.offer-btn {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    width: max-content;

    margin-top: auto;

    padding: 12px 25px;

    border:
        1px solid
        #d6a85f;

    border-radius: 30px;

    color: #d6a85f;

    background: transparent;

    cursor: pointer;

    font-size: 14px;

    font-weight: 600;

    transition: .35s;

}


.offer-btn:hover {

    background: #d6a85f;

    color: #111;

}


/* ======================================================
   SPECIAL BANNER
====================================================== */

.special {

    margin:
        20px 8% 100px;

    padding:
        90px 30px;

    text-align: center;

    border-radius: 28px;

    background:

        linear-gradient(
            rgba(0,0,0,.50),
            rgba(0,0,0,.78)
        ),

        url("images/couple-offer.jpg")
        center/cover no-repeat;

    border:
        1px solid
        rgba(214,168,95,.25);

}


.special h2 {

    font-family:
        "Cormorant Garamond",
        serif;

    font-size: 52px;

    margin-bottom: 15px;

}


.special p {

    color: #ddd;

    max-width: 600px;

    margin:
        0 auto 28px;

    line-height: 1.7;

}


.special-btn {

    display: inline-block;

    padding: 14px 35px;

    background: #d6a85f;

    color: #111;

    border-radius: 30px;

    text-decoration: none;

    font-weight: 700;

}


/* ======================================================
   MODAL
====================================================== */

.modal {

    display: none;

    position: fixed;

    inset: 0;

    z-index: 5000;

    background:
        rgba(0,0,0,.82);

    backdrop-filter:
        blur(8px);

    align-items: center;

    justify-content: center;

    padding: 20px;

}


.modal.active {

    display: flex;

}


.modal-box {

    width: 100%;

    max-width: 520px;

    max-height: 90vh;

    overflow-y: auto;

    background: #fffaf4;

    color: #35251d;

    border-radius: 22px;

    padding: 30px;

    position: relative;

    box-shadow:
        0 30px 80px
        rgba(0,0,0,.5);

}


.close {

    position: absolute;

    top: 15px;

    right: 18px;

    width: 35px;

    height: 35px;

    border: none;

    border-radius: 50%;

    background: #35251d;

    color: white;

    font-size: 20px;

    cursor: pointer;

}


.modal-box h2 {

    font-family:
        "Cormorant Garamond",
        serif;

    font-size: 38px;

    margin-bottom: 5px;

}


.modal-subtitle {

    color: #806f61;

    font-size: 13px;

    margin-bottom: 20px;

}


/* ======================================================
   BILL
====================================================== */

.bill {

    background: #f6f1e8;

    padding: 18px;

    border-radius: 14px;

    margin-bottom: 20px;

}


.bill-title {

    font-family:
        "Cormorant Garamond",
        serif;

    font-size: 25px;

    font-weight: 700;

    margin-bottom: 12px;

}


.bill-row {

    display: flex;

    justify-content: space-between;

    padding: 8px 0;

    border-bottom:
        1px solid
        #dfd2c2;

    font-size: 14px;

}


.bill-total {

    font-size: 20px;

    font-weight: 700;

    color: #a47b4c;

    margin-top: 10px;

}


/* ======================================================
   FORM
====================================================== */

.form-group {

    margin-bottom: 15px;

}


.form-group label {

    display: block;

    font-size: 13px;

    font-weight: 700;

    margin-bottom: 6px;

}


.form-group input {

    width: 100%;

    padding: 13px;

    border:
        1px solid
        #d9cbbb;

    border-radius: 9px;

    outline: none;

    font-family: inherit;

}


.payment-title {

    font-family:
        "Cormorant Garamond",
        serif;

    font-size: 25px;

    margin: 18px 0 12px;

}


.payment-options {

    display: flex;

    gap: 10px;

}


.payment-options input {

    display: none;

}


.payment-options label {

    flex: 1;

    text-align: center;

    padding: 12px 5px;

    border:
        1px solid
        #d2c2b1;

    border-radius: 9px;

    cursor: pointer;

    background: white;

    font-size: 13px;

    font-weight: 600;

}


.payment-options input:checked + label {

    background: #35251d;

    color: white;

    border-color: #35251d;

}


/* ======================================================
   UPI QR
====================================================== */

.upi-box {

    display: none;

    margin-top: 18px;

    padding: 18px;

    background: #f6f1e8;

    border-radius: 14px;

    text-align: center;

    border:
        1px solid
        #dfd2c2;

}


.upi-box.show {

    display: block;

}


.upi-box h3 {

    font-family:
        "Cormorant Garamond",
        serif;

    font-size: 26px;

    margin-bottom: 8px;

}


.upi-box p {

    font-size: 13px;

    color: #806f61;

    margin-bottom: 12px;

}


.upi-qr {

    width: 220px;

    height: 220px;

    object-fit: contain;

    display: block;

    margin: auto;

    background: white;

    padding: 8px;

    border-radius: 10px;

}


/* ======================================================
   CONFIRM BUTTON
====================================================== */

.confirm-btn {

    width: 100%;

    border: none;

    background: #35251d;

    color: white;

    padding: 15px;

    border-radius: 10px;

    font-size: 15px;

    font-weight: 700;

    cursor: pointer;

    margin-top: 20px;

}


.confirm-btn:hover {

    background: #a47b4c;

}


/* ======================================================
   SUCCESS
====================================================== */

.success-message {

    text-align: center;

    padding: 25px 5px;

}


.success-icon {

    width: 70px;

    height: 70px;

    display: flex;

    align-items: center;

    justify-content: center;

    margin: auto;

    border-radius: 50%;

    background: #35251d;

    color: white;

    font-size: 35px;

}


.success-message h2 {

    font-family:
        "Cormorant Garamond",
        serif;

    font-size: 38px;

    margin: 15px 0 5px;

}


.success-message p {

    color: #806f61;

    margin: 7px 0;

}


.error-message {

    background: #ffe0e0;

    color: #a52d2d;

    padding: 12px;

    border-radius: 8px;

    margin-bottom: 15px;

    font-size: 13px;

    font-weight: 600;

}


/* ======================================================
   FOOTER
====================================================== */

footer {

    text-align: center;

    padding: 42px 20px;

    background: #050505;

    color: #777;

}


footer strong {

    color: #d6a85f;

}


/* ======================================================
   ANIMATION
====================================================== */

@keyframes heroReveal {

    from {

        opacity: 0;

        transform:
            translateY(50px);

    }

    to {

        opacity: 1;

        transform:
            translateY(0);

    }

}


/* ======================================================
   RESPONSIVE
====================================================== */

@media(max-width:1000px) {

    nav ul {

        gap: 12px;

    }

    .offer-container {

        grid-template-columns:
            repeat(2,1fr);

    }

}


@media(max-width:650px) {

    nav {

        padding: 17px 5%;

    }

    .logo {

        font-size: 27px;

    }

    nav ul {

        display: none;

    }

    .hero {

        min-height: 65vh;

        padding:
            120px 20px 60px;

    }

    .hero h1 {

        font-size: 55px;

    }

    .offers {

        padding:
            75px 5%;

    }

    .offer-container {

        grid-template-columns: 1fr;

    }

    .special {

        margin:
            10px 5% 70px;

        padding:
            70px 20px;

    }

    .special h2 {

        font-size: 40px;

    }

    .payment-options {

        flex-direction: column;

    }

    .modal-box {

        padding: 25px 18px;

    }

}

</style>

</head>


<body>


<!-- ======================================================
     NAVBAR
====================================================== -->

<nav>

    <div class="logo">
        VELOURE
    </div>

    <ul>

        <li>
            <a href="index.php">
                Home
            </a>
        </li>

        <li>
            <a href="about.php">
                About
            </a>
        </li>

        <li>
            <a href="menu.php">
                Menu
            </a>
        </li>

        <li>
            <a href="offers.php">
                Offers
            </a>
        </li>

        <li>
            <a href="gallery.php">
                Gallery
            </a>
        </li>

        <li>
            <a href="services.php">
                Services
            </a>
        </li>

        <li>
            <a href="reservation.php">
                Reservation
            </a>
        </li>

        <li>
            <a href="reviews.php">
                Reviews
            </a>
        </li>

    </ul>

</nav>


<!-- ======================================================
     HERO
====================================================== -->

<section class="hero">

    <div class="hero-content">

        <span>
            EXCLUSIVE EXPERIENCES
        </span>

        <h1>
            Special Offers
        </h1>

        <p>
            Discover exclusive experiences,
            delicious moments and unforgettable
            offers curated specially for you.
        </p>

    </div>

</section>


<!-- ======================================================
     OFFERS
====================================================== -->

<section class="offers">

    <div class="section-title">

        <span>
            LIMITED TIME
        </span>

        <h2>
            Our Exclusive Offers
        </h2>

    </div>


    <div class="offer-container">


        <?php foreach (
            $offers
            as $offerID => $offer
        ): ?>


        <div class="offer-card">


            <div class="badge">

                <?php
                echo htmlspecialchars(
                    $offer["discount"]
                );
                ?>% OFF

            </div>


            <div class="offer-icon">

                <?php
                echo $offer["icon"];
                ?>

            </div>


            <h3>

                <?php
                echo htmlspecialchars(
                    $offer["title"]
                );
                ?>

            </h3>


            <p>

                <?php
                echo htmlspecialchars(
                    $offer["description"]
                );
                ?>

            </p>


            <div>

                <span class="price">

                    ₹<?php
                    echo htmlspecialchars(
                        $offer["price"]
                    );
                    ?>

                </span>


                <span class="old-price">

                    ₹<?php
                    echo htmlspecialchars(
                        $offer["old_price"]
                    );
                    ?>

                </span>

            </div>


            <button
                type="button"
                class="offer-btn"
                onclick="openOffer(
                    '<?php echo $offerID; ?>'
                )"
            >

                <?php

                if ($offerID === "OFFER03") {

                    echo "Book Now";

                }

                elseif ($offerID === "OFFER05") {

                    echo "Reserve Your Table";

                }

                else {

                    echo "Claim Offer";

                }

                ?>

            </button>


        </div>


        <?php endforeach; ?>


    </div>

</section>


<!-- ======================================================
     SPECIAL BANNER
====================================================== -->

<section class="special">

    <h2>
        A Perfect Evening for Two
    </h2>

    <p>
        Make your special moments unforgettable
        with VELOURE's exclusive couple experience.
    </p>

    <button
        type="button"
        class="special-btn"
        onclick="openOffer('OFFER03')"
    >
        Reserve Your Table
    </button>

</section>


<!-- ======================================================
     ORDER MODAL
====================================================== -->

<div
    class="modal <?php
        echo $order_success || $order_error
            ? "active"
            : "";
    ?>"
    id="orderModal"
>


    <div class="modal-box">


        <button
            type="button"
            class="close"
            onclick="closeModal()"
        >
            ×
        </button>


        <?php if ($order_success): ?>


        <!-- ==============================================
             ORDER SUCCESS
        =============================================== -->

        <div class="success-message">


            <div class="success-icon">
                ✓
            </div>


            <h2>
                Order Confirmed!
            </h2>


            <p>
                Thank you for choosing VELOURE Café.
            </p>


            <p>
                <strong>
                    Order ID:
                </strong>

                <?php
                echo htmlspecialchars(
                    $order_id
                );
                ?>
            </p>


            <p>
                Payment:
                <?php
                echo htmlspecialchars(
                    $payment_method
                );
                ?>
            </p>


            <p>
                Status:
                <?php
                echo htmlspecialchars(
                    $payment_status
                );
                ?>
            </p>


            <br>


            <button
                type="button"
                class="confirm-btn"
                onclick="closeModal()"
            >
                Continue
            </button>


        </div>


        <?php else: ?>


        <!-- ==============================================
             ORDER FORM
        =============================================== -->

        <h2>
            Complete Your Order
        </h2>


        <p class="modal-subtitle">
            Enter your details and select payment method.
        </p>


        <?php if ($order_error !== ""): ?>

        <div class="error-message">

            <?php
            echo htmlspecialchars(
                $order_error
            );
            ?>

        </div>

        <?php endif; ?>


        <form
            method="POST"
            action="offers.php"
            id="offerOrderForm"
        >


            <!-- OFFER ID -->

            <input
                type="hidden"
                name="offer_id"
                id="offer_id"
                value="<?php
                    echo htmlspecialchars(
                        $selected_offer
                    );
                ?>"
            >


            <!-- BILL -->

            <div class="bill">


                <div class="bill-title">
                    Order Bill
                </div>


                <div class="bill-row">

                    <span>
                        Offer
                    </span>

                    <strong id="billOffer">
                        -
                    </strong>

                </div>


                <div class="bill-row">

                    <span>
                        Original Price
                    </span>

                    <span id="billOldPrice">
                        -
                    </span>

                </div>


                <div class="bill-row">

                    <span>
                        Discount
                    </span>

                    <span id="billDiscount">
                        -
                    </span>

                </div>


                <div class="bill-row bill-total">

                    <span>
                        Total
                    </span>

                    <span id="billPrice">
                        -
                    </span>

                </div>


            </div>


            <!-- CUSTOMER -->

            <div class="form-group">

                <label>
                    Customer Name *
                </label>

                <input
                    type="text"
                    name="customer_name"
                    value="<?php
                        echo htmlspecialchars(
                            $customer_name
                        );
                    ?>"
                    placeholder="Enter your name"
                    maxlength="60"
                    required
                >

            </div>


            <div class="form-group">

                <label>
                    Mobile Number *
                </label>

                <input
                    type="tel"
                    name="customer_phone"
                    value="<?php
                        echo htmlspecialchars(
                            $customer_phone
                        );
                    ?>"
                    placeholder="10-digit mobile number"
                    maxlength="10"
                    pattern="[0-9]{10}"
                    inputmode="numeric"
                    required
                >

            </div>


            <!-- PAYMENT -->

            <h3 class="payment-title">
                Payment Method
            </h3>


            <div class="payment-options">


                <div>

                    <input
                        type="radio"
                        name="payment_method"
                        id="offerCash"
                        value="Cash"
                        <?php
                        echo $payment_method === "Cash"
                            ? "checked"
                            : "";
                        ?>
                        required
                    >

                    <label for="offerCash">
                        💵 Cash
                    </label>

                </div>


                <div>

                    <input
                        type="radio"
                        name="payment_method"
                        id="offerUPI"
                        value="UPI"
                        <?php
                        echo $payment_method === "UPI"
                            ? "checked"
                            : "";
                        ?>
                    >

                    <label for="offerUPI">
                        📱 UPI
                    </label>

                </div>


                <div>

                    <input
                        type="radio"
                        name="payment_method"
                        id="offerCard"
                        value="Card"
                        <?php
                        echo $payment_method === "Card"
                            ? "checked"
                            : "";
                        ?>
                    >

                    <label for="offerCard">
                        💳 Card
                    </label>

                </div>


            </div>


            <!-- ==========================================
                 ONLY UPI IMAGE
            =========================================== -->

            <div
                class="upi-box"
                id="upiBox"
            >

                <h3>
                    Scan & Pay
                </h3>


                <p>
                    Scan this QR code using
                    your UPI app.
                </p>


                <img
                    src="images/upi-qr.jpg"
                    alt="VELOURE UPI QR Code"
                    class="upi-qr"
                >


                <p>
                    After payment, click
                    Confirm Order.
                </p>

            </div>


            <!-- CONFIRM -->

            <button
                type="submit"
                class="confirm-btn"
            >
                Confirm Order
            </button>


        </form>


        <?php endif; ?>


    </div>

</div>


<!-- ======================================================
     FOOTER
====================================================== -->

<footer>

    © 2026

    <strong>
        VELOURE
    </strong>

    — Crafted for unforgettable moments.

</footer>


<!-- ======================================================
     JAVASCRIPT
====================================================== -->

<script>


// ======================================================
// OFFER DATA
// ======================================================

const offers = <?php

echo json_encode(
    $offers,
    JSON_UNESCAPED_UNICODE
);

?>;


// ======================================================
// OPEN OFFER
// ======================================================

function openOffer(offerID) {


    const offer =
        offers[offerID];


    if (!offer) {

        return;

    }


    document.getElementById(
        "offer_id"
    ).value = offerID;


    document.getElementById(
        "billOffer"
    ).innerText =
        offer.title;


    document.getElementById(
        "billOldPrice"
    ).innerText =
        "₹" + offer.old_price;


    document.getElementById(
        "billDiscount"
    ).innerText =
        offer.discount + "% OFF";


    document.getElementById(
        "billPrice"
    ).innerText =
        "₹" + offer.price;


    document.getElementById(
        "orderModal"
    ).classList.add("active");

}


// ======================================================
// CLOSE MODAL
// ======================================================

function closeModal() {

    document.getElementById(
        "orderModal"
    ).classList.remove("active");

}


// ======================================================
// PAYMENT METHOD
// ======================================================

document
.querySelectorAll(
    'input[name="payment_method"]'
)
.forEach(

    function(radio) {

        radio.addEventListener(
            "change",
            function() {

                const upiBox =
                    document.getElementById(
                        "upiBox"
                    );


                if (
                    this.value === "UPI"
                ) {

                    upiBox.classList.add(
                        "show"
                    );

                }

                else {

                    upiBox.classList.remove(
                        "show"
                    );

                }

            }
        );

    }

);


// ======================================================
// EXISTING UPI SELECTION
// ======================================================

document.addEventListener(
    "DOMContentLoaded",
    function() {

        const selected =
            document.querySelector(
                'input[name="payment_method"]:checked'
            );


        if (
            selected &&
            selected.value === "UPI"
        ) {

            document
                .getElementById("upiBox")
                .classList.add("show");

        }


        // Show selected offer after PHP error
        const selectedOffer =
            document.getElementById(
                "offer_id"
            ).value;


        if (
            selectedOffer &&
            offers[selectedOffer]
        ) {

            const offer =
                offers[selectedOffer];


            document.getElementById(
                "billOffer"
            ).innerText =
                offer.title;


            document.getElementById(
                "billOldPrice"
            ).innerText =
                "₹" + offer.old_price;


            document.getElementById(
                "billDiscount"
            ).innerText =
                offer.discount + "% OFF";


            document.getElementById(
                "billPrice"
            ).innerText =
                "₹" + offer.price;

        }


        // ==================================================
        // SCROLL ANIMATION
        // ==================================================

        const cards =
            document.querySelectorAll(
                ".offer-card"
            );


        const observer =
            new IntersectionObserver(

                function(entries) {

                    entries.forEach(
                        function(entry) {

                            if (
                                entry.isIntersecting
                            ) {

                                entry.target
                                    .classList
                                    .add("show");

                                observer.unobserve(
                                    entry.target
                                );

                            }

                        }
                    );

                },

                {
                    threshold: .12
                }

            );


        cards.forEach(
            function(card) {

                observer.observe(card);

            }
        );

    }
);


// ======================================================
// CLICK OUTSIDE MODAL
// ======================================================

document
.getElementById("orderModal")
.addEventListener(
    "click",
    function(event) {

        if (
            event.target === this
        ) {

            closeModal();

        }

    }
);


</script>


</body>

</html>