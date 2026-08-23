<?php

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: menu.php");

    exit;
}


/* =========================
   GET FORM DATA
========================= */

$name =
    trim($_POST["name"] ?? "");

$phone =
    trim($_POST["phone"] ?? "");

$coffee =
    trim($_POST["coffee"] ?? "");

$size =
    trim($_POST["size"] ?? "");

$milk =
    trim($_POST["milk"] ?? "");

$sweetness =
    trim($_POST["sweetness"] ?? "");

$topping =
    trim($_POST["topping"] ?? "");

$payment =
    trim($_POST["payment"] ?? "");


/* =========================
   VALIDATION
========================= */

if (
    $name === "" ||
    $phone === "" ||
    $coffee === "" ||
    $size === "" ||
    $payment === ""
) {

    die("Please fill all required details.");

}


if (!preg_match("/^[0-9]{10}$/", $phone)) {

    die("Please enter a valid 10 digit mobile number.");

}


/* =========================
   COFFEE PRICE
========================= */

$coffeePrices = [

    "Classic Coffee" => 120,

    "Espresso" => 100,

    "Cappuccino" => 150,

    "Mocha" => 170,

    "Cold Coffee" => 150,

    "Iced Coffee" => 160,

    "Frappé" => 190,

    "Signature Coffee" => 220

];


/* =========================
   SIZE PRICE
========================= */

$sizePrices = [

    "Small" => 0,

    "Medium" => 30,

    "Large" => 50

];


/* =========================
   MILK PRICE
========================= */

$milkPrices = [

    "Regular Milk" => 0,

    "Almond Milk" => 30,

    "Oat Milk" => 25,

    "Soy Milk" => 20

];


/* =========================
   SWEETNESS PRICE
========================= */

$sweetnessPrices = [

    "Normal" => 0,

    "Less Sugar" => 0,

    "No Sugar" => 0,

    "Extra Sweet" => 10

];


/* =========================
   TOPPING PRICE
========================= */

$toppingPrices = [

    "No Topping" => 0,

    "Whipped Cream" => 20,

    "Chocolate" => 25,

    "Caramel" => 20,

    "Hazelnut" => 30

];


/* =========================
   CALCULATE TOTAL
========================= */

$total =

    ($coffeePrices[$coffee] ?? 0)

    +

    ($sizePrices[$size] ?? 0)

    +

    ($milkPrices[$milk] ?? 0)

    +

    ($sweetnessPrices[$sweetness] ?? 0)

    +

    ($toppingPrices[$topping] ?? 0);


/* =========================
   SAVE ORDER
========================= */

$file = "order.csv";

$handle = fopen($file, "a");


if (!$handle) {

    die("Order could not be saved.");

}


if (filesize($file) == 0) {

    fputcsv(
        $handle,
        [
            "Date",
            "Name",
            "Phone",
            "Coffee",
            "Size",
            "Milk",
            "Sweetness",
            "Topping",
            "Payment",
            "Total"
        ]
    );

}


fputcsv(
    $handle,
    [
        date("Y-m-d H:i:s"),
        $name,
        $phone,
        $coffee,
        $size,
        $milk,
        $sweetness,
        $topping,
        $payment,
        $total
    ]
);


fclose($handle);

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
Order Confirmed | VELOURE
</title>


<style>

* {
    box-sizing: border-box;
}

body {

    margin: 0;

    min-height: 100vh;

    display: flex;

    justify-content: center;

    align-items: center;

    background: #f7f1e9;

    font-family: Arial, sans-serif;

    color: #38271f;

}


.confirm-box {

    width: 90%;

    max-width: 550px;

    background: #fffaf4;

    padding: 45px 30px;

    border-radius: 25px;

    text-align: center;

    box-shadow:
        0 20px 60px
        rgba(0,0,0,0.12);

}


.confirm-box h1 {

    font-family: Georgia, serif;

    font-size: 42px;

    margin-bottom: 15px;

}


.confirm-box p {

    color: #756359;

    line-height: 1.7;

}


.order-details {

    margin: 25px 0;

    padding: 20px;

    background: #f7f1e9;

    border-radius: 15px;

    text-align: left;

}


.order-details p {

    margin: 8px 0;

}


.total {

    font-size: 32px;

    font-weight: bold;

    color: #a66c43;

    margin: 20px 0;

}


.back-btn {

    display: inline-block;

    padding: 13px 28px;

    background: #4b3024;

    color: white;

    text-decoration: none;

    border-radius: 30px;

}


.back-btn:hover {

    background: #a66c43;

}

</style>

</head>


<body>


<div class="confirm-box">

    <h1>
        Order Confirmed ☕
    </h1>


    <p>
        Thank you,
        <strong>
            <?php echo htmlspecialchars($name); ?>
        </strong>
    </p>


    <p>
        Your VELOURE custom coffee order
        has been successfully placed.
    </p>


    <div class="order-details">

        <p>
            <strong>Coffee:</strong>
            <?php echo htmlspecialchars($coffee); ?>
        </p>

        <p>
            <strong>Size:</strong>
            <?php echo htmlspecialchars($size); ?>
        </p>

        <p>
            <strong>Milk:</strong>
            <?php echo htmlspecialchars($milk); ?>
        </p>

        <p>
            <strong>Sweetness:</strong>
            <?php echo htmlspecialchars($sweetness); ?>
        </p>

        <p>
            <strong>Topping:</strong>
            <?php echo htmlspecialchars($topping); ?>
        </p>

        <p>
            <strong>Payment:</strong>
            <?php echo htmlspecialchars($payment); ?>
        </p>

    </div>


    <div class="total">

        ₹<?php echo number_format($total); ?>

    </div>


    <a
        href="menu.php"
        class="back-btn"
    >
        Back To Menu
    </a>

</div>


</body>

</html>