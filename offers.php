<?php

// ==========================================
// VELOURE CAFE - EXCLUSIVE OFFERS
// ==========================================

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

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>VELOURE | Exclusive Offers</title>

<link rel="preconnect" href="https://fonts.googleapis.com">

<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=DM+Sans:wght@400;500;600;700&display=swap"
rel="stylesheet">

<link rel="stylesheet" href="css/style.css">

<style>

/* ==========================================
   RESET
========================================== */

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

html{
    scroll-behavior:smooth;
}

body{
    background:#0b0b0b;
    color:#fff;
    font-family:"DM Sans",sans-serif;
    overflow-x:hidden;
}


/* ==========================================
   NAVBAR
========================================== */

nav{
    width:100%;
    padding:20px 8%;
    display:flex;
    justify-content:space-between;
    align-items:center;

    position:fixed;
    top:0;
    left:0;

    z-index:1000;

    background:rgba(10,10,10,.88);
    backdrop-filter:blur(14px);

    border-bottom:1px solid rgba(214,168,95,.12);
}

.logo{
    font-family:"Cormorant Garamond",serif;
    font-size:32px;
    font-weight:700;
    letter-spacing:5px;
    color:#d6a85f;
}

nav ul{
    display:flex;
    align-items:center;
    gap:26px;
    list-style:none;
}

nav ul li a{
    position:relative;

    text-decoration:none;
    color:#fff;

    font-size:14px;
    font-weight:500;

    transition:.3s ease;
}

nav ul li a::after{
    content:"";

    position:absolute;
    left:0;
    bottom:-7px;

    width:0;
    height:2px;

    background:#d6a85f;

    transition:.3s ease;
}

nav ul li a:hover{
    color:#d6a85f;
}

nav ul li a:hover::after{
    width:100%;
}


/* ==========================================
   HERO
========================================== */

.hero{
    min-height:75vh;

    display:flex;
    justify-content:center;
    align-items:center;

    text-align:center;

    padding:140px 20px 80px;

    background:
        linear-gradient(
            rgba(0,0,0,.48),
            rgba(0,0,0,.82)
        ),
        url("images/offers-bg.jpg")
        center/cover no-repeat;

    position:relative;
}

.hero::before{
    content:"";

    position:absolute;
    inset:0;

    background:
        radial-gradient(
            circle at center,
            rgba(214,168,95,.10),
            transparent 55%
        );

    pointer-events:none;
}

.hero-content{
    position:relative;
    z-index:2;

    max-width:850px;

    animation:heroReveal 1.2s ease both;
}

.hero span{
    color:#d6a85f;

    font-size:13px;
    font-weight:600;

    letter-spacing:6px;
}

.hero h1{
    margin:18px 0;

    font-family:"Cormorant Garamond",serif;

    font-size:clamp(55px,8vw,100px);

    line-height:.95;

    font-weight:700;
}

.hero p{
    max-width:650px;

    margin:auto;

    color:#ddd;

    font-size:16px;

    line-height:1.8;
}


/* ==========================================
   OFFERS SECTION
========================================== */

.offers{
    padding:100px 8%;
}

.section-title{
    text-align:center;
    margin-bottom:65px;
}

.section-title span{
    color:#d6a85f;

    font-size:13px;

    font-weight:600;

    letter-spacing:5px;
}

.section-title h2{
    margin-top:12px;

    font-family:"Cormorant Garamond",serif;

    font-size:52px;

    font-weight:700;
}


/* ==========================================
   OFFER GRID
========================================== */

.offer-container{
    display:grid;

    grid-template-columns:
        repeat(3,1fr);

    gap:30px;
}


/* ==========================================
   OFFER CARD
========================================== */

.offer-card{

    position:relative;

    padding:40px 30px;

    min-height:390px;

    display:flex;
    flex-direction:column;

    border:1px solid
        rgba(214,168,95,.25);

    border-radius:22px;

    background:
        linear-gradient(
            145deg,
            #191919,
            #0d0d0d
        );

    overflow:hidden;

    opacity:0;

    transform:
        translateY(60px);

    transition:
        opacity .7s ease,
        transform .7s ease,
        border-color .4s ease,
        box-shadow .4s ease;
}

.offer-card::before{

    content:"";

    position:absolute;

    width:180px;
    height:180px;

    top:-90px;
    right:-90px;

    background:
        radial-gradient(
            circle,
            rgba(214,168,95,.16),
            transparent 70%
        );

    transition:.5s;
}

.offer-card.show{

    opacity:1;

    transform:
        translateY(0);
}

.offer-card:hover{

    transform:
        translateY(-12px);

    border-color:#d6a85f;

    box-shadow:
        0 25px 60px
        rgba(214,168,95,.15);
}

.offer-card:hover::before{

    transform:scale(1.5);
}


/* ==========================================
   BADGE
========================================== */

.badge{

    position:absolute;

    top:20px;
    right:-38px;

    padding:8px 42px;

    background:#d6a85f;

    color:#111;

    font-size:11px;

    font-weight:700;

    letter-spacing:.5px;

    transform:rotate(45deg);
}


/* ==========================================
   ICON
========================================== */

.offer-icon{

    width:75px;
    height:75px;

    display:flex;

    align-items:center;
    justify-content:center;

    margin-bottom:22px;

    border-radius:50%;

    background:
        rgba(214,168,95,.10);

    border:1px solid
        rgba(214,168,95,.25);

    font-size:38px;

    transition:.4s;
}

.offer-card:hover .offer-icon{

    transform:
        rotateY(180deg)
        scale(1.08);
}


/* ==========================================
   TITLE
========================================== */

.offer-card h3{

    font-family:
        "Cormorant Garamond",
        serif;

    font-size:30px;

    margin-bottom:12px;
}


/* ==========================================
   DESCRIPTION
========================================== */

.offer-card p{

    color:#aaa;

    line-height:1.7;

    font-size:14px;

    margin-bottom:25px;
}


/* ==========================================
   PRICE
========================================== */

.price{

    font-size:34px;

    color:#d6a85f;

    font-weight:700;
}

.old-price{

    color:#777;

    text-decoration:
        line-through;

    font-size:15px;

    margin-left:8px;
}


/* ==========================================
   OFFER BUTTON
========================================== */

.offer-btn{

    display:inline-flex;

    align-items:center;
    justify-content:center;

    width:max-content;

    margin-top:auto;

    padding:12px 25px;

    border:1px solid #d6a85f;

    border-radius:30px;

    color:#d6a85f;

    text-decoration:none;

    font-size:14px;

    font-weight:600;

    transition:.35s ease;
}

.offer-btn:hover{

    background:#d6a85f;

    color:#111;

    transform:
        translateY(-3px);

    box-shadow:
        0 10px 25px
        rgba(214,168,95,.20);
}


/* ==========================================
   SPECIAL BANNER
========================================== */

.special{

    margin:
        20px 8% 100px;

    padding:
        90px 30px;

    text-align:center;

    border-radius:28px;

    position:relative;

    overflow:hidden;

    background:
        linear-gradient(
            rgba(0,0,0,.50),
            rgba(0,0,0,.78)
        ),
        url("images/couple-offer.jpg")
        center/cover no-repeat;

    border:1px solid
        rgba(214,168,95,.25);

    animation:
        bannerFloat 4s ease-in-out infinite alternate;
}

.special h2{

    position:relative;

    font-family:
        "Cormorant Garamond",
        serif;

    font-size:52px;

    margin-bottom:15px;
}

.special p{

    position:relative;

    color:#ddd;

    max-width:600px;

    margin:
        0 auto 28px;

    line-height:1.7;
}

.special-btn{

    position:relative;

    display:inline-block;

    padding:14px 35px;

    background:#d6a85f;

    color:#111;

    border-radius:30px;

    text-decoration:none;

    font-weight:700;

    transition:.35s ease;
}

.special-btn:hover{

    transform:
        translateY(-4px)
        scale(1.04);

    box-shadow:
        0 15px 35px
        rgba(214,168,95,.25);
}


/* ==========================================
   FOOTER
========================================== */

footer{

    text-align:center;

    padding:42px 20px;

    background:#050505;

    color:#777;

    border-top:
        1px solid
        rgba(214,168,95,.10);
}

footer strong{
    color:#d6a85f;
}


/* ==========================================
   ANIMATIONS
========================================== */

@keyframes heroReveal{

    from{
        opacity:0;
        transform:
            translateY(50px);
    }

    to{
        opacity:1;
        transform:
            translateY(0);
    }
}

@keyframes bannerFloat{

    from{
        transform:scale(1);
    }

    to{
        transform:scale(1.012);
    }
}


/* ==========================================
   TABLET
========================================== */

@media(max-width:1000px){

    nav{
        padding:
            18px 5%;
    }

    nav ul{
        gap:15px;
    }

    .offer-container{
        grid-template-columns:
            repeat(2,1fr);
    }
}


/* ==========================================
   MOBILE
========================================== */

@media(max-width:650px){

    nav{
        padding:17px 5%;
    }

    .logo{
        font-size:27px;
    }

    nav ul{
        display:none;
    }

    .hero{
        min-height:65vh;

        padding:
            120px 20px 60px;
    }

    .hero span{
        font-size:11px;
        letter-spacing:4px;
    }

    .hero h1{
        font-size:55px;
    }

    .hero p{
        font-size:14px;
    }

    .offers{
        padding:
            75px 5%;
    }

    .section-title{
        margin-bottom:45px;
    }

    .section-title h2{
        font-size:40px;
    }

    .offer-container{
        grid-template-columns:1fr;
    }

    .offer-card{
        min-height:370px;
    }

    .special{
        margin:
            10px 5% 70px;

        padding:
            70px 20px;
    }

    .special h2{
        font-size:40px;
    }

}


/* ==========================================
   REDUCED MOTION
========================================== */

@media(prefers-reduced-motion:reduce){

    *,
    *::before,
    *::after{

        animation-duration:.01ms !important;

        animation-iteration-count:1 !important;

        scroll-behavior:auto !important;

        transition-duration:.01ms !important;
    }
}

</style>

</head>


<body>


<!-- ==========================================
     NAVBAR
========================================== -->

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


<!-- ==========================================
     HERO
========================================== -->

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


<!-- ==========================================
     OFFERS
========================================== -->

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


        <?php foreach($offers as $offerID => $offer): ?>


        <div class="offer-card">


            <div class="badge">

                <?php
                echo
                htmlspecialchars(
                    $offer["discount"]
                );
                ?>% OFF

            </div>


            <div class="offer-icon">

                <?php
                echo
                $offer["icon"];
                ?>

            </div>


            <h3>

                <?php
                echo
                htmlspecialchars(
                    $offer["title"]
                );
                ?>

            </h3>


            <p>

                <?php
                echo
                htmlspecialchars(
                    $offer["description"]
                );
                ?>

            </p>


            <div>

                <span class="price">

                    ₹<?php
                    echo
                    htmlspecialchars(
                        $offer["price"]
                    );
                    ?>

                </span>


                <span class="old-price">

                    ₹<?php
                    echo
                    htmlspecialchars(
                        $offer["old_price"]
                    );
                    ?>

                </span>

            </div>


            <!-- ==================================
                 CORRECT RESERVATION LINK
            ================================== -->

            <a
                href="reservation.php?offer=<?php echo urlencode($offerID); ?>"
                class="offer-btn"
            >

                <?php

                if($offerID === "OFFER03"){

                    echo "Book Now";

                }
                elseif($offerID === "OFFER05"){

                    echo "Reserve Your Table";

                }
                else{

                    echo "Claim Offer";

                }

                ?>

            </a>


        </div>


        <?php endforeach; ?>


    </div>

</section>


<!-- ==========================================
     SPECIAL BANNER
========================================== -->

<section class="special">

    <h2>
        A Perfect Evening for Two
    </h2>

    <p>
        Make your special moments unforgettable
        with VELOURE's exclusive couple experience.
    </p>

    <a
        href="reservation.php?offer=OFFER03"
        class="special-btn"
    >
        Reserve Your Table
    </a>

</section>


<!-- ==========================================
     FOOTER
========================================== -->

<footer>

    © 2026

    <strong>
        VELOURE
    </strong>

    — Crafted for unforgettable moments.

</footer>


<!-- ==========================================
     JAVASCRIPT
========================================== -->

<script>

/* ==========================================
   OFFER CARD SCROLL ANIMATION
========================================== */

const cards =
    document.querySelectorAll(
        ".offer-card"
    );


const observer =
    new IntersectionObserver(

        (entries) => {

            entries.forEach(
                (entry) => {

                    if(
                        entry.isIntersecting
                    ){

                        const delay =
                            [...cards]
                            .indexOf(
                                entry.target
                            ) * 120;

                        setTimeout(
                            () => {

                                entry.target
                                .classList
                                .add("show");

                            },
                            delay
                        );

                        observer.unobserve(
                            entry.target
                        );

                    }

                }
            );

        },

        {
            threshold:.12
        }

    );


cards.forEach(
    card => {

        observer.observe(card);

    }
);


/* ==========================================
   BUTTON CLICK EFFECT
========================================== */

document
.querySelectorAll(".offer-btn")
.forEach(

    button => {

        button.addEventListener(
            "click",
            function(){

                this.style.opacity = ".7";

                this.innerText =
                    "Opening Reservation...";

            }
        );

    }

);


/* ==========================================
   SPECIAL BUTTON
========================================== */

const specialButton =
    document.querySelector(
        ".special-btn"
    );


if(specialButton){

    specialButton.addEventListener(
        "click",
        function(){

            this.innerText =
                "Opening Reservation...";

        }
    );

}

</script>


</body>

</html>