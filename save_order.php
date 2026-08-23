<?php

// ==========================================
// VELOURE CAFE - SAVE ORDER
// ==========================================

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: offers.php");
    exit;

}


// ==========================================
// GET DATA
// ==========================================

$customerName =
    trim($_POST["customer_name"] ?? "");

$mobile =
    trim($_POST["mobile"] ?? "");

$email =
    trim($_POST["email"] ?? "");

$offerId =
    trim($_POST["offer_id"] ?? "");

$offerName =
    trim($_POST["offer_name"] ?? "");

$offerType =
    trim($_POST["offer_type"] ?? "percentage");

$item =
    trim($_POST["item"] ?? "");

$quantity =
    (int)($_POST["quantity"] ?? 1);

$price =
    (float)($_POST["price"] ?? 0);

$discount =
    (float)($_POST["discount"] ?? 0);

$comboPrice =
    (float)($_POST["combo_price"] ?? 0);

$paymentMethod =
    trim($_POST["payment_method"] ?? "");


// ==========================================
// VALIDATION
// ==========================================

if(
    $customerName === "" ||
    $mobile === "" ||
    $offerName === "" ||
    $item === "" ||
    $quantity < 1 ||
    $price <= 0 ||
    $paymentMethod === ""
){

    die("
    <div style='
        font-family:Arial;
        text-align:center;
        padding:50px;
    '>

        <h2>⚠️ Please fill all required details.</h2>

        <p>Some order information is missing.</p>

        <br>

        <a href='javascript:history.back()'
           style='
           display:inline-block;
           padding:12px 20px;
           background:#35251d;
           color:white;
           text-decoration:none;
           border-radius:8px;
           '>
           
           ← Go Back

        </a>

    </div>
    ");

}


// ==========================================
// MOBILE VALIDATION
// ==========================================

if(!preg_match("/^[0-9]{10}$/", $mobile)){

    die("
    <div style='
        font-family:Arial;
        text-align:center;
        padding:50px;
    '>

        <h2>⚠️ Invalid Mobile Number</h2>

        <p>Please enter a valid 10-digit mobile number.</p>

        <br>

        <a href='javascript:history.back()'
           style='
           display:inline-block;
           padding:12px 20px;
           background:#35251d;
           color:white;
           text-decoration:none;
           border-radius:8px;
           '>

           ← Go Back

        </a>

    </div>
    ");

}


// ==========================================
// PRICE CALCULATION
// ==========================================

$originalTotal =
    $price * $quantity;

$discountAmount = 0;

$finalPrice = 0;


// ==========================================
// PERCENTAGE OFFER
// ==========================================

if($offerType === "percentage"){

    $discountAmount =
        $originalTotal *
        $discount /
        100;

    $finalPrice =
        $originalTotal -
        $discountAmount;

}


// ==========================================
// BUY 2 GET 1 FREE
// ==========================================

elseif($offerType === "bogo"){

    $freeItems =
        floor($quantity / 3);

    $paidItems =
        $quantity - $freeItems;

    $finalPrice =
        $price * $paidItems;

    $discountAmount =
        $originalTotal -
        $finalPrice;

}


// ==========================================
// COFFEE + DESSERT COMBO
// ==========================================

elseif($offerType === "combo"){

    if($comboPrice <= 0){

        $comboPrice = 249;

    }

    $finalPrice =
        $comboPrice * $quantity;

    $discountAmount =
        max(
            0,
            $originalTotal -
            $finalPrice
        );

}


// ==========================================
// FALLBACK
// ==========================================

else{

    $finalPrice =
        $originalTotal;

    $discountAmount =
        0;

}


// ==========================================
// ROUND
// ==========================================

$originalTotal =
    round($originalTotal, 2);

$discountAmount =
    round($discountAmount, 2);

$finalPrice =
    round($finalPrice, 2);


// ==========================================
// ORDER ID
// ==========================================

date_default_timezone_set("Asia/Kolkata");

$orderId =
    "ORD" .
    date("YmdHis") .
    rand(100,999);


// ==========================================
// DATE / TIME
// ==========================================

$orderDate =
    date("d-m-Y");

$orderTime =
    date("h:i A");


// ==========================================
// CSV FILE
// ==========================================

$csvFile =
    __DIR__ . "/orders.csv";


// ==========================================
// HEADERS
// ==========================================

$headers = [

    "Order ID",
    "Customer Name",
    "Mobile",
    "Email",
    "Offer ID",
    "Offer Name",
    "Offer Type",
    "Item",
    "Quantity",
    "Price Per Item",
    "Original Total",
    "Discount %",
    "Discount Amount",
    "Final Price",
    "Payment Method",
    "Status",
    "Order Date",
    "Order Time"

];


// ==========================================
// OPEN CSV
// ==========================================

$file =
    fopen($csvFile, "a");


if($file === false){

    die("
    <div style='
        font-family:Arial;
        text-align:center;
        padding:50px;
    '>

        <h2>❌ Unable to save order.</h2>

        <p>Please check the orders.csv file.</p>

    </div>
    ");

}


// ==========================================
// HEADER IF EMPTY
// ==========================================

if(filesize($csvFile) === 0){

    fputcsv(
        $file,
        $headers
    );

}


// ==========================================
// ORDER DATA
// ==========================================

$orderData = [

    $orderId,

    $customerName,

    $mobile,

    $email,

    $offerId,

    $offerName,

    $offerType,

    $item,

    $quantity,

    number_format(
        $price,
        2,
        ".",
        ""
    ),

    number_format(
        $originalTotal,
        2,
        ".",
        ""
    ),

    number_format(
        $discount,
        2,
        ".",
        ""
    ),

    number_format(
        $discountAmount,
        2,
        ".",
        ""
    ),

    number_format(
        $finalPrice,
        2,
        ".",
        ""
    ),

    $paymentMethod,

    "Pending",

    $orderDate,

    $orderTime

];


// ==========================================
// SAVE
// ==========================================

fputcsv(
    $file,
    $orderData
);

fclose($file);

?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>Order Confirmed | Veloure Café</title>

<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=DM+Sans:wght@400;500;600&display=swap"
      rel="stylesheet">

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

    font-family:"DM Sans",sans-serif;

    background:#f6f1e8;

    color:#35251d;

}

.success-box{

    width:100%;

    max-width:600px;

    background:white;

    padding:50px 35px;

    border-radius:25px;

    text-align:center;

    box-shadow:
    0 25px 70px
    rgba(50,30,20,.15);

    animation:showBox .7s ease;

}

.check{

    width:85px;

    height:85px;

    margin:0 auto 25px;

    display:flex;

    align-items:center;

    justify-content:center;

    border-radius:50%;

    background:#dff0df;

    font-size:45px;

    animation:checkAnimation .8s ease;

}

h1{

    font-family:"Cormorant Garamond",serif;

    font-size:48px;

    margin-bottom:10px;

}

.message{

    color:#806f61;

    line-height:1.7;

    margin-bottom:25px;

}

.order-id{

    background:#f6f1e8;

    padding:15px;

    border-radius:12px;

    margin-bottom:20px;

}

.order-id span{

    display:block;

    font-size:12px;

    color:#806f61;

    margin-bottom:5px;

}

.order-id strong{

    font-size:22px;

    color:#a47b4c;

}

.details{

    text-align:left;

    background:#fffaf3;

    border-radius:15px;

    padding:20px;

    margin-bottom:25px;

}

.detail-row{

    display:flex;

    justify-content:space-between;

    gap:20px;

    padding:9px 0;

    border-bottom:1px solid #eee3d6;

    font-size:14px;

}

.detail-row:last-child{

    border-bottom:none;

}

.detail-row strong{

    text-align:right;

}

.total{

    font-size:20px;

    color:#a47b4c;

}

.buttons{

    display:flex;

    gap:12px;

}

.btn{

    flex:1;

    padding:13px;

    border-radius:10px;

    text-decoration:none;

    font-weight:600;

    transition:.3s;

}

.home{

    background:#35251d;

    color:white;

}

.offers{

    background:#eadcc9;

    color:#35251d;

}

.btn:hover{

    transform:translateY(-3px);

}

@keyframes showBox{

    from{

        opacity:0;

        transform:translateY(35px) scale(.96);

    }

    to{

        opacity:1;

        transform:translateY(0) scale(1);

    }

}

@keyframes checkAnimation{

    0%{
        transform:scale(0);
    }

    70%{
        transform:scale(1.15);
    }

    100%{
        transform:scale(1);
    }

}

@media(max-width:500px){

    .success-box{
        padding:40px 20px;
    }

    h1{
        font-size:40px;
    }

    .buttons{
        flex-direction:column;
    }

}

</style>

</head>

<body>

<div class="success-box">

<div class="check">
✓
</div>

<h1>
Order Confirmed!
</h1>

<p class="message">

Thank you for choosing Veloure Café.
Your order has been successfully received.

</p>


<div class="order-id">

<span>
ORDER ID
</span>

<strong>
<?php echo htmlspecialchars($orderId); ?>
</strong>

</div>


<div class="details">


<div class="detail-row">

<span>
Customer
</span>

<strong>
<?php echo htmlspecialchars($customerName); ?>
</strong>

</div>


<div class="detail-row">

<span>
Offer
</span>

<strong>
<?php echo htmlspecialchars($offerName); ?>
</strong>

</div>


<div class="detail-row">

<span>
Item
</span>

<strong>
<?php echo htmlspecialchars($item); ?>
</strong>

</div>


<div class="detail-row">

<span>
Quantity
</span>

<strong>
<?php echo $quantity; ?>
</strong>

</div>


<div class="detail-row">

<span>
Payment
</span>

<strong>
<?php echo htmlspecialchars($paymentMethod); ?>
</strong>

</div>


<div class="detail-row">

<span>
Total
</span>

<strong class="total">

₹<?php
echo number_format(
    $finalPrice,
    2
);
?>

</strong>

</div>

</div>


<div class="buttons">

<a href="offers.php"
   class="btn offers">

← Back to Offers

</a>

<a href="index.php"
   class="btn home">

Go to Home

</a>

</div>

</div>

</body>

</html>