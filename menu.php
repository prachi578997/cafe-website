<?php

/* =========================================================
   VELOURE MENU + BUILD YOUR COFFEE
========================================================= */

$orderSuccess = false;
$orderError = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"] ?? "");
    $phone = trim($_POST["phone"] ?? "");
    $coffee = trim($_POST["coffee"] ?? "");
    $size = trim($_POST["size"] ?? "");
    $milk = trim($_POST["milk"] ?? "");
    $sweetness = trim($_POST["sweetness"] ?? "");
    $topping = trim($_POST["topping"] ?? "");
    $payment = trim($_POST["payment"] ?? "");

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

    } else {

        $total =
            ($coffeePrices[$coffee] ?? 0) +
            ($sizePrices[$size] ?? 0) +
            ($milkPrices[$milk] ?? 0) +
            ($sweetnessPrices[$sweetness] ?? 0) +
            ($toppingPrices[$topping] ?? 0);

        if ($total <= 0) {

            $orderError = "Please select a valid coffee.";

        } else {

            $file = __DIR__ . "/order.csv";

            $newFile = !file_exists($file) || filesize($file) === 0;

            $handle = fopen($file, "a");

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
                        "Payment",
                        "Total"
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
                    $total
                ]);

                fclose($handle);

                $orderSuccess = true;

            } else {

                $orderError =
                    "Order could not be saved. Check folder permission.";

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

    "Classic Coffee" =>
    "Rich and aromatic classic coffee, freshly brewed for a smooth and comforting taste.",

    "Espresso Bar" =>
    "Strong and bold espresso with a rich aroma and perfectly balanced flavour.",

    "Cappuccino Collection" =>
    "Creamy cappuccino topped with velvety milk foam for a smooth coffee experience.",

    "Mocha Collection" =>
    "A delicious blend of rich chocolate and freshly brewed coffee with a creamy finish.",

    "Cold Coffee" =>
    "Refreshing chilled coffee blended with creamy milk for a smooth and delicious taste.",

    "Iced Coffee" =>
    "Cool and refreshing iced coffee served chilled for a perfect coffee break.",

    "Frappé Collection" =>
    "Creamy blended frappé with a refreshing texture and delightful coffee flavour.",

    "Flavoured Coffee" =>
    "Aromatic coffee infused with delicious flavours for a unique experience.",

    "Signature Coffee" =>
    "VELOURE's signature coffee crafted with premium ingredients and rich unforgettable taste.",

    "Classic Tea" =>
    "Freshly brewed classic tea with a soothing aroma and refreshing taste.",

    "Masala Tea" =>
    "Traditional Indian tea infused with aromatic spices.",

    "Green Tea" =>
    "Light and refreshing green tea made for a calm experience.",

    "Herbal Tea" =>
    "Soothing herbal tea prepared with refreshing natural ingredients.",

    "Iced Tea" =>
    "Chilled tea with a refreshing flavour.",

    "Mint Refreshers" =>
    "Cool and refreshing mint drink with a fresh flavour.",

    "Fruit Refreshers" =>
    "Refreshing fruit-based drink bursting with fruity flavours.",

    "Fruit Mojito" =>
    "Refreshing fruit mojito blended with citrus flavours and mint.",

    "Berry Coolers" =>
    "Refreshing berry cooler packed with sweet and tangy flavours.",

    "Tropical Coolers" =>
    "Refreshing tropical drink inspired by exotic fruits.",

    "Passion Fruit" =>
    "Sweet and tangy passion fruit refresher.",

    "Watermelon Drinks" =>
    "Fresh and juicy watermelon drink served chilled.",

    "French Fries" =>
    "Golden crispy French fries seasoned perfectly and served hot.",

    "Peri Peri Fries" =>
    "Crispy fries tossed with spicy peri peri seasoning.",

    "Garlic Bread" =>
    "Freshly baked bread topped with aromatic garlic butter.",

    "Nachos" =>
    "Crunchy nachos loaded with delicious toppings.",

    "Bruschetta" =>
    "Crispy toasted bread topped with fresh ingredients.",

    "Light Bites" =>
    "A delicious selection of light and tasty snacks.",

    "Veg Burgers" =>
    "Juicy and flavourful vegetarian burger with fresh ingredients.",

    "Sandwiches" =>
    "Freshly prepared sandwiches filled with delicious ingredients.",

    "Wraps" =>
    "Soft wraps filled with fresh vegetables and tasty fillings.",

    "Pizza" =>
    "Freshly baked pizza topped with delicious ingredients and cheese.",

    "Pasta" =>
    "Creamy and flavourful pasta prepared with fresh ingredients.",

    "Café Combos" =>
    "A perfect combination of popular café favourites.",

    "Brownies" =>
    "Rich and fudgy chocolate brownies with a soft centre.",

    "Lava Cakes" =>
    "Warm chocolate cake with a delicious molten centre.",

    "Cheesecakes" =>
    "Creamy and smooth cheesecake with a delicate base.",

    "Waffles" =>
    "Golden crispy waffles served with delicious toppings.",

    "Pancakes" =>
    "Soft and fluffy pancakes prepared fresh.",

    "Fresh Fruit Bowls" =>
    "A colourful bowl of fresh seasonal fruits.",

    "Greek Yogurt Bowls" =>
    "Creamy Greek yogurt topped with fresh fruits.",

    "Paneer Salads" =>
    "Fresh vegetables combined with flavourful paneer.",

    "Avocado Toast" =>
    "Crispy toast topped with creamy avocado.",

    "Smoothie Bowls" =>
    "Thick and creamy fruit smoothie bowl.",

    "Premium Latte" =>
    "Smooth and creamy premium latte.",

    "Royal Frappé" =>
    "Luxurious creamy frappé crafted with premium ingredients.",

    "Premium Burger" =>
    "Premium burger with delicious fillings.",

    "Chef's Special Pizza" =>
    "Chef's special pizza loaded with premium toppings.",

    "Luxury Dessert Platter" =>
    "Elegant platter featuring VELOURE's finest desserts.",

    "Loaded Fries" =>
    "Crispy fries loaded with delicious toppings.",

    "Mac & Cheese" =>
    "Creamy macaroni pasta blended with rich melted cheese.",

    "Hot Dogs" =>
    "Soft hot dog bun with delicious toppings.",

    "Crispy Chicken" =>
    "Crispy golden chicken with a flavourful coating.",

    "American-Style Desserts" =>
    "Delicious American-inspired desserts."

];

?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1.0"
>

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


/* NAVBAR */

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


/* HERO */

.hero{
padding:120px 7% 80px;
text-align:center;
background:
radial-gradient(
circle at 20% 30%,
rgba(166,108,67,.18),
transparent 30%
),
radial-gradient(
circle at 80% 70%,
rgba(80,50,35,.12),
transparent 30%
);
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


/* MENU */

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


/* FILTER */

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


/* CATEGORY */

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


/* CARDS */

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
margin-top:15px;
}

.price{
color:#a66c43;
font-size:18px;
font-weight:bold;
}

.order-btn{
text-decoration:none;
background:#4b3024;
color:white;
padding:9px 15px;
border-radius:20px;
font-size:11px;
}


/* BUILD COFFEE */

.build-coffee{
max-width:1250px;
margin:20px auto 70px;
padding:55px 45px;
background:linear-gradient(
135deg,
#4b3024,
#241713
);
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

.payment-box{
grid-column:1/-1;
}


/* QR PAYMENT */

.qr-box{
display:none;
grid-column:1/-1;
text-align:center;
background:#fffaf4;
color:#38271f;
padding:25px;
border-radius:18px;
margin-top:5px;
}

.qr-box.show{
display:block;
}

.qr-box img{
width:180px;
height:180px;
object-fit:contain;
margin:12px auto;
border-radius:10px;
}

.qr-box h3{
font-family:"Cormorant Garamond",serif;
font-size:28px;
}

.qr-box p{
font-size:13px;
color:#756359;
margin:5px 0;
}


/* BILL */

.price-box{
grid-column:1/-1;
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


/* BILL DETAILS */

.bill-details{
grid-column:1/-1;
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
padding:7px 0;
color:#eadcc9;
font-size:13px;
border-bottom:1px solid rgba(255,255,255,.08);
}

.bill-row:last-child{
border-bottom:none;
}

.bill-total{
display:flex;
justify-content:space-between;
font-size:18px;
font-weight:bold;
color:#d6a36f;
padding-top:12px;
}


/* BUTTON */

.build-btn{
grid-column:1/-1;
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


/* SUCCESS ERROR */

.success{
max-width:700px;
margin:30px auto;
padding:25px;
text-align:center;
background:#e8f6e8;
color:#245c2a;
border-radius:15px;
font-weight:bold;
}

.error{
max-width:700px;
margin:30px auto;
padding:25px;
text-align:center;
background:#ffe9e9;
color:#9b2226;
border-radius:15px;
font-weight:bold;
}


/* FOOTER */

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


/* RESPONSIVE */

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

.price-box,
.build-btn,
.payment-box,
.qr-box,
.bill-details{
grid-column:auto;
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

}

</style>

</head>


<body>


<!-- NAVBAR -->

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

<a
href="reservation.php#booking"
class="reserve-btn"
>
Reserve Table
</a>

</nav>


<!-- HERO -->

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


<!-- MENU -->

<section class="menu-section">

<div class="section-heading">

<small>
EXPLORE OUR SELECTION
</small>

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


<?php foreach ($menu as $category => $items): ?>

<?php

$filter =
strtolower(
preg_replace(
'/[^a-z0-9]+/',
'-',
$category
)
);

?>

<button
class="filter-btn"
data-filter="<?php echo $filter; ?>"
type="button"
>
<?php echo htmlspecialchars($category); ?>
</button>

<?php endforeach; ?>

</div>


<!-- MENU CATEGORIES -->

<?php foreach ($menu as $category => $items): ?>

<?php

$categoryClass =
strtolower(
preg_replace(
'/[^a-z0-9]+/',
'-',
$category
)
);

?>

<div
class="menu-category"
data-category="<?php echo $categoryClass; ?>"
>

<div class="category-title">

<h3>
<?php echo htmlspecialchars($category); ?>
</h3>

<div class="category-line"></div>

</div>


<div class="menu-grid">

<?php foreach ($items as $item): ?>

<div class="menu-card">

<!-- IMAGE CLICK RESERVATION -->

<a
href="reservation.php#booking"
class="food-image"
title="Reserve a Table"
>

<img
src="images/<?php echo htmlspecialchars($item[2]); ?>"
alt="<?php echo htmlspecialchars($item[0]); ?>"
onerror="this.src='images/default-food.jpg';"
>

</a>


<div class="menu-content">

<h4>
<?php echo htmlspecialchars($item[0]); ?>
</h4>


<p>

<?php

echo htmlspecialchars(
$descriptions[$item[0]]
??
"A delicious creation specially prepared by VELOURE."
);

?>

</p>


<div class="price-row">

<span class="price">

₹<?php
echo number_format($item[1]);
?>

</span>


<a
href="reservation.php#booking"
class="order-btn"
>
Reserve
</a>

</div>

</div>

</div>

<?php endforeach; ?>

</div>

</div>

<?php endforeach; ?>


<!-- BUILD YOUR COFFEE -->

<div
class="build-coffee"
id="build-coffee"
>

<div class="build-title">

<small>
YOUR COFFEE · YOUR WAY
</small>

<h2>
Build Your Coffee
</h2>

<p>
Create your perfect coffee
exactly the way you like it.
</p>

</div>


<?php if ($orderSuccess): ?>

<div class="success">

✅ Order placed successfully!

<br>

Your coffee order has been saved
in order.csv.

</div>

<?php endif; ?>


<?php if ($orderError !== ""): ?>

<div class="error">

❌ <?php echo htmlspecialchars($orderError); ?>

</div>

<?php endif; ?>


<form
class="build-form"
method="POST"
action="menu.php#build-coffee"
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

<option
value=""
data-price="0"
>
Select Coffee
</option>

<option
value="Classic Coffee"
data-price="120"
>
Classic Coffee — ₹120
</option>

<option
value="Espresso"
data-price="100"
>
Espresso — ₹100
</option>

<option
value="Cappuccino"
data-price="150"
>
Cappuccino — ₹150
</option>

<option
value="Mocha"
data-price="170"
>
Mocha — ₹170
</option>

<option
value="Cold Coffee"
data-price="150"
>
Cold Coffee — ₹150
</option>

<option
value="Iced Coffee"
data-price="160"
>
Iced Coffee — ₹160
</option>

<option
value="Frappé"
data-price="190"
>
Frappé — ₹190
</option>

<option
value="Signature Coffee"
data-price="220"
>
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

<option
value=""
data-price="0"
>
Select Size
</option>

<option
value="Small"
data-price="0"
>
Small — +₹0
</option>

<option
value="Medium"
data-price="30"
>
Medium — +₹30
</option>

<option
value="Large"
data-price="50"
>
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

<option
value="Regular Milk"
data-price="0"
>
Regular Milk — +₹0
</option>

<option
value="Almond Milk"
data-price="30"
>
Almond Milk — +₹30
</option>

<option
value="Oat Milk"
data-price="25"
>
Oat Milk — +₹25
</option>

<option
value="Soy Milk"
data-price="20"
>
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

<option
value="Normal"
data-price="0"
>
Normal — +₹0
</option>

<option
value="Less Sugar"
data-price="0"
>
Less Sugar — +₹0
</option>

<option
value="No Sugar"
data-price="0"
>
No Sugar — +₹0
</option>

<option
value="Extra Sweet"
data-price="10"
>
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

<option
value="No Topping"
data-price="0"
>
No Topping — +₹0
</option>

<option
value="Whipped Cream"
data-price="20"
>
Whipped Cream — +₹20
</option>

<option
value="Chocolate"
data-price="25"
>
Chocolate — +₹25
</option>

<option
value="Caramel"
data-price="20"
>
Caramel — +₹20
</option>

<option
value="Hazelnut"
data-price="30"
>
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


<!-- QR -->

<div
class="qr-box"
id="qrBox"
>

<h3>
UPI Payment
</h3>

<p>
Scan this QR Code to pay your bill
</p>

<img
src="images/upi-qr.png"
alt="VELOURE UPI QR Code"
onerror="this.style.display='none';"
>

<p>
Amount to Pay
</p>

<strong
id="qrAmount"
style="
font-size:32px;
color:#a66c43;
"
>
₹0
</strong>

</div>


<!-- BILL DETAILS -->

<div class="bill-details">

<h3>
Your Bill
</h3>

<div class="bill-row">

<span>
Coffee
</span>

<strong id="billCoffee">
₹0
</strong>

</div>


<div class="bill-row">

<span>
Size
</span>

<strong id="billSize">
₹0
</strong>

</div>


<div class="bill-row">

<span>
Milk
</span>

<strong id="billMilk">
₹0
</strong>

</div>


<div class="bill-row">

<span>
Sweetness
</span>

<strong id="billSweetness">
₹0
</strong>

</div>


<div class="bill-row">

<span>
Topping
</span>

<strong id="billTopping">
₹0
</strong>

</div>


<div class="bill-total">

<span>
Total Bill
</span>

<strong id="billTotal">
₹0
</strong>

</div>

</div>


<!-- PRICE -->

<div class="price-box">

<span>
YOUR COFFEE PRICE
</span>

<strong id="coffeeTotal">
₹0
</strong>

</div>


<!-- BUTTON -->

<button
type="submit"
class="build-btn"
>
Create My Coffee
</button>


</form>

</div>

</section>


<!-- FOOTER -->

<footer>

<div class="footer-logo">
VELOURE
</div>

<p>
© 2026 VELOURE Artisan Café.
All Rights Reserved.
</p>

</footer>


<script>


/* =========================================================
   MENU FILTER
========================================================= */

const filterButtons =
document.querySelectorAll(".filter-btn");

const categories =
document.querySelectorAll(".menu-category");


filterButtons.forEach(function(button){

button.addEventListener("click",function(){

const filter =
this.getAttribute("data-filter");

filterButtons.forEach(function(btn){

btn.classList.remove("active");

});

this.classList.add("active");


categories.forEach(function(category){

const categoryName =
category.getAttribute("data-category");

if(
filter === "all" ||
categoryName === filter
){

category.style.display = "block";

}else{

category.style.display = "none";

}

});

});

});


/* =========================================================
   PRICE CALCULATOR + BILL
========================================================= */

function getPrice(id){

const select =
document.getElementById(id);

if(!select){

return 0;

}

const option =
select.options[select.selectedIndex];

if(!option){

return 0;

}

return Number(
option.getAttribute("data-price")
) || 0;

}


function calculateCoffeePrice(){

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


/* MAIN PRICE */

document.getElementById(
"coffeeTotal"
).innerHTML =
"₹" + total;


/* BILL DETAILS */

document.getElementById(
"billCoffee"
).innerHTML =
"₹" + coffee;

document.getElementById(
"billSize"
).innerHTML =
"₹" + size;

document.getElementById(
"billMilk"
).innerHTML =
"₹" + milk;

document.getElementById(
"billSweetness"
).innerHTML =
"₹" + sweetness;

document.getElementById(
"billTopping"
).innerHTML =
"₹" + topping;

document.getElementById(
"billTotal"
).innerHTML =
"₹" + total;


/* QR AMOUNT */

document.getElementById(
"qrAmount"
).innerHTML =
"₹" + total;

}


/* =========================================================
   PRICE CHANGE
========================================================= */

document.querySelectorAll(
"#coffeeType, #coffeeSize, #coffeeMilk, #coffeeSweetness, #coffeeTopping"
).forEach(function(select){

select.addEventListener(
"change",
calculateCoffeePrice
);

});


/* =========================================================
   UPI QR SHOW / HIDE
========================================================= */

const paymentMethod =
document.getElementById("paymentMethod");

const qrBox =
document.getElementById("qrBox");


paymentMethod.addEventListener(
"change",
function(){

if(this.value === "UPI"){

qrBox.classList.add("show");

}else{

qrBox.classList.remove("show");

}

}
);


/* INITIAL PRICE */

calculateCoffeePrice();

</script>


</body>

</html>