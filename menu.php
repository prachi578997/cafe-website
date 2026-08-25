<?php

/* =========================================================
   VELOURE MENU + RESERVATION + BUILD YOUR COFFEE
   CSV + GOOGLE SHEET + UPI QR
========================================================= */

date_default_timezone_set("Asia/Kolkata");

$orderSuccess = false;
$orderError = "";


/* =========================================================
   GOOGLE APPS SCRIPT URL
========================================================= */

$googleScriptUrl =
"https://script.google.com/macros/s/AKfycbzRqE9u-c5RuoGC7ZA2MWp2de4Decqymz5yH6AZRdSP6XlT7HQU5FCHrmeTLoliBB51/exec";


/* =========================================================
   PRICE ARRAYS
========================================================= */

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

$sizePrices = [
    "Small" => 0,
    "Medium" => 30,
    "Large" => 50
];

$milkPrices = [
    "Regular Milk" => 0,
    "Almond Milk" => 30,
    "Oat Milk" => 25,
    "Soy Milk" => 20
];

$sweetnessPrices = [
    "Normal" => 0,
    "Less Sugar" => 0,
    "No Sugar" => 0,
    "Extra Sweet" => 10
];

$toppingPrices = [
    "No Topping" => 0,
    "Whipped Cream" => 20,
    "Chocolate" => 25,
    "Caramel" => 20,
    "Hazelnut" => 30
];


/* =========================================================
   BUILD YOUR COFFEE - PHP SAVE
========================================================= */

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"] ?? "");
    $phone = trim($_POST["phone"] ?? "");
    $coffee = trim($_POST["coffee"] ?? "");
    $size = trim($_POST["size"] ?? "");
    $milk = trim($_POST["milk"] ?? "Regular Milk");
    $sweetness = trim($_POST["sweetness"] ?? "Normal");
    $topping = trim($_POST["topping"] ?? "No Topping");
    $payment = trim($_POST["payment"] ?? "");

    $paymentStatus = "Pending";

    if (
        $name === "" ||
        $phone === "" ||
        $coffee === "" ||
        $size === "" ||
        $payment === ""
    ) {

        $orderError = "Please fill all required details.";

    } elseif (!preg_match("/^[0-9]{10}$/", $phone)) {

        $orderError = "Please enter a valid 10 digit mobile number.";

    } elseif (!isset($coffeePrices[$coffee])) {

        $orderError = "Please select a valid coffee.";

    } elseif (!isset($sizePrices[$size])) {

        $orderError = "Please select a valid size.";

    } elseif (!isset($milkPrices[$milk])) {

        $orderError = "Please select a valid milk.";

    } elseif (!isset($sweetnessPrices[$sweetness])) {

        $orderError = "Please select a valid sweetness.";

    } elseif (!isset($toppingPrices[$topping])) {

        $orderError = "Please select a valid topping.";

    } else {

        $total =
            $coffeePrices[$coffee] +
            $sizePrices[$size] +
            $milkPrices[$milk] +
            $sweetnessPrices[$sweetness] +
            $toppingPrices[$topping];

        if ($total <= 0) {

            $orderError = "Please select a valid coffee.";

        } else {

            /* =================================================
               RENDER-SAFE DATA FOLDER
            ================================================= */

            $dataFolder = __DIR__ . "/data";

            if (!is_dir($dataFolder)) {
                @mkdir($dataFolder, 0775, true);
            }

            $file = $dataFolder . "/order.csv";

            $newFile =
                !file_exists($file) ||
                filesize($file) === 0;

            $handle = @fopen($file, "a");

            if ($handle) {

                if ($newFile) {

                    fputcsv($handle, [
                        "Date",
                        "Name",
                        "Phone",
                        "Coffee",
                        "Size",
                        "Milk",
                        "Sweetness",
                        "Topping",
                        "Payment Method",
                        "Total",
                        "Payment Status"
                    ]);
                }

                fputcsv($handle, [
                    date("Y-m-d H:i:s"),
                    $name,
                    $phone,
                    $coffee,
                    $size,
                    $milk,
                    $sweetness,
                    $topping,
                    $payment,
                    $total,
                    $paymentStatus
                ]);

                fclose($handle);

                $orderSuccess = true;

            } else {

                $orderError =
                    "Unable to save order. Please check folder permission.";

            }
        }
    }
}


/* =========================================================
   MENU
========================================================= */

$menu = [

    "Coffee" => [
        ["Classic Coffee",120,"classic-coffee.jpg"],
        ["Espresso Bar",100,"espresso.jpg"],
        ["Cappuccino Collection",150,"cappuccino.jpg"],
        ["Mocha Collection",170,"mocha.jpg"],
        ["Cold Coffee",150,"cold-coffee.jpg"],
        ["Iced Coffee",160,"iced-coffee.jpg"],
        ["Frappé Collection",190,"frappe.jpg"],
        ["Flavoured Coffee",180,"flavoured-coffee.jpg"],
        ["Signature Coffee",220,"signature-coffee.jpg"]
    ],

    "Tea & Refreshers" => [
        ["Classic Tea",80,"classic-tea.jpg"],
        ["Masala Tea",90,"masala-tea.jpg"],
        ["Green Tea",100,"green-tea.jpg"],
        ["Herbal Tea",110,"herbal-tea.jpg"],
        ["Iced Tea",120,"iced-tea.jpg"],
        ["Mint Refreshers",130,"mint-refreshers.jpg"],
        ["Fruit Refreshers",150,"fruit-refreshers.jpg"]
    ],

    "Mocktails" => [
        ["Fruit Mojito",160,"fruit-mojito.jpg"],
        ["Berry Coolers",170,"berry-cooler.jpg"],
        ["Tropical Coolers",180,"tropical-cooler.jpg"],
        ["Passion Fruit",170,"passion-fruit.jpg"],
        ["Watermelon Drinks",150,"watermelon-drink.jpg"]
    ],

    "Snacks & Starters" => [
        ["French Fries",120,"french-fries.jpg"],
        ["Peri Peri Fries",140,"peri-peri-fries.jpg"],
        ["Garlic Bread",130,"garlic-bread.jpg"],
        ["Nachos",170,"nachos.jpg"],
        ["Bruschetta",180,"bruschetta.jpg"],
        ["Light Bites",180,"light-bites.jpg"]
    ],

    "Café Specials" => [
        ["Veg Burgers",180,"veg-burger.jpg"],
        ["Sandwiches",170,"sandwich.jpg"],
        ["Wraps",180,"wraps.jpg"],
        ["Pizza",250,"pizza.jpg"],
        ["Pasta",240,"pasta.jpg"],
        ["Café Combos",350,"cafe-combo.jpg"]
    ],

    "Desserts" => [
        ["Brownies",150,"brownie.jpg"],
        ["Lava Cakes",200,"lava-cake.jpg"],
        ["Cheesecakes",220,"cheesecake.jpg"],
        ["Waffles",180,"waffles.jpg"],
        ["Pancakes",190,"pancakes.jpg"]
    ],

    "Healthy" => [
        ["Fresh Fruit Bowls",180,"fruit-bowl.jpg"],
        ["Greek Yogurt Bowls",200,"greek-yogurt.jpg"],
        ["Paneer Salads",220,"paneer-salad.jpg"],
        ["Avocado Toast",230,"avocado-toast.jpg"],
        ["Smoothie Bowls",220,"smoothie-bowl.jpg"]
    ],

    "Signature / Premium" => [
        ["Signature Coffee",220,"signature-coffee.jpg"],
        ["Premium Latte",240,"premium-latte.jpg"],
        ["Royal Frappé",260,"royal-frappe.jpg"],
        ["Premium Burger",320,"premium-burger.jpg"],
        ["Chef's Special Pizza",350,"chef-special-pizza.jpg"],
        ["Luxury Dessert Platter",450,"luxury-dessert.jpg"]
    ],

    "American Café Favourites" => [
        ["Loaded Fries",220,"american-loaded-fries.jpg"],
        ["Mac & Cheese",240,"mac-cheese.jpg"],
        ["Hot Dogs",230,"hot-dog.jpg"],
        ["Crispy Chicken",280,"crispy-chicken.jpg"],
        ["American-Style Desserts",250,"american-dessert.jpg"]
    ]
];


/* =========================================================
   DESCRIPTIONS
========================================================= */

$descriptions = [

    "Classic Coffee" => "Rich and aromatic classic coffee, freshly brewed for a smooth and comforting taste.",
    "Espresso Bar" => "Strong and bold espresso with a rich aroma and perfectly balanced flavour.",
    "Cappuccino Collection" => "Creamy cappuccino topped with velvety milk foam for a smooth coffee experience.",
    "Mocha Collection" => "A delicious blend of rich chocolate and freshly brewed coffee with a creamy finish.",
    "Cold Coffee" => "Refreshing chilled coffee blended with creamy milk for a smooth and delicious taste.",
    "Iced Coffee" => "Cool and refreshing iced coffee served chilled for a perfect coffee break.",
    "Frappé Collection" => "Creamy blended frappé with a refreshing texture and delightful coffee flavour.",
    "Flavoured Coffee" => "Aromatic coffee infused with delicious flavours for a unique experience.",
    "Signature Coffee" => "VELOURE's signature coffee crafted with premium ingredients and rich unforgettable taste.",

    "Classic Tea" => "Freshly brewed classic tea with a soothing aroma and refreshing taste.",
    "Masala Tea" => "Traditional Indian tea infused with aromatic spices.",
    "Green Tea" => "Light and refreshing green tea made for a calm experience.",
    "Herbal Tea" => "Soothing herbal tea prepared with refreshing natural ingredients.",
    "Iced Tea" => "Chilled tea with a refreshing flavour.",
    "Mint Refreshers" => "Cool and refreshing mint drink with a fresh flavour.",
    "Fruit Refreshers" => "Refreshing fruit-based drink bursting with fruity flavours.",

    "Fruit Mojito" => "Refreshing fruit mojito blended with citrus flavours and mint.",
    "Berry Coolers" => "Refreshing berry cooler packed with sweet and tangy flavours.",
    "Tropical Coolers" => "Refreshing tropical drink inspired by exotic fruits.",
    "Passion Fruit" => "Sweet and tangy passion fruit refresher.",
    "Watermelon Drinks" => "Fresh and juicy watermelon drink served chilled.",

    "French Fries" => "Golden crispy French fries seasoned perfectly and served hot.",
    "Peri Peri Fries" => "Crispy fries tossed with spicy peri peri seasoning.",
    "Garlic Bread" => "Freshly baked bread topped with aromatic garlic butter.",
    "Nachos" => "Crunchy nachos loaded with delicious toppings.",
    "Bruschetta" => "Crispy toasted bread topped with fresh ingredients.",
    "Light Bites" => "A delicious selection of light and tasty snacks.",

    "Veg Burgers" => "Juicy and flavourful vegetarian burger with fresh ingredients.",
    "Sandwiches" => "Freshly prepared sandwiches filled with delicious ingredients.",
    "Wraps" => "Soft wraps filled with fresh vegetables and tasty fillings.",
    "Pizza" => "Freshly baked pizza topped with delicious ingredients and cheese.",
    "Pasta" => "Creamy and flavourful pasta prepared with fresh ingredients.",
    "Café Combos" => "A perfect combination of popular café favourites.",

    "Brownies" => "Rich and fudgy chocolate brownies with a soft centre.",
    "Lava Cakes" => "Warm chocolate cake with a delicious molten centre.",
    "Cheesecakes" => "Creamy and smooth cheesecake with a delicate base.",
    "Waffles" => "Golden crispy waffles served with delicious toppings.",
    "Pancakes" => "Soft and fluffy pancakes prepared fresh.",

    "Fresh Fruit Bowls" => "A colourful bowl of fresh seasonal fruits.",
    "Greek Yogurt Bowls" => "Creamy Greek yogurt topped with fresh fruits.",
    "Paneer Salads" => "Fresh vegetables combined with flavourful paneer.",
    "Avocado Toast" => "Crispy toast topped with creamy avocado.",
    "Smoothie Bowls" => "Thick and creamy fruit smoothie bowl.",

    "Premium Latte" => "Smooth and creamy premium latte.",
    "Royal Frappé" => "Luxurious creamy frappé crafted with premium ingredients.",
    "Premium Burger" => "Premium burger with delicious fillings.",
    "Chef's Special Pizza" => "Chef's special pizza loaded with premium toppings.",
    "Luxury Dessert Platter" => "Elegant platter featuring VELOURE's finest desserts.",

    "Loaded Fries" => "Crispy fries loaded with delicious toppings.",
    "Mac & Cheese" => "Creamy macaroni pasta blended with rich melted cheese.",
    "Hot Dogs" => "Soft hot dog bun with delicious toppings.",
    "Crispy Chicken" => "Crispy golden chicken with a flavourful coating.",
    "American-Style Desserts" => "Delicious American-inspired desserts."
];

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>VELOURE | Menu</title>

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

html{
    scroll-behavior:smooth;
}

body{
    font-family:"DM Sans",sans-serif;
    background:#f7f1e9;
    color:#38271f;
}

.navbar{
    position:sticky;
    top:0;
    z-index:999;
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:18px 5%;
    background:#fffaf4;
    box-shadow:0 5px 20px rgba(0,0,0,.08);
}

.logo{
    font-family:"Cormorant Garamond",serif;
    font-size:34px;
    font-weight:700;
    letter-spacing:4px;
    color:#4b3024;
}

.logo span{
    color:#a66c43;
}

.nav-links{
    display:flex;
    gap:18px;
    align-items:center;
    flex-wrap:wrap;
}

.nav-links a{
    text-decoration:none;
    color:#392820;
    font-size:13px;
    font-weight:600;
}

.nav-links a:hover{
    color:#a66c43;
}

.reserve-btn{
    text-decoration:none;
    background:#4b3024;
    color:white;
    padding:12px 20px;
    border-radius:30px;
    font-size:12px;
}

.hero{
    padding:120px 7% 80px;
    text-align:center;
    background:
    radial-gradient(circle at 20% 30%,rgba(166,108,67,.18),transparent 30%),
    radial-gradient(circle at 80% 70%,rgba(80,50,35,.12),transparent 30%);
}

.eyebrow{
    color:#a66c43;
    letter-spacing:5px;
    font-size:12px;
    text-transform:uppercase;
}

.hero h1{
    font-family:"Cormorant Garamond",serif;
    font-size:80px;
    line-height:.9;
    margin:20px 0;
}

.hero h1 span{
    color:#a66c43;
    font-style:italic;
}

.hero p{
    max-width:650px;
    margin:auto;
    color:#756359;
    line-height:1.8;
}

.menu-section{
    padding:80px 6%;
    background:#fffaf4;
}

.section-heading{
    text-align:center;
    margin-bottom:40px;
}

.section-heading small{
    color:#a66c43;
    letter-spacing:4px;
}

.section-heading h2{
    font-family:"Cormorant Garamond",serif;
    font-size:52px;
    margin:10px 0;
}

.section-heading p{
    color:#756359;
}

.filters{
    display:flex;
    justify-content:center;
    flex-wrap:wrap;
    gap:10px;
    margin-bottom:60px;
}

.filter-btn{
    border:1px solid #d8c7b7;
    background:transparent;
    padding:10px 18px;
    border-radius:30px;
    cursor:pointer;
    color:#4b3024;
    font-weight:600;
}

.filter-btn.active,
.filter-btn:hover{
    background:#4b3024;
    color:white;
}

.menu-category{
    max-width:1250px;
    margin:0 auto 70px;
}

.category-title{
    display:flex;
    align-items:center;
    gap:15px;
    margin-bottom:25px;
}

.category-title h3{
    font-family:"Cormorant Garamond",serif;
    font-size:38px;
}

.category-line{
    flex:1;
    height:1px;
    background:#dfd0c3;
}

.menu-grid{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:22px;
}

.menu-card{
    background:white;
    border-radius:18px;
    overflow:hidden;
    box-shadow:0 8px 25px rgba(0,0,0,.07);
    transition:.3s;
}

.menu-card:hover{
    transform:translateY(-6px);
}

.food-image{
    height:220px;
    overflow:hidden;
    cursor:pointer;
    position:relative;
    display:block;
    text-decoration:none;
}

.food-image img{
    width:100%;
    height:100%;
    object-fit:cover;
    display:block;
    transition:.4s;
}

.food-image:hover img{
    transform:scale(1.05);
}

.image-price{
    position:absolute;
    right:12px;
    bottom:12px;
    background:#4b3024;
    color:white;
    padding:8px 15px;
    border-radius:22px;
    font-size:14px;
    font-weight:700;
}

.food-image:hover .image-price{
    background:#a66c43;
}

.image-reserve-label{
    position:absolute;
    left:12px;
    bottom:12px;
    background:rgba(255,250,244,.95);
    color:#4b3024;
    padding:8px 13px;
    border-radius:20px;
    font-size:11px;
    font-weight:700;
    opacity:0;
    transform:translateY(5px);
    transition:.3s;
}

.food-image:hover .image-reserve-label{
    opacity:1;
    transform:translateY(0);
}

.menu-content{
    padding:18px;
}

.menu-content h4{
    font-family:"Cormorant Garamond",serif;
    font-size:24px;
    margin-bottom:8px;
}

.menu-content p{
    color:#8a776a;
    font-size:12px;
    line-height:1.6;
    min-height:58px;
}

.price-row{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:10px;
    margin-top:15px;
}

.price{
    color:#a66c43;
    font-size:18px;
    font-weight:bold;
}

.reservation-item-btn{
    border:none;
    cursor:pointer;
    background:#4b3024;
    color:white;
    padding:10px 16px;
    border-radius:25px;
    font-size:11px;
    font-weight:700;
    transition:.3s;
}

.reservation-item-btn:hover{
    background:#a66c43;
    transform:translateY(-2px);
}


/* =========================================================
   BUILD COFFEE
========================================================= */

.build-coffee{
    max-width:1250px;
    margin:20px auto 70px;
    padding:55px 45px;
    background:linear-gradient(135deg,#4b3024,#241713);
    border-radius:28px;
    color:white;
}

.build-title{
    text-align:center;
    margin-bottom:35px;
}

.build-title small{
    color:#d09a70;
    letter-spacing:4px;
    font-size:11px;
}

.build-title h2{
    font-family:"Cormorant Garamond",serif;
    font-size:52px;
    margin:8px 0;
}

.build-title p{
    color:rgba(255,255,255,.7);
}

.build-form{
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:20px;
}

.build-group label{
    display:block;
    margin-bottom:8px;
    color:#eadcc9;
    font-size:13px;
    font-weight:600;
}

.build-group select,
.build-group input{
    width:100%;
    padding:14px;
    border:none;
    outline:none;
    border-radius:10px;
    background:#fffaf4;
    color:#38271f;
    font-family:inherit;
}

.payment-box,
.qr-box,
.payment-status,
.bill-details,
.price-box,
.build-btn{
    grid-column:1/-1;
}

.qr-box{
    display:none;
    text-align:center;
    background:#fffaf4;
    color:#38271f;
    padding:30px;
    border-radius:18px;
}

.qr-box.show{
    display:block;
}

.qr-box img{
    width:210px;
    height:210px;
    object-fit:contain;
    display:block;
    margin:15px auto;
    border-radius:10px;
    border:5px solid white;
    box-shadow:0 5px 20px rgba(0,0,0,.15);
}

.qr-box h3{
    font-family:"Cormorant Garamond",serif;
    font-size:30px;
}

.qr-box p{
    font-size:13px;
    color:#756359;
    margin:7px 0;
}

#qrAmount{
    display:block;
    font-size:34px;
    color:#a66c43;
    font-weight:bold;
}

.payment-status{
    display:none;
    background:#fff3cd;
    color:#735c00;
    padding:15px;
    border-radius:12px;
    text-align:center;
    font-size:13px;
    font-weight:600;
}

.payment-status.show{
    display:block;
}

.bill-details{
    background:rgba(255,255,255,.06);
    border:1px solid rgba(255,255,255,.12);
    border-radius:15px;
    padding:20px;
}

.bill-details h3{
    font-family:"Cormorant Garamond",serif;
    font-size:28px;
    margin-bottom:12px;
    text-align:center;
}

.bill-row{
    display:flex;
    justify-content:space-between;
    padding:9px 0;
    color:#eadcc9;
    font-size:13px;
    border-bottom:1px solid rgba(255,255,255,.08);
}

.bill-total{
    display:flex;
    justify-content:space-between;
    font-size:20px;
    font-weight:bold;
    color:#d6a36f;
    padding-top:14px;
}

.price-box{
    text-align:center;
    padding:25px;
    background:rgba(255,255,255,.08);
    border-radius:15px;
}

.price-box span{
    display:block;
    color:#cdb8a5;
    font-size:11px;
    letter-spacing:3px;
    margin-bottom:5px;
}

#coffeeTotal{
    display:block;
    color:#d6a36f;
    font-family:"Cormorant Garamond",serif;
    font-size:44px;
    font-weight:bold;
}

.build-btn{
    border:none;
    padding:15px;
    border-radius:30px;
    background:#c18a61;
    color:white;
    font-size:14px;
    font-weight:bold;
    cursor:pointer;
}

.build-btn:hover{
    background:#d09a70;
}

.success{
    margin:20px auto;
    padding:20px;
    text-align:center;
    background:#e8f6e8;
    color:#245c2a;
    border-radius:15px;
    font-weight:bold;
}

.error{
    margin:20px auto;
    padding:20px;
    text-align:center;
    background:#ffe9e9;
    color:#9b2226;
    border-radius:15px;
    font-weight:bold;
}


/* =========================================================
   FLOATING RESERVATION
========================================================= */

.reservation-count-box{
    position:fixed;
    right:25px;
    bottom:25px;
    z-index:9998;
}

.reservation-count-btn{
    display:flex;
    align-items:center;
    gap:8px;
    background:#4b3024;
    color:white;
    text-decoration:none;
    padding:13px 20px;
    border-radius:30px;
    font-size:13px;
    font-weight:700;
    box-shadow:0 8px 25px rgba(0,0,0,.25);
}

#reservationCount{
    background:#c18a61;
    min-width:25px;
    height:25px;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
}

footer{
    background:#241713;
    color:white;
    text-align:center;
    padding:40px 20px;
}

.footer-logo{
    font-family:"Cormorant Garamond",serif;
    font-size:35px;
    letter-spacing:5px;
}

footer p{
    margin-top:8px;
    opacity:.6;
}

@media(max-width:1100px){

    .menu-grid{
        grid-template-columns:repeat(3,1fr);
    }

}

@media(max-width:800px){

    .nav-links{
        display:none;
    }

    .menu-grid{
        grid-template-columns:repeat(2,1fr);
    }

    .build-form{
        grid-template-columns:1fr;
    }

    .hero h1{
        font-size:60px;
    }

}

@media(max-width:550px){

    .menu-grid{
        grid-template-columns:1fr;
    }

    .hero h1{
        font-size:48px;
    }

    .section-heading h2{
        font-size:40px;
    }

    .build-coffee{
        padding:40px 20px;
    }

    .build-title h2{
        font-size:40px;
    }

    .qr-box img{
        width:180px;
        height:180px;
    }

    .reservation-count-box{
        right:15px;
        bottom:15px;
    }

}

</style>

</head>

<body>


<!-- =========================================================
   NAVBAR
========================================================= -->

<nav class="navbar">

    <div class="logo">
        VELOU<span>RE</span>
    </div>

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

    <a href="reservation.php" class="reserve-btn">
        Reserve Table
    </a>

</nav>


<!-- =========================================================
   HERO
========================================================= -->

<section class="hero">

    <div class="eyebrow">
        Curated With Passion
    </div>

    <h1>
        The VELOURE
        <br>
        <span>Menu</span>
    </h1>

    <p>
        Discover handcrafted coffee,
        refreshing drinks, delicious café favourites
        and signature creations made especially
        for unforgettable moments.
    </p>

</section>


<!-- =========================================================
   MENU
========================================================= -->

<section class="menu-section">

<div class="section-heading">

    <small>EXPLORE OUR SELECTION</small>

    <h2>
        Crafted For Every Craving
    </h2>

    <p>
        From your first morning coffee
        to an indulgent evening dessert.
    </p>

</div>


<!-- FILTER -->

<div class="filters">

    <button
        class="filter-btn active"
        data-filter="all"
        type="button"
    >
        All
    </button>

    <?php foreach($menu as $category => $items): ?>

        <?php

        $filter = strtolower(
            preg_replace(
                '/[^a-z0-9]+/',
                '-',
                $category
            )
        );

        ?>

        <button
            class="filter-btn"
            data-filter="<?php echo htmlspecialchars($filter); ?>"
            type="button"
        >
            <?php echo htmlspecialchars($category); ?>
        </button>

    <?php endforeach; ?>

</div>


<!-- =========================================================
   MENU CATEGORIES
========================================================= -->

<?php foreach($menu as $category => $items): ?>

<?php

$categoryClass = strtolower(
    preg_replace(
        '/[^a-z0-9]+/',
        '-',
        $category
    )
);

?>

<div
    class="menu-category"
    data-category="<?php echo htmlspecialchars($categoryClass); ?>"
>

<div class="category-title">

    <h3>
        <?php echo htmlspecialchars($category); ?>
    </h3>

    <div class="category-line"></div>

</div>


<div class="menu-grid">

<?php foreach($items as $item): ?>

<?php

$itemName = $item[0];
$itemPrice = $item[1];
$itemImage = $item[2];

?>

<div
    class="menu-card"
    data-item-name="<?php echo htmlspecialchars($itemName,ENT_QUOTES); ?>"
    data-item-price="<?php echo (float)$itemPrice; ?>"
>


<!-- IMAGE -->

<a
    href="#"
    class="food-image reservation-image-link"

    data-name="<?php echo htmlspecialchars($itemName,ENT_QUOTES); ?>"

    data-price="<?php echo (float)$itemPrice; ?>"
>

<img
    src="images/<?php echo htmlspecialchars($itemImage); ?>"
    alt="<?php echo htmlspecialchars($itemName); ?>"
    onerror="this.src='images/default-food.jpg';"
>

<span class="image-price">
    ₹<?php echo number_format($itemPrice); ?>
</span>

<span class="image-reserve-label">
    + Reservation
</span>

</a>


<!-- CONTENT -->

<div class="menu-content">

<h4>
    <?php echo htmlspecialchars($itemName); ?>
</h4>

<p>

<?php

echo htmlspecialchars(
    $descriptions[$itemName]
    ??
    "A delicious creation specially prepared by VELOURE."
);

?>

</p>


<div class="price-row">

<span class="price">
    ₹<?php echo number_format($itemPrice); ?>
</span>

<button
    type="button"
    class="reservation-item-btn add-reservation-btn"

    data-name="<?php echo htmlspecialchars($itemName,ENT_QUOTES); ?>"

    data-price="<?php echo (float)$itemPrice; ?>"
>
    + Reservation
</button>

</div>

</div>

</div>

<?php endforeach; ?>

</div>

</div>

<?php endforeach; ?>


<!-- =========================================================
   BUILD YOUR COFFEE
========================================================= -->

<div class="build-coffee" id="build-coffee">

<div class="build-title">

<small>
    YOUR COFFEE · YOUR WAY
</small>

<h2>
    Build Your Coffee
</h2>

<p>
    Create your perfect coffee exactly the way you like it.
</p>

</div>


<?php if($orderSuccess): ?>

<div class="success">

    ✅ Order placed successfully!

    <br><br>

    Your order has been saved in
    <strong>data/order.csv</strong>.

</div>

<?php endif; ?>


<?php if($orderError !== ""): ?>

<div class="error">

    ❌ <?php echo htmlspecialchars($orderError); ?>

</div>

<?php endif; ?>


<form
    class="build-form"
    method="POST"
    action="menu.php#build-coffee"
    id="buildCoffeeForm"
>


<!-- COFFEE -->

<div class="build-group">

<label>
    Coffee Type *
</label>

<select
    name="coffee"
    id="coffeeType"
    required
>

<option value="" data-price="0">
    Select Coffee
</option>

<option value="Classic Coffee" data-price="120">
    Classic Coffee — ₹120
</option>

<option value="Espresso" data-price="100">
    Espresso — ₹100
</option>

<option value="Cappuccino" data-price="150">
    Cappuccino — ₹150
</option>

<option value="Mocha" data-price="170">
    Mocha — ₹170
</option>

<option value="Cold Coffee" data-price="150">
    Cold Coffee — ₹150
</option>

<option value="Iced Coffee" data-price="160">
    Iced Coffee — ₹160
</option>

<option value="Frappé" data-price="190">
    Frappé — ₹190
</option>

<option value="Signature Coffee" data-price="220">
    Signature Coffee — ₹220
</option>

</select>

</div>


<!-- SIZE -->

<div class="build-group">

<label>
    Size *
</label>

<select
    name="size"
    id="coffeeSize"
    required
>

<option value="" data-price="0">
    Select Size
</option>

<option value="Small" data-price="0">
    Small — +₹0
</option>

<option value="Medium" data-price="30">
    Medium — +₹30
</option>

<option value="Large" data-price="50">
    Large — +₹50
</option>

</select>

</div>


<!-- MILK -->

<div class="build-group">

<label>
    Milk
</label>

<select
    name="milk"
    id="coffeeMilk"
>

<option value="Regular Milk" data-price="0">
    Regular Milk — +₹0
</option>

<option value="Almond Milk" data-price="30">
    Almond Milk — +₹30
</option>

<option value="Oat Milk" data-price="25">
    Oat Milk — +₹25
</option>

<option value="Soy Milk" data-price="20">
    Soy Milk — +₹20
</option>

</select>

</div>


<!-- SWEETNESS -->

<div class="build-group">

<label>
    Sweetness
</label>

<select
    name="sweetness"
    id="coffeeSweetness"
>

<option value="Normal" data-price="0">
    Normal — +₹0
</option>

<option value="Less Sugar" data-price="0">
    Less Sugar — +₹0
</option>

<option value="No Sugar" data-price="0">
    No Sugar — +₹0
</option>

<option value="Extra Sweet" data-price="10">
    Extra Sweet — +₹10
</option>

</select>

</div>


<!-- TOPPING -->

<div class="build-group">

<label>
    Toppings
</label>

<select
    name="topping"
    id="coffeeTopping"
>

<option value="No Topping" data-price="0">
    No Topping — +₹0
</option>

<option value="Whipped Cream" data-price="20">
    Whipped Cream — +₹20
</option>

<option value="Chocolate" data-price="25">
    Chocolate — +₹25
</option>

<option value="Caramel" data-price="20">
    Caramel — +₹20
</option>

<option value="Hazelnut" data-price="30">
    Hazelnut — +₹30
</option>

</select>

</div>
<!-- =========================================================
   PART 2 — BODY + MENU + BUILD YOUR COFFEE + JAVASCRIPT
========================================================= -->

<body>

<!-- =========================================================
   NAVBAR
========================================================= -->

<nav class="navbar">

    <div class="logo">
        VELOU<span>RE</span>
    </div>

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

    <a href="reservation.php" class="reserve-btn">
        Reserve Table
    </a>

</nav>


<!-- =========================================================
   HERO
========================================================= -->

<section class="hero">

    <div class="eyebrow">
        Curated With Passion
    </div>

    <h1>
        The VELOURE
        <br>
        <span>Menu</span>
    </h1>

    <p>
        Discover handcrafted coffee,
        refreshing drinks, delicious café favourites
        and signature creations made especially
        for unforgettable moments.
    </p>

</section>


<!-- =========================================================
   MENU
========================================================= -->

<section class="menu-section">

<div class="section-heading">

    <small>EXPLORE OUR SELECTION</small>

    <h2>
        Crafted For Every Craving
    </h2>

    <p>
        From your first morning coffee
        to an indulgent evening dessert.
    </p>

</div>


<!-- =========================================================
   FILTER BUTTONS
========================================================= -->

<div class="filters">

    <button
        class="filter-btn active"
        data-filter="all"
        type="button"
    >
        All
    </button>

    <?php foreach($menu as $category => $items): ?>

        <?php
        $filter = strtolower(
            preg_replace(
                '/[^a-z0-9]+/',
                '-',
                $category
            )
        );
        ?>

        <button
            class="filter-btn"
            data-filter="<?php echo htmlspecialchars($filter); ?>"
            type="button"
        >
            <?php echo htmlspecialchars($category); ?>
        </button>

    <?php endforeach; ?>

</div>


<!-- =========================================================
   MENU CATEGORIES
========================================================= -->

<?php foreach($menu as $category => $items): ?>

<?php

$categoryClass = strtolower(
    preg_replace(
        '/[^a-z0-9]+/',
        '-',
        $category
    )
);

?>

<div
    class="menu-category"
    data-category="<?php echo htmlspecialchars($categoryClass); ?>"
>

    <div class="category-title">

        <h3>
            <?php echo htmlspecialchars($category); ?>
        </h3>

        <div class="category-line"></div>

    </div>


    <div class="menu-grid">

    <?php foreach($items as $item): ?>

        <?php

        $itemName  = $item[0];
        $itemPrice = $item[1];
        $itemImage = $item[2];

        ?>

        <div
            class="menu-card"
            data-item-name="<?php echo htmlspecialchars($itemName, ENT_QUOTES); ?>"
            data-item-price="<?php echo (float)$itemPrice; ?>"
        >

            <!-- IMAGE -->

            <a
                href="#"
                class="food-image reservation-image-link"
                data-name="<?php echo htmlspecialchars($itemName, ENT_QUOTES); ?>"
                data-price="<?php echo (float)$itemPrice; ?>"
            >

                <img
                    src="images/<?php echo htmlspecialchars($itemImage); ?>"
                    alt="<?php echo htmlspecialchars($itemName); ?>"
                    onerror="this.src='images/default-food.jpg';"
                >

                <span class="image-price">
                    ₹<?php echo number_format($itemPrice); ?>
                </span>

                <span class="image-reserve-label">
                    + Reservation
                </span>

            </a>


            <!-- CONTENT -->

            <div class="menu-content">

                <h4>
                    <?php echo htmlspecialchars($itemName); ?>
                </h4>

                <p>
                    <?php
                    echo htmlspecialchars(
                        $descriptions[$itemName]
                        ??
                        "A delicious creation specially prepared by VELOURE."
                    );
                    ?>
                </p>


                <div class="price-row">

                    <span class="price">
                        ₹<?php echo number_format($itemPrice); ?>
                    </span>

                    <button
                        type="button"
                        class="reservation-item-btn add-reservation-btn"
                        data-name="<?php echo htmlspecialchars($itemName, ENT_QUOTES); ?>"
                        data-price="<?php echo (float)$itemPrice; ?>"
                    >
                        + Reservation
                    </button>

                </div>

            </div>

        </div>

    <?php endforeach; ?>

    </div>

</div>

<?php endforeach; ?>


<!-- =========================================================
   BUILD YOUR COFFEE
   THIS PART IS KEPT
========================================================= -->

<div class="build-coffee" id="build-coffee">

<div class="build-title">

    <small>
        YOUR COFFEE · YOUR WAY
    </small>

    <h2>
        Build Your Coffee
    </h2>

    <p>
        Create your perfect coffee exactly the way you like it.
    </p>

</div>


<?php if($orderSuccess): ?>

<div class="success">

    ✅ Order placed successfully!

    <br><br>

    Your order has been saved in
    <strong>order.csv</strong>.

</div>

<?php endif; ?>


<?php if($orderError !== ""): ?>

<div class="error">

    ❌ <?php echo htmlspecialchars($orderError); ?>

</div>

<?php endif; ?>


<form
    class="build-form"
    method="POST"
    action="menu.php#build-coffee"
    id="buildCoffeeForm"
>

    <!-- COFFEE -->

    <div class="build-group">

        <label>
            Coffee Type *
        </label>

        <select
            name="coffee"
            id="coffeeType"
            required
        >

            <option value="" data-price="0">
                Select Coffee
            </option>

            <option value="Classic Coffee" data-price="120">
                Classic Coffee — ₹120
            </option>

            <option value="Espresso" data-price="100">
                Espresso — ₹100
            </option>

            <option value="Cappuccino" data-price="150">
                Cappuccino — ₹150
            </option>

            <option value="Mocha" data-price="170">
                Mocha — ₹170
            </option>

            <option value="Cold Coffee" data-price="150">
                Cold Coffee — ₹150
            </option>

            <option value="Iced Coffee" data-price="160">
                Iced Coffee — ₹160
            </option>

            <option value="Frappé" data-price="190">
                Frappé — ₹190
            </option>

            <option value="Signature Coffee" data-price="220">
                Signature Coffee — ₹220
            </option>

        </select>

    </div>


    <!-- SIZE -->

    <div class="build-group">

        <label>
            Size *
        </label>

        <select
            name="size"
            id="coffeeSize"
            required
        >

            <option value="" data-price="0">
                Select Size
            </option>

            <option value="Small" data-price="0">
                Small — +₹0
            </option>

            <option value="Medium" data-price="30">
                Medium — +₹30
            </option>

            <option value="Large" data-price="50">
                Large — +₹50
            </option>

        </select>

    </div>


    <!-- MILK -->

    <div class="build-group">

        <label>
            Milk
        </label>

        <select
            name="milk"
            id="coffeeMilk"
        >

            <option value="Regular Milk" data-price="0">
                Regular Milk — +₹0
            </option>

            <option value="Almond Milk" data-price="30">
                Almond Milk — +₹30
            </option>

            <option value="Oat Milk" data-price="25">
                Oat Milk — +₹25
            </option>

            <option value="Soy Milk" data-price="20">
                Soy Milk — +₹20
            </option>

        </select>

    </div>


    <!-- SWEETNESS -->

    <div class="build-group">

        <label>
            Sweetness
        </label>

        <select
            name="sweetness"
            id="coffeeSweetness"
        >

            <option value="Normal" data-price="0">
                Normal — +₹0
            </option>

            <option value="Less Sugar" data-price="0">
                Less Sugar — +₹0
            </option>

            <option value="No Sugar" data-price="0">
                No Sugar — +₹0
            </option>

            <option value="Extra Sweet" data-price="10">
                Extra Sweet — +₹10
            </option>

        </select>

    </div>


    <!-- TOPPING -->

    <div class="build-group">

        <label>
            Toppings
        </label>

        <select
            name="topping"
            id="coffeeTopping"
        >

            <option value="No Topping" data-price="0">
                No Topping — +₹0
            </option>

            <option value="Whipped Cream" data-price="20">
                Whipped Cream — +₹20
            </option>

            <option value="Chocolate" data-price="25">
                Chocolate — +₹25
            </option>

            <option value="Caramel" data-price="20">
                Caramel — +₹20
            </option>

            <option value="Hazelnut" data-price="30">
                Hazelnut — +₹30
            </option>

        </select>

    </div>


    <!-- NAME -->

    <div class="build-group">

        <label>
            Your Name *
        </label>

        <input
            type="text"
            name="name"
            placeholder="Enter your name"
            required
        >

    </div>


    <!-- PHONE -->

    <div class="build-group">

        <label>
            Mobile Number *
        </label>

        <input
            type="tel"
            name="phone"
            placeholder="10 digit mobile number"
            maxlength="10"
            pattern="[0-9]{10}"
            required
        >

    </div>


    <!-- PAYMENT -->

    <div class="build-group payment-box">

        <label>
            Payment Method *
        </label>

        <select
            name="payment"
            id="paymentMethod"
            required
        >

            <option value="">
                Select Payment Method
            </option>

            <option value="Cash">
                Cash
            </option>

            <option value="UPI">
                UPI
            </option>

            <option value="Card">
                Card
            </option>

        </select>

    </div>


    <!-- UPI QR -->

    <div class="qr-box" id="qrBox">

        <h3>
            UPI Payment
        </h3>

        <p>
            Scan this QR Code to pay your bill.
        </p>

        <img
            src="images/upi-qr.jpg"
            alt="VELOURE UPI QR Code"
            id="upiQrImage"
            onerror="this.style.display='none';"
        >

        <p>
            Amount to Pay
        </p>

        <strong id="qrAmount">
            ₹0
        </strong>

        <p>
            Please complete the payment using the QR code.
        </p>

    </div>


    <!-- PAYMENT STATUS -->

    <div
        class="payment-status"
        id="paymentStatus"
    >

        ⚠️ UPI Payment Status:
        <strong>Pending</strong>

        <br>

        Please complete payment using the QR code.

    </div>


    <!-- BILL -->

    <div class="bill-details">

        <h3>
            Your Bill
        </h3>

        <div class="bill-row">
            <span>Coffee</span>
            <strong id="billCoffee">₹0</strong>
        </div>

        <div class="bill-row">
            <span>Size</span>
            <strong id="billSize">₹0</strong>
        </div>

        <div class="bill-row">
            <span>Milk</span>
            <strong id="billMilk">₹0</strong>
        </div>

        <div class="bill-row">
            <span>Sweetness</span>
            <strong id="billSweetness">₹0</strong>
        </div>

        <div class="bill-row">
            <span>Topping</span>
            <strong id="billTopping">₹0</strong>
        </div>

        <div class="bill-total">
            <span>Total Bill</span>
            <strong id="billTotal">₹0</strong>
        </div>

    </div>


    <!-- TOTAL -->

    <div class="price-box">

        <span>
            YOUR COFFEE PRICE
        </span>

        <strong id="coffeeTotal">
            ₹0
        </strong>

    </div>


    <button
        type="submit"
        class="build-btn"
    >
        Create My Coffee
    </button>

</form>

</div>

</section>


<!-- =========================================================
   FLOATING RESERVATION
========================================================= -->

<div class="reservation-count-box">

    <a
        href="reservation.php"
        class="reservation-count-btn"
    >

        Reservation

        <span id="reservationCount">
            0
        </span>

    </a>

</div>


<!-- =========================================================
   FOOTER
========================================================= -->

<footer>

    <div class="footer-logo">
        VELOURE
    </div>

    <p>
        © 2026 VELOURE Artisan Café.
        All Rights Reserved.
    </p>

</footer>


<!-- =========================================================
   JAVASCRIPT
========================================================= -->

<script>

document.addEventListener("DOMContentLoaded", function () {

    /* =====================================================
       GOOGLE APPS SCRIPT
    ===================================================== */

    const GOOGLE_SCRIPT_URL =
        "https://script.google.com/macros/s/AKfycbzRqE9u-c5RuoGC7ZA2MWp2de4Decqymz5yH6AZRdSP6XlT7HQU5FCHrmeTLoliBB51/exec";


    /* =====================================================
       MENU FILTER
    ===================================================== */

    const filterButtons =
        document.querySelectorAll(".filter-btn");

    const categories =
        document.querySelectorAll(".menu-category");

    filterButtons.forEach(function (button) {

        button.addEventListener("click", function () {

            const filter =
                this.getAttribute("data-filter");

            filterButtons.forEach(function (btn) {
                btn.classList.remove("active");
            });

            this.classList.add("active");

            categories.forEach(function (category) {

                const categoryName =
                    category.getAttribute("data-category");

                if (
                    filter === "all" ||
                    categoryName === filter
                ) {

                    category.style.display = "block";

                } else {

                    category.style.display = "none";

                }

            });

        });

    });


    /* =====================================================
       RESERVATION STORAGE
       ONLY ONE ITEM AT A TIME
    ===================================================== */

    let selectedReservations = [];

    try {

        selectedReservations =
            JSON.parse(
                localStorage.getItem(
                    "veloureReservations"
                )
            ) || [];

        if (!Array.isArray(selectedReservations)) {
            selectedReservations = [];
        }

    } catch (error) {

        selectedReservations = [];

    }


    function saveReservations() {

        localStorage.setItem(
            "veloureReservations",
            JSON.stringify(selectedReservations)
        );

    }


    function updateReservationCount() {

        const countElement =
            document.getElementById("reservationCount");

        if (!countElement) {
            return;
        }

        countElement.textContent =
            selectedReservations.length;

    }


    /* =====================================================
       MESSAGE
    ===================================================== */

    function showReservationMessage(message) {

        let box =
            document.getElementById(
                "reservationMessage"
            );

        if (!box) {

            box =
                document.createElement("div");

            box.id =
                "reservationMessage";

            box.style.position = "fixed";
            box.style.top = "90px";
            box.style.right = "25px";
            box.style.zIndex = "99999";
            box.style.background = "#4b3024";
            box.style.color = "#fff";
            box.style.padding = "14px 22px";
            box.style.borderRadius = "30px";
            box.style.fontSize = "13px";
            box.style.fontWeight = "600";
            box.style.boxShadow =
                "0 8px 25px rgba(0,0,0,.25)";

            document.body.appendChild(box);

        }

        box.textContent =
            "✓ " + message;

        box.style.display = "block";

        clearTimeout(
            window.reservationMessageTimer
        );

        window.reservationMessageTimer =
            setTimeout(function () {

                box.style.display = "none";

            }, 2500);

    }


    /* =====================================================
       ADD RESERVATION
       PREVIOUS ITEM WILL BE REPLACED
    ===================================================== */

    function addReservationItem(name, price) {

        name =
            String(name || "").trim();

        price =
            parseFloat(price);

        if (
            name === "" ||
            isNaN(price) ||
            price <= 0
        ) {

            alert(
                "Please select a valid menu item."
            );

            return;

        }

        /*
         * IMPORTANT:
         * Only one menu item is stored.
         */

        selectedReservations = [

            {
                name: name,
                price: price,
                quantity: 1
            }

        ];

        saveReservations();

        updateReservationCount();

        showReservationMessage(
            name +
            " — ₹" +
            price +
            " added to reservation"
        );

    }


    /* =====================================================
       MENU RESERVATION BUTTON
    ===================================================== */

    document
        .querySelectorAll(".add-reservation-btn")
        .forEach(function (button) {

            button.addEventListener(
                "click",
                function () {

                    const name =
                        this.getAttribute(
                            "data-name"
                        );

                    const price =
                        this.getAttribute(
                            "data-price"
                        );

                    addReservationItem(
                        name,
                        price
                    );

                }
            );

        });


    /* =====================================================
       IMAGE RESERVATION
    ===================================================== */

    document
        .querySelectorAll(".reservation-image-link")
        .forEach(function (image) {

            image.addEventListener(
                "click",
                function (event) {

                    event.preventDefault();

                    const name =
                        this.getAttribute(
                            "data-name"
                        );

                    const price =
                        this.getAttribute(
                            "data-price"
                        );

                    addReservationItem(
                        name,
                        price
                    );

                }
            );

        });


    /* =====================================================
       GET SELECT PRICE
    ===================================================== */

    function getPrice(selectId) {

        const select =
            document.getElementById(selectId);

        if (!select) {
            return 0;
        }

        const option =
            select.options[
                select.selectedIndex
            ];

        if (!option) {
            return 0;
        }

        const price =
            parseFloat(
                option.getAttribute("data-price")
            );

        return isNaN(price)
            ? 0
            : price;

    }


    /* =====================================================
       BUILD YOUR COFFEE PRICE
    ===================================================== */

    function calculateCoffeePrice() {

        const coffee =
            getPrice("coffeeType");

        const size =
            getPrice("coffeeSize");

        const milk =
            getPrice("coffeeMilk");

        const sweetness =
            getPrice("coffeeSweetness");

        const topping =
            getPrice("coffeeTopping");

        const total =
            coffee +
            size +
            milk +
            sweetness +
            topping;


        const billCoffee =
            document.getElementById("billCoffee");

        const billSize =
            document.getElementById("billSize");

        const billMilk =
            document.getElementById("billMilk");

        const billSweetness =
            document.getElementById("billSweetness");

        const billTopping =
            document.getElementById("billTopping");

        const billTotal =
            document.getElementById("billTotal");

        const coffeeTotal =
            document.getElementById("coffeeTotal");

        const qrAmount =
            document.getElementById("qrAmount");


        if (billCoffee)
            billCoffee.textContent =
                "₹" + coffee;

        if (billSize)
            billSize.textContent =
                "₹" + size;

        if (billMilk)
            billMilk.textContent =
                "₹" + milk;

        if (billSweetness)
            billSweetness.textContent =
                "₹" + sweetness;

        if (billTopping)
            billTopping.textContent =
                "₹" + topping;

        if (billTotal)
            billTotal.textContent =
                "₹" + total;

        if (coffeeTotal)
            coffeeTotal.textContent =
                "₹" + total;

        if (qrAmount)
            qrAmount.textContent =
                "₹" + total;

        return total;

    }


    /* =====================================================
       PRICE CHANGE EVENTS
    ===================================================== */

    [
        "coffeeType",
        "coffeeSize",
        "coffeeMilk",
        "coffeeSweetness",
        "coffeeTopping"
    ].forEach(function (id) {

        const element =
            document.getElementById(id);

        if (element) {

            element.addEventListener(
                "change",
                calculateCoffeePrice
            );

        }

    });


    /* =====================================================
       PAYMENT METHOD
    ===================================================== */

    const paymentMethod =
        document.getElementById(
            "paymentMethod"
        );

    const qrBox =
        document.getElementById(
            "qrBox"
        );

    const paymentStatus =
        document.getElementById(
            "paymentStatus"
        );


    if (paymentMethod) {

        paymentMethod.addEventListener(
            "change",
            function () {

                if (this.value === "UPI") {

                    if (qrBox) {
                        qrBox.classList.add("show");
                    }

                    if (paymentStatus) {
                        paymentStatus.classList.add("show");
                    }

                    calculateCoffeePrice();

                } else {

                    if (qrBox) {
                        qrBox.classList.remove("show");
                    }

                    if (paymentStatus) {
                        paymentStatus.classList.remove("show");
                    }

                }

            }
        );

    }


    /* =====================================================
       GOOGLE SHEET
    ===================================================== */

    function sendToGoogleSheet() {

        const nameElement =
            document.querySelector(
                'input[name="name"]'
            );

        const phoneElement =
            document.querySelector(
                'input[name="phone"]'
            );

        const coffeeElement =
            document.getElementById(
                "coffeeType"
            );

        const sizeElement =
            document.getElementById(
                "coffeeSize"
            );

        const milkElement =
            document.getElementById(
                "coffeeMilk"
            );

        const sweetnessElement =
            document.getElementById(
                "coffeeSweetness"
            );

        const toppingElement =
            document.getElementById(
                "coffeeTopping"
            );

        const paymentElement =
            document.getElementById(
                "paymentMethod"
            );

        const totalElement =
            document.getElementById(
                "billTotal"
            );


        if (
            !nameElement ||
            !phoneElement ||
            !coffeeElement ||
            !sizeElement ||
            !milkElement ||
            !sweetnessElement ||
            !toppingElement ||
            !paymentElement ||
            !totalElement
        ) {

            return;

        }


        const data = {

            date:
                new Date().toLocaleString(
                    "en-IN"
                ),

            name:
                nameElement.value.trim(),

            phone:
                phoneElement.value.trim(),

            coffee:
                coffeeElement.value,

            size:
                sizeElement.value,

            milk:
                milkElement.value,

            sweetness:
                sweetnessElement.value,

            topping:
                toppingElement.value,

            payment:
                paymentElement.value,

            total:
                totalElement.textContent
                    .replace("₹", ""),

            paymentStatus:
                "Pending",

            orderType:
                "Build Your Coffee"

        };


        fetch(
            GOOGLE_SCRIPT_URL,
            {
                method: "POST",
                mode: "no-cors",
                headers: {
                    "Content-Type":
                        "application/json"
                },
                body:
                    JSON.stringify(data)
            }
        )
        .then(function () {

            console.log(
                "Google Sheet request sent."
            );

        })
        .catch(function (error) {

            console.log(
                "Google Sheet error:",
                error
            );

        });

    }


    /* =====================================================
       BUILD COFFEE FORM SUBMIT
    ===================================================== */

    const buildForm =
        document.getElementById(
            "buildCoffeeForm"
        );


    if (buildForm) {

        buildForm.addEventListener(
            "submit",
            function (event) {

                event.preventDefault();


                const total =
                    calculateCoffeePrice();


                if (total <= 0) {

                    alert(
                        "Please select coffee and size first."
                    );

                    return;

                }


                const payment =
                    paymentMethod
                        ? paymentMethod.value
                        : "";


                if (!payment) {

                    alert(
                        "Please select payment method."
                    );

                    return;

                }


                /* UPI */

                if (payment === "UPI") {

                    const ok =
                        confirm(
                            "Your total amount is ₹" +
                            total +
                            ".\n\n" +
                            "Please scan the UPI QR and complete payment.\n\n" +
                            "Continue with order?"
                        );

                    if (!ok) {
                        return;
                    }

                }


                /* SEND TO GOOGLE SHEET */

                sendToGoogleSheet();


                /*
                 * Submit normal PHP form.
                 * This saves order.csv.
                 */

                setTimeout(function () {

                    buildForm.submit();

                }, 700);

            }
        );

    }


    /* =====================================================
       INITIAL LOAD
    ===================================================== */

    calculateCoffeePrice();

    updateReservationCount();

});

</script>

</body>
</html>