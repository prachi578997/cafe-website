
<?php

$offers = [

    "OFFER01" => [
        "title" => "Coffee Lover's Deal",
        "discount" => 20,
        "items" => "Cappuccino, Latte, Mocha, Americano",
        "description" => "Enjoy your favourite handcrafted coffee with an exclusive 20% discount.",
        "type" => "percentage"
    ],

    "OFFER02" => [
        "title" => "Buy 2 Get 1 Free",
        "discount" => 0,
        "items" => "Cold Coffee, Iced Latte, Frappuccino",
        "description" => "Order 2 selected beverages and get 1 selected beverage free.",
        "type" => "bogo"
    ],

    "OFFER03" => [
        "title" => "Coffee & Dessert Combo",
        "discount" => 0,
        "items" => "Cappuccino + Chocolate Cake",
        "description" => "Enjoy a delicious coffee and dessert at a special combo price.",
        "type" => "combo",
        "combo_price" => 249
    ],

    "OFFER04" => [
        "title" => "Premium Coffee Special",
        "discount" => 15,
        "items" => "Caramel Macchiato, Hazelnut Coffee",
        "description" => "Enjoy premium signature coffees with an exclusive discount.",
        "type" => "percentage"
    ]

];

$offerID = $_GET["offer"] ?? "OFFER01";

if (!isset($offers[$offerID])) {
    $offerID = "OFFER01";
}

$offer = $offers[$offerID];

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>VELOURE Café | Order</title>

<link rel="preconnect" href="https://fonts.googleapis.com">

<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:"DM Sans",sans-serif;
    background:#f6f1e8;
    color:#35251d;
    min-height:100vh;
}

.navbar{
    height:75px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:0 7%;
    background:rgba(246,241,232,.96);
    backdrop-filter:blur(15px);
    border-bottom:1px solid #e4d8c8;
}

.logo{
    text-decoration:none;
    color:#35251d;
    text-align:center;
}

.logo h1{
    font-family:"Cormorant Garamond",serif;
    font-size:32px;
    letter-spacing:2px;
}

.logo span{
    display:block;
    font-size:9px;
    letter-spacing:3px;
    color:#a47b4c;
    margin-top:-5px;
}

.back{
    text-decoration:none;
    color:#35251d;
    font-weight:600;
    padding:10px 18px;
    border:1px solid #c9b39a;
    border-radius:25px;
    transition:.3s;
}

.back:hover{
    background:#35251d;
    color:white;
}

.order-section{
    min-height:calc(100vh - 75px);
    display:flex;
    align-items:center;
    justify-content:center;
    padding:50px 20px;
}

.order-box{
    width:100%;
    max-width:1000px;
    background:#fff;
    border-radius:25px;
    overflow:hidden;
    display:grid;
    grid-template-columns:40% 60%;
    box-shadow:0 25px 70px rgba(50,30,20,.15);
    animation:boxAnimation .8s ease;
}

.offer-side{
    background:#35251d;
    color:#fff;
    padding:45px;
    display:flex;
    flex-direction:column;
    justify-content:center;
    position:relative;
    overflow:hidden;
}

.offer-side::before{
    content:"";
    position:absolute;
    width:300px;
    height:300px;
    background:#a47b4c;
    opacity:.15;
    border-radius:50%;
    top:-100px;
    right:-100px;
    animation:float 6s infinite ease-in-out;
}

.offer-label{
    color:#d4b27f;
    letter-spacing:4px;
    font-size:11px;
    font-weight:700;
    margin-bottom:15px;
}

.offer-side h2{
    font-family:"Cormorant Garamond",serif;
    font-size:48px;
    line-height:1;
    margin-bottom:20px;
}

.offer-description{
    color:#d8c9bb;
    line-height:1.7;
    font-size:14px;
    margin-bottom:25px;
}

.offer-info{
    border-top:1px solid rgba(255,255,255,.2);
    padding-top:20px;
}

.offer-info div{
    margin:10px 0;
    color:#eadfd4;
    font-size:14px;
}

.discount{
    display:inline-block;
    background:#c9a878;
    color:#35251d;
    padding:8px 14px;
    border-radius:20px;
    font-weight:700;
}

.form-side{
    padding:45px;
}

.form-side h1{
    font-family:"Cormorant Garamond",serif;
    font-size:42px;
    margin-bottom:5px;
}

.form-subtitle{
    color:#806f61;
    font-size:13px;
    margin-bottom:30px;
}

.form-group{
    margin-bottom:18px;
}

.form-group label{
    display:block;
    font-size:13px;
    font-weight:600;
    margin-bottom:7px;
}

.form-group input,
.form-group select{
    width:100%;
    padding:13px 15px;
    border:1px solid #ddd0bf;
    border-radius:10px;
    outline:none;
    background:#fffdf9;
    color:#35251d;
    font-family:"DM Sans",sans-serif;
    transition:.3s;
}

.form-group input:focus,
.form-group select:focus{
    border-color:#a47b4c;
    box-shadow:0 0 0 3px rgba(164,123,76,.12);
}

.quantity-box{
    display:flex;
    align-items:center;
    gap:10px;
}

.quantity-box button{
    width:40px;
    height:40px;
    border:none;
    border-radius:8px;
    background:#35251d;
    color:white;
    font-size:20px;
    cursor:pointer;
    transition:.3s;
}

.quantity-box button:hover{
    background:#a47b4c;
}

.quantity-box input{
    text-align:center;
    max-width:70px;
}

.offer-hint{
    display:block;
    margin-top:8px;
    color:#a47b4c;
    font-size:12px;
}

.price-box{
    background:#f6f1e8;
    border-radius:15px;
    padding:20px;
    margin:20px 0;
}

.price-row{
    display:flex;
    justify-content:space-between;
    margin:9px 0;
    font-size:14px;
}

.total-row{
    border-top:1px solid #d8c8b5;
    padding-top:14px;
    margin-top:14px;
    font-size:20px;
    font-weight:700;
}

.total-price{
    color:#a47b4c;
}

.confirm-btn{
    width:100%;
    padding:15px;
    border:none;
    border-radius:12px;
    background:#35251d;
    color:#fff;
    font-weight:700;
    font-size:15px;
    cursor:pointer;
    transition:.35s;
}

.confirm-btn:hover{
    background:#a47b4c;
    transform:translateY(-3px);
    box-shadow:0 10px 25px rgba(164,123,76,.25);
}

@keyframes boxAnimation{
    from{
        opacity:0;
        transform:translateY(40px) scale(.97);
    }
    to{
        opacity:1;
        transform:translateY(0) scale(1);
    }
}

@keyframes float{
    0%,100%{
        transform:translateY(0);
    }
    50%{
        transform:translateY(25px);
    }
}

@media(max-width:800px){

    .order-box{
        grid-template-columns:1fr;
    }

    .offer-side{
        padding:35px;
    }

    .offer-side h2{
        font-size:40px;
    }

    .form-side{
        padding:30px;
    }
}

</style>

</head>

<body>

<nav class="navbar">

    <a href="index.php" class="logo">
        <h1>VELOURE</h1>
        <span>ARTISAN CAFÉ</span>
    </a>

    <a href="offers.php" class="back">
        ← Back to Offers
    </a>

</nav>


<section class="order-section">

<div class="order-box">


<div class="offer-side">

    <div class="offer-label">
        SELECTED OFFER
    </div>

    <h2>
        <?php echo htmlspecialchars($offer["title"]); ?>
    </h2>

    <p class="offer-description">
        <?php echo htmlspecialchars($offer["description"]); ?>
    </p>

    <div class="offer-info">

        <div>
            🎁 <strong>Offer:</strong>

            <span class="discount">

            <?php

            if($offer["type"] === "percentage"){

                echo $offer["discount"] . "% OFF";

            }
            elseif($offer["type"] === "bogo"){

                echo "BUY 2 GET 1 FREE";

            }
            else{

                echo "₹" . $offer["combo_price"] . " COMBO";

            }

            ?>

            </span>
        </div>

        <div>
            ☕ <strong>Applicable Items:</strong><br>

            <?php echo htmlspecialchars($offer["items"]); ?>

        </div>

    </div>

</div>


<div class="form-side">

<h1>Place Your Order</h1>

<p class="form-subtitle">
    Enter your details and confirm your order.
</p>


<form action="save_order.php" method="POST" id="orderForm">


<input type="hidden"
       name="offer_id"
       value="<?php echo htmlspecialchars($offerID); ?>">


<input type="hidden"
       name="offer_name"
       value="<?php echo htmlspecialchars($offer["title"]); ?>">


<input type="hidden"
       name="offer_type"
       value="<?php echo htmlspecialchars($offer["type"]); ?>">


<input type="hidden"
       name="discount"
       id="discount"
       value="<?php echo (float)$offer["discount"]; ?>">


<input type="hidden"
       name="combo_price"
       value="<?php echo isset($offer["combo_price"]) ? $offer["combo_price"] : 0; ?>">


<div class="form-group">

<label>Customer Name *</label>

<input type="text"
       name="customer_name"
       placeholder="Enter your full name"
       required>

</div>


<div class="form-group">

<label>Mobile Number *</label>

<input type="tel"
       name="mobile"
       id="mobile"
       placeholder="Enter 10-digit mobile number"
       pattern="[0-9]{10}"
       maxlength="10"
       inputmode="numeric"
       required>

</div>


<div class="form-group">

<label>Email</label>

<input type="email"
       name="email"
       placeholder="Enter email address">

</div>


<div class="form-group">

<label>Select Item *</label>

<select name="item" required>

<option value="">Select an item</option>

<?php

$items = explode(",", $offer["items"]);

foreach($items as $item){

    $item = trim($item);

    if($item === "") continue;

    echo '<option value="' .
         htmlspecialchars($item) .
         '">' .
         htmlspecialchars($item) .
         '</option>';

}

?>

</select>

</div>


<div class="form-group">

<label>Quantity *</label>

<div class="quantity-box">

<button type="button"
        onclick="changeQuantity(-1)">
    −
</button>

<input type="number"
       name="quantity"
       id="quantity"
       value="1"
       min="1"
       max="20"
       readonly>

<button type="button"
        onclick="changeQuantity(1)">
    +
</button>

</div>

</div>


<div class="form-group">

<label>Item Price (₹) *</label>

<input type="number"
       name="price"
       id="price"
       placeholder="Enter item price"
       min="1"
       step="0.01"
       required>

<small class="offer-hint" id="offerHint"></small>

</div>


<div class="form-group">

<label>Payment Method *</label>

<select name="payment_method" required>

<option value="">
    Select payment method
</option>

<option value="UPI">
    UPI
</option>

<option value="Card">
    Card
</option>

<option value="Cash at Café">
    Cash at Café
</option>

</select>

</div>


<div class="price-box">

<div class="price-row">

<span>Original Price</span>

<strong>
₹<span id="originalPrice">0.00</span>
</strong>

</div>


<div class="price-row">

<span>Discount</span>

<strong>
- ₹<span id="discountAmount">0.00</span>
</strong>

</div>


<div class="price-row total-row">

<span>Total</span>

<strong class="total-price">
₹<span id="totalPrice">0.00</span>
</strong>

</div>

</div>


<input type="hidden"
       name="discount_amount"
       id="discountAmountInput"
       value="0">


<input type="hidden"
       name="final_price"
       id="finalPriceInput"
       value="0">


<button type="submit"
        class="confirm-btn">

    Confirm Order →

</button>


</form>

</div>

</div>

</section>


<script>

const offerType =
"<?php echo $offer["type"]; ?>";

const discount =
parseFloat(
    document.getElementById("discount").value
) || 0;

const comboPrice =
<?php
echo isset($offer["combo_price"])
    ? (float)$offer["combo_price"]
    : 0;
?>;


function changeQuantity(value){

    const input =
        document.getElementById("quantity");

    let quantity =
        parseInt(input.value) || 1;

    quantity += value;

    if(quantity < 1){
        quantity = 1;
    }

    if(quantity > 20){
        quantity = 20;
    }

    input.value = quantity;

    calculatePrice();
}


function calculatePrice(){

    const price =
        parseFloat(
            document.getElementById("price").value
        ) || 0;

    const quantity =
        parseInt(
            document.getElementById("quantity").value
        ) || 1;


    let originalPrice = 0;

    let discountAmount = 0;

    let finalPrice = 0;


    /* =========================
       NORMAL DISCOUNT
    ========================= */

    if(offerType === "percentage"){

        originalPrice =
            price * quantity;

        discountAmount =
            originalPrice * discount / 100;

        finalPrice =
            originalPrice - discountAmount;

    }


    /* =========================
       BUY 2 GET 1 FREE
    ========================= */

    else if(offerType === "bogo"){

        originalPrice =
            price * quantity;

        const freeItems =
            Math.floor(quantity / 3);

        const paidItems =
            quantity - freeItems;

        finalPrice =
            price * paidItems;

        discountAmount =
            originalPrice - finalPrice;

    }


    /* =========================
       COMBO
    ========================= */

    else if(offerType === "combo"){

        originalPrice =
            price * quantity;

        finalPrice =
            comboPrice * quantity;

        discountAmount =
            Math.max(
                0,
                originalPrice - finalPrice
            );

    }


    document.getElementById("originalPrice")
        .textContent =
        originalPrice.toFixed(2);


    document.getElementById("discountAmount")
        .textContent =
        discountAmount.toFixed(2);


    document.getElementById("totalPrice")
        .textContent =
        finalPrice.toFixed(2);


    document.getElementById("discountAmountInput")
        .value =
        discountAmount.toFixed(2);


    document.getElementById("finalPriceInput")
        .value =
        finalPrice.toFixed(2);


    const hint =
        document.getElementById("offerHint");


    if(offerType === "percentage"){

        hint.textContent =
            "✨ " + discount +
            "% discount automatically applied.";

    }

    else if(offerType === "bogo"){

        hint.textContent =
            "🎁 Every 3rd selected beverage is FREE.";

    }

    else if(offerType === "combo"){

        hint.textContent =
            "☕🍰 Special combo price: ₹" +
            comboPrice;

    }

}


document.getElementById("price")
.addEventListener(
    "input",
    calculatePrice
);


document.getElementById("mobile")
.addEventListener(
    "input",
    function(){

        this.value =
            this.value.replace(
                /[^0-9]/g,
                ""
            );

    }
);


document.getElementById("orderForm")
.addEventListener(
    "submit",
    function(event){

        const price =
            parseFloat(
                document.getElementById("price").value
            ) || 0;

        if(price <= 0){

            event.preventDefault();

            alert(
                "Please enter a valid item price."
            );

            return;
        }

        calculatePrice();

    }
);


calculatePrice();

</script>

</body>
</html>