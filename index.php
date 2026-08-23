<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Veloure | Crafted for Moments</title>
<link rel="stylesheet" href="style.css">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>

/* ================= RESET ================= */

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

html{
    scroll-behavior:smooth;
}

body{
    font-family:'DM Sans',sans-serif;
    background:#0b0705;
    color:#fff;
    overflow-x:hidden;
}

a{
    text-decoration:none;
    color:inherit;
}

img{
    width:100%;
    display:block;
}


/* ================= LOADER ================= */

.loader{
    position:fixed;
    inset:0;
    background:#0b0705;
    display:flex;
    align-items:center;
    justify-content:center;
    z-index:99999;
    animation:hideLoader 1s ease 2s forwards;
}

.loader-content{
    text-align:center;
}

.loader-cup{
    font-size:60px;
    animation:cupFloat 1s ease-in-out infinite alternate;
}

.loader-content h2{
    margin-top:10px;
    font-family:'Cormorant Garamond',serif;
    letter-spacing:7px;
    color:#e3b17a;
}

@keyframes cupFloat{
    from{
        transform:translateY(0);
    }

    to{
        transform:translateY(-15px);
    }
}

@keyframes hideLoader{
    to{
        opacity:0;
        visibility:hidden;
    }
}


/* ================= NAVBAR ================= */

.navbar{
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:80px;

    padding:0 7%;

    display:flex;
    align-items:center;
    justify-content:space-between;

    background:rgba(10,6,4,.72);
    backdrop-filter:blur(18px);

    border-bottom:1px solid rgba(255,255,255,.08);

    z-index:1000;

    animation:navDown 1s ease;
}

.logo{
    font-family:'Cormorant Garamond',serif;
    font-size:32px;
    font-weight:700;
    letter-spacing:4px;
    color:#e5b37c;
}

.logo span{
    color:#fff;
    font-weight:500;
}

.nav-links{
    display:flex;
    align-items:center;
    gap:27px;
}

.nav-links a{
    position:relative;
    font-size:14px;
    color:#ddd0c7;
    transition:.3s;
}

.nav-links a:hover{
    color:#e6b47d;
}

.nav-links a::after{
    content:"";
    position:absolute;
    left:0;
    bottom:-7px;
    width:0;
    height:2px;
    background:#dba46b;
    transition:.3s;
}

.nav-links a:hover::after{
    width:100%;
}

.reserve-btn{
    padding:11px 20px;
    border:1px solid #dca56c;
    border-radius:30px;
    color:#f2c896 !important;
}

.reserve-btn:hover{
    background:#dca56c;
    color:#1b0e08 !important;
}

.menu-toggle{
    display:none;
    font-size:28px;
    cursor:pointer;
}


/* ================= HERO ================= */

.hero{
    min-height:100vh;
    position:relative;

    display:flex;
    align-items:center;

    padding:120px 7% 70px;

    overflow:hidden;

    background-image:
        linear-gradient(
            90deg,
            rgba(7,4,3,.95),
            rgba(7,4,3,.70),
            rgba(7,4,3,.25)
        ),
        url("images/hazelnut-latte.jpg");

    background-size:cover;
    background-position:center;

    animation:heroZoom 12s ease-in-out infinite alternate;
}

@keyframes heroZoom{
    from{
        background-size:100%;
    }

    to{
        background-size:108%;
    }
}

.hero::before{
    content:"";
    position:absolute;
    inset:0;

    background:
        radial-gradient(
            circle at 75% 35%,
            rgba(224,165,99,.28),
            transparent 30%
        );

    pointer-events:none;
}

.hero-content{
    position:relative;
    z-index:2;
    max-width:760px;
}

.hero-small{
    color:#dfa76c;
    text-transform:uppercase;
    letter-spacing:5px;
    font-size:13px;

    animation:fadeUp 1s .3s both;
}

.hero h1{
    margin:22px 0;

    font-family:'Cormorant Garamond',serif;

    font-size:clamp(65px,9vw,120px);

    line-height:.82;

    animation:fadeUp 1s .5s both;
}

.hero h1 span{
    color:#e2ac73;
}

.hero p{
    max-width:590px;

    color:#d8cbc2;

    line-height:1.8;

    font-size:17px;

    animation:fadeUp 1s .7s both;
}

.hero-buttons{
    display:flex;
    gap:15px;
    margin-top:35px;

    animation:fadeUp 1s .9s both;
}

.btn{
    display:inline-block;
    padding:15px 28px;
    border-radius:50px;
    font-weight:600;
    transition:.4s;
}

.btn-primary{
    background:linear-gradient(135deg,#e4b174,#a8663b);
    color:#1b0e08;

    box-shadow:0 15px 35px rgba(207,143,81,.25);
}

.btn-primary:hover{
    transform:translateY(-6px);
    box-shadow:0 20px 45px rgba(207,143,81,.45);
}

.btn-outline{
    border:1px solid rgba(255,255,255,.45);
    color:#fff;
}

.btn-outline:hover{
    background:#fff;
    color:#21130d;
    transform:translateY(-6px);
}

@keyframes fadeUp{
    from{
        opacity:0;
        transform:translateY(40px);
    }

    to{
        opacity:1;
        transform:translateY(0);
    }
}


/* ================= FLOATING CUP ================= */

.floating-cup{
    position:absolute;
    right:9%;
    bottom:18%;

    font-size:65px;

    z-index:2;

    filter:drop-shadow(0 15px 25px rgba(0,0,0,.6));

    animation:floatCup 4s ease-in-out infinite;
}

@keyframes floatCup{

    0%,100%{
        transform:translateY(0) rotate(-5deg);
    }

    50%{
        transform:translateY(-25px) rotate(5deg);
    }
}


/* ================= SCROLL ================= */

.scroll{
    position:absolute;
    bottom:28px;
    left:50%;

    transform:translateX(-50%);

    color:#bca99b;
    font-size:11px;
    letter-spacing:4px;

    animation:scrollBounce 2s infinite;
}

@keyframes scrollBounce{

    0%,100%{
        transform:translate(-50%,0);
    }

    50%{
        transform:translate(-50%,10px);
    }
}


/* ================= COMMON SECTION ================= */

section{
    padding:100px 7%;
}

.section-title{
    max-width:700px;
    margin:0 auto 55px;
    text-align:center;
}

.section-title span{
    color:#dca36a;
    text-transform:uppercase;
    letter-spacing:4px;
    font-size:12px;
}

.section-title h2{
    margin:12px 0;

    font-family:'Cormorant Garamond',serif;

    font-size:58px;
}

.section-title p{
    color:#a99a90;
    line-height:1.8;
}


/* ================= EXPERIENCE ================= */

.experience{
    background:
        radial-gradient(
            circle at 50% 0%,
            rgba(194,125,67,.13),
            transparent 40%
        );
}

.experience-grid{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:20px;
}

.experience-card{
    padding:35px 25px;

    text-align:center;

    background:rgba(255,255,255,.045);

    border:1px solid rgba(255,255,255,.08);

    border-radius:25px;

    transition:.5s;

    opacity:0;
    transform:translateY(50px);
}

.experience-card.show{
    opacity:1;
    transform:translateY(0);
}

.experience-card:hover{
    transform:translateY(-12px) scale(1.02);

    border-color:rgba(222,165,104,.4);

    box-shadow:0 25px 50px rgba(0,0,0,.35);
}

.icon{
    font-size:42px;
    margin-bottom:15px;

    display:inline-block;

    animation:iconFloat 3s ease-in-out infinite;
}

@keyframes iconFloat{

    0%,100%{
        transform:translateY(0);
    }

    50%{
        transform:translateY(-8px);
    }
}

.experience-card h3{
    margin-bottom:10px;

    font-family:'Cormorant Garamond',serif;

    font-size:27px;

    color:#e5c19c;
}

.experience-card p{
    color:#a99b92;
    font-size:14px;
    line-height:1.7;
}


/* ================= SIGNATURE MENU ================= */

.signature{
    background:#100a07;
}

.menu-grid{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:25px;
}

.food-card{
    overflow:hidden;

    border-radius:25px;

    background:#1b100b;

    border:1px solid rgba(255,255,255,.08);

    opacity:0;
    transform:translateY(60px) scale(.96);

    transition:.7s;

    box-shadow:0 20px 50px rgba(0,0,0,.3);
}

.food-card.show{
    opacity:1;
    transform:translateY(0) scale(1);
}

.food-image{
    height:300px;
    overflow:hidden;
}

.food-image img{
    width:100%;
    height:100%;
    object-fit:cover;

    transition:.8s;
}

.food-card:hover .food-image img{
    transform:scale(1.12) rotate(1deg);
}

.food-info{
    padding:23px;
}

.food-info h3{
    font-family:'Cormorant Garamond',serif;
    font-size:29px;
    color:#f0d0ad;
}

.food-info p{
    color:#a99b92;
    margin:8px 0 15px;
    font-size:14px;
}

.food-bottom{
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.price{
    color:#e3aa70;
    font-size:18px;
    font-weight:700;
}

.view{
    padding:8px 15px;

    border:1px solid rgba(255,255,255,.2);

    border-radius:20px;

    font-size:13px;

    transition:.3s;
}

.view:hover{
    background:#d9a068;
    color:#1a0d08;
}


/* ================= BUILD COFFEE ================= */

.build{
    min-height:500px;

    display:flex;
    align-items:center;

    position:relative;

    background:
        linear-gradient(
            90deg,
            rgba(16,9,6,.95),
            rgba(16,9,6,.65)
        ),
        url("images/hazelnut-latte.jpg");

    background-size:cover;
    background-position:center;
    background-attachment:fixed;
}

.build-content{
    max-width:650px;
}

.build-content span{
    color:#e0a66c;

    text-transform:uppercase;

    letter-spacing:4px;

    font-size:12px;
}

.build-content h2{
    margin:15px 0;

    font-family:'Cormorant Garamond',serif;

    font-size:70px;
}

.build-content p{
    color:#c5b6aa;
    line-height:1.8;
    margin-bottom:30px;
}


/* ================= GALLERY ================= */

.gallery{
    background:#0d0806;
}

.gallery-grid{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:15px;
}

.gallery-item{
    height:260px;

    overflow:hidden;

    border-radius:20px;

    opacity:0;

    transform:scale(.9);

    transition:.7s;
}

.gallery-item.show{
    opacity:1;
    transform:scale(1);
}

.gallery-item img{
    width:100%;
    height:100%;

    object-fit:cover;

    transition:.7s;
}

.gallery-item:hover img{
    transform:scale(1.15);
}


/* ================= OFFER ================= */

.offer{
    text-align:center;

    background:
        radial-gradient(
            circle at center,
            rgba(206,143,82,.15),
            transparent 40%
        );
}

.offer-box{
    max-width:900px;

    margin:auto;

    padding:65px 30px;

    border:1px solid rgba(222,165,104,.25);

    border-radius:35px;

    background:rgba(255,255,255,.04);

    animation:offerGlow 4s ease-in-out infinite alternate;
}

@keyframes offerGlow{

    from{
        box-shadow:0 0 20px rgba(211,150,88,.05);
    }

    to{
        box-shadow:0 0 50px rgba(211,150,88,.15);
    }
}

.offer-box h2{
    margin:15px 0;

    font-family:'Cormorant Garamond',serif;

    font-size:65px;

    color:#e4b078;
}

.offer-box p{
    color:#b6a69c;
    margin-bottom:30px;
}


/* ================= REVIEWS ================= */

.reviews{
    background:#0d0806;
}

.review-grid{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:25px;
}

.review{
    padding:30px;

    border-radius:25px;

    background:rgba(255,255,255,.045);

    border:1px solid rgba(255,255,255,.08);

    transition:.5s;
}

.review:hover{
    transform:translateY(-10px);
    border-color:rgba(222,165,104,.35);
}

.stars{
    color:#e5ad72;
    letter-spacing:4px;
    font-size:18px;
}

.review p{
    color:#b8aaa1;

    line-height:1.8;

    margin:18px 0;

    font-style:italic;
}

.reviewer{
    color:#e3c19d;
    font-weight:600;
}


/* ================= RESERVATION ================= */

.reservation{
    position:relative;

    text-align:center;

    background:
        linear-gradient(
            rgba(17,9,6,.84),
            rgba(17,9,6,.93)
        ),
        url("images/pasta-alfredo.jpg");

    background-size:cover;
    background-position:center;
    background-attachment:fixed;
}

.reservation h2{
    font-family:'Cormorant Garamond',serif;
    font-size:75px;
}

.reservation p{
    color:#c1b0a4;
    margin:15px 0 30px;
}


/* ================= FOOTER ================= */

footer{
    padding:60px 7% 25px;

    background:#080503;

    border-top:1px solid rgba(255,255,255,.08);
}

.footer-grid{
    display:grid;
    grid-template-columns:2fr 1fr 1fr 1fr;
    gap:40px;
}

.footer-brand h2{
    font-family:'Cormorant Garamond',serif;
    font-size:36px;
    color:#e0ac72;
}

.footer-brand p{
    color:#93857d;
    line-height:1.8;
    margin-top:15px;
    max-width:350px;
}

footer h3{
    color:#e1c09c;
    margin-bottom:15px;
}

footer a,
footer p{
    display:block;
    color:#8f8178;
    margin:9px 0;
    font-size:14px;
}

footer a:hover{
    color:#e1aa70;
}

.copyright{
    text-align:center;

    margin-top:45px;

    padding-top:20px;

    border-top:1px solid rgba(255,255,255,.07);

    color:#665a53;

    font-size:13px;
}


/* ================= MOBILE ================= */

@media(max-width:1000px){

    .nav-links{
        display:none;
    }

    .menu-toggle{
        display:block;
    }

    .experience-grid{
        grid-template-columns:repeat(2,1fr);
    }

    .menu-grid{
        grid-template-columns:repeat(2,1fr);
    }

    .gallery-grid{
        grid-template-columns:repeat(2,1fr);
    }

    .footer-grid{
        grid-template-columns:repeat(2,1fr);
    }
}

@media(max-width:650px){

    section{
        padding:75px 5%;
    }

    .navbar{
        padding:0 5%;
    }

    .logo{
        font-size:25px;
    }

    .hero{
        padding:120px 5% 70px;
    }

    .hero h1{
        font-size:62px;
    }

    .hero p{
        font-size:15px;
    }

    .hero-buttons{
        flex-direction:column;
        align-items:flex-start;
    }

    .floating-cup{
        display:none;
    }

    .section-title h2{
        font-size:45px;
    }

    .experience-grid,
    .menu-grid,
    .review-grid,
    .footer-grid{
        grid-template-columns:1fr;
    }

    .gallery-grid{
        grid-template-columns:1fr 1fr;
    }

    .food-image{
        height:240px;
    }

    .build-content h2,
    .offer-box h2,
    .reservation h2{
        font-size:50px;
    }
}

</style>
</head>

<body>


<!-- ================= LOADER ================= -->

<div class="loader">

    <div class="loader-content">

        <div class="loader-cup">☕</div>

        <h2>VELOURE</h2>

    </div>

</div>


<!-- ================= NAVBAR ================= -->

<nav class="navbar">

    <a href="index.php" class="logo">
        VELOURE
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

        <a href="contact.php#booking" class="reserve-btn">
            Reserve Table
        </a>

    </div>

    <div class="menu-toggle" onclick="toggleMenu()">
        ☰
    </div>

</nav>


<!-- ================= HERO ================= -->

<section class="hero">

    <div class="hero-content">

        <div class="hero-small">
            Welcome to Veloure
        </div>

        <h1>
            Crafted for<br>
            <span>Moments.</span>
        </h1>

        <p>
            Discover beautifully crafted coffee, gourmet bites
            and unforgettable moments in an elegant café
            experience designed just for you.
        </p>

        <div class="hero-buttons">

            <a href="menu.php" class="btn btn-primary">
                Explore Menu →
            </a>

            <a href="contact.php#booking" class="btn btn-outline">
                Reserve a Table
            </a>

        </div>

    </div>

    <div class="floating-cup">
        ☕
    </div>

    <div class="scroll">
        SCROLL ↓
    </div>

</section>


<!-- ================= EXPERIENCE ================= -->

<section class="experience">

    <div class="section-title">

        <span>The Veloure Experience</span>

        <h2>More Than Just Coffee</h2>

        <p>
            Every detail is thoughtfully created to make
            your time with us memorable.
        </p>

    </div>

    <div class="experience-grid">

        <div class="experience-card">

            <div class="icon">☕</div>

            <h3>Artisan Coffee</h3>

            <p>
                Expertly crafted coffee made from
                carefully selected beans.
            </p>

        </div>


        <div class="experience-card">

            <div class="icon">🥐</div>

            <h3>Gourmet Bites</h3>

            <p>
                Delicious dishes and premium café
                favourites prepared fresh.
            </p>

        </div>


        <div class="experience-card">

            <div class="icon">✨</div>

            <h3>Premium Ambience</h3>

            <p>
                An elegant atmosphere designed for
                conversations and special moments.
            </p>

        </div>


        <div class="experience-card">

            <div class="icon">❤️</div>

            <h3>Crafted With Passion</h3>

            <p>
                Passion, quality and creativity in
                every cup and every plate.
            </p>

        </div>

    </div>

</section>


<!-- ================= SIGNATURE MENU ================= -->

<section class="signature">

    <div class="section-title">

        <span>Our Favourites</span>

        <h2>Signature Selection</h2>

        <p>
            A curated collection of Veloure's
            most loved creations.
        </p>

    </div>


    <div class="menu-grid">


        <!-- 1 HAZELNUT LATTE -->

        <div class="food-card">

            <div class="food-image">

                <img
                    src="images/hazelnut-latte.jpg"
                    alt="Hazelnut Latte"
                >

            </div>

            <div class="food-info">

                <h3>
                    Hazelnut Latte
                </h3>

                <p>
                    Smooth espresso with roasted hazelnut.
                </p>

                <div class="food-bottom">

                    <span class="price">
                        ₹190
                    </span>

                    <a href="menu.php" class="view">
                        View Menu
                    </a>

                </div>

            </div>

        </div>


        <!-- 2 ROYAL CHOCOLATE FRAPPE -->

        <div class="food-card">

            <div class="food-image">

                <img
                    src="images/royal-chocolate-frappe.jpg"
                    alt="Royal Chocolate Frappe"
                >

            </div>

            <div class="food-info">

                <h3>
                    Royal Chocolate Frappe
                </h3>

                <p>
                    Rich chocolate blended with creamy coffee.
                </p>

                <div class="food-bottom">

                    <span class="price">
                        ₹220
                    </span>

                    <a href="menu.php" class="view">
                        View Menu
                    </a>

                </div>

            </div>

        </div>


        <!-- 3 TRUFFLE FRIES -->

        <div class="food-card">

            <div class="food-image">

                <img
                    src="images/truffle-fries.jpg"
                    alt="Truffle Fries"
                >

            </div>

            <div class="food-info">

                <h3>
                    Truffle Fries
                </h3>

                <p>
                    Crispy fries with delicious truffle flavour.
                </p>

                <div class="food-bottom">

                    <span class="price">
                        ₹180
                    </span>

                    <a href="menu.php" class="view">
                        View Menu
                    </a>

                </div>

            </div>

        </div>


        <!-- 4 PASTA ALFREDO -->

        <div class="food-card">

            <div class="food-image">

                <img
                    src="images/pasta-alfredo.jpg"
                    alt="Pasta Alfredo"
                >

            </div>

            <div class="food-info">

                <h3>
                    Pasta Alfredo
                </h3>

                <p>
                    Creamy Alfredo pasta prepared fresh.
                </p>

                <div class="food-bottom">

                    <span class="price">
                        ₹250
                    </span>

                    <a href="menu.php" class="view">
                        View Menu
                    </a>

                </div>

            </div>

        </div>


        <!-- 5 CHOCOLATE LAVA CAKE -->

        <div class="food-card">

            <div class="food-image">

                <img
                    src="images/chocolate-lava-cake.jpg"
                    alt="Chocolate Lava Cake"
                >

            </div>

            <div class="food-info">

                <h3>
                    Chocolate Lava Cake
                </h3>

                <p>
                    Warm chocolate cake with molten centre.
                </p>

                <div class="food-bottom">

                    <span class="price">
                        ₹220
                    </span>

                    <a href="menu.php" class="view">
                        View Menu
                    </a>

                </div>

            </div>

        </div>


    </div>

</section>


<!-- ================= BUILD COFFEE ================= -->

<section class="build">

    <div class="build-content">

        <span>
            Your Coffee. Your Way.
        </span>

        <h2>
            Build Your Coffee
        </h2>

        <p>
            Choose your favourite coffee, size, milk,
            sweetness and toppings to create your
            perfect cup at Veloure.
        </p>

        <a
            href="menu.php#build"
            class="btn btn-primary"
        >
            Create Your Coffee →
        </a>

    </div>

</section>


<!-- ================= GALLERY ================= -->

<section class="gallery">

    <div class="section-title">

        <span>
            Inside Veloure
        </span>

        <h2>
            A Taste of Our World
        </h2>

        <p>
            Explore the flavours, ambience and moments
            that make Veloure special.
        </p>

    </div>


    <div class="gallery-grid">


        <!-- 1 HAZELNUT LATTE -->

        <div class="gallery-item">

            <img
                src="images/hazelnut-latte.jpg"
                alt="Hazelnut Latte"
            >

        </div>


        <!-- 2 ROYAL CHOCOLATE FRAPPE -->

        <div class="gallery-item">

            <img
                src="images/royal-chocolate-frappe.jpg"
                alt="Chocolate Frappe"
            >

        </div>


        <!-- 3 TRUFFLE FRIES -->

        <div class="gallery-item">

            <img
                src="images/truffle-fries.jpg"
                alt="Truffle Fries"
            >

        </div>


        <!-- 4 PASTA ALFREDO -->

        <div class="gallery-item">

            <img
                src="images/pasta-alfredo.jpg"
                alt="Pasta Alfredo"
            >

        </div>


        <!-- 5 CHOCOLATE LAVA CAKE -->

        <div class="gallery-item">

            <img
                src="images/chocolate-lava-cake.jpg"
                alt="Chocolate Lava Cake"
            >

        </div>


    </div>

</section>


<!-- ================= OFFER ================= -->

<section class="offer">

    <div class="offer-box">

        <span>
            Special Experience
        </span>

        <h2>
            Make Your Moment Special
        </h2>

        <p>
            Enjoy exclusive café experiences, seasonal
            creations and special offers at Veloure.
        </p>

        <a
            href="offers.php"
            class="btn btn-primary"
        >
            Explore Offers →
        </a>

    </div>

</section>


<!-- ================= REVIEWS ================= -->

<section class="reviews">

    <div class="section-title">

        <span>
            Guest Stories
        </span>

        <h2>
            Loved by Our Guests
        </h2>

        <p>
            Moments shared by people who experienced
            Veloure.
        </p>

    </div>


    <div class="review-grid">


        <div class="review">

            <div class="stars">
                ★★★★★
            </div>

            <p>
                "Beautiful ambience and absolutely
                amazing coffee. Perfect place to relax!"
            </p>

            <div class="reviewer">
                — Aditi
            </div>

        </div>


        <div class="review">

            <div class="stars">
                ★★★★★
            </div>

            <p>
                "The Hazelnut Latte and Chocolate Lava
                Cake were fantastic. Loved the experience."
            </p>

            <div class="reviewer">
                — Rohan
            </div>

        </div>


        <div class="review">

            <div class="stars">
                ★★★★★
            </div>

            <p>
                "Elegant café, delicious food and
                wonderful service. Definitely coming back!"
            </p>

            <div class="reviewer">
                — Sneha
            </div>

        </div>


    </div>

</section>


<!-- ================= RESERVATION ================= -->

<section class="reservation">

    <div class="section-title">

        <span>
            Reserve Your Experience
        </span>

        <h2>
            Your Table Awaits
        </h2>

        <p>
            Planning a coffee date, family gathering or
            special evening? Reserve your table with us.
        </p>

        <a
            href="contact.php#booking"
            class="btn btn-primary"
        >
            Reserve Your Table →
        </a>

    </div>

</section>


<!-- ================= FOOTER ================= -->

<footer>

    <div class="footer-grid">


        <div class="footer-brand">

            <h2>
                VELOURE
            </h2>

            <p>
                Crafted coffee, gourmet bites and
                unforgettable moments.
            </p>

        </div>


        <div>

            <h3>
                Explore
            </h3>

            <a href="index.php">
                Home
            </a>

            <a href="about.php">
                About
            </a>

            <a href="menu.php">
                Menu
            </a>

            <a href="offers.php">
                Offers
            </a>

        </div>


        <div>

            <h3>
                Experience
            </h3>

            <a href="gallery.php">
                Gallery
            </a>

            <a href="services.php">
                Services
            </a>

            <a href="reservation.php">
                Reservation
            </a>

            <a href="reviews.php">
                Reviews
            </a>

        </div>


        <div>

            <h3>
                Contact
            </h3>

            <p>
                📍 Mumbai, India
            </p>

            <p>
                📞 +91 98765 43210
            </p>

            <p>
                ✉ hello@veloure.com
            </p>

        </div>


    </div>


    <div class="copyright">

        © 2026 Veloure.
        All Rights Reserved.

    </div>

</footer>


<!-- ================= JAVASCRIPT ================= -->

<script>

function toggleMenu(){

    const nav =
        document.querySelector(".nav-links");

    if(nav.style.display === "flex"){

        nav.style.display = "none";

    }else{

        nav.style.display = "flex";

        nav.style.flexDirection = "column";

        nav.style.position = "absolute";

        nav.style.top = "80px";

        nav.style.right = "5%";

        nav.style.padding = "25px";

        nav.style.background =
            "rgba(10,6,4,.97)";

        nav.style.borderRadius = "20px";

        nav.style.gap = "20px";

    }

}


/* ================= SCROLL ANIMATION ================= */

const observer =
    new IntersectionObserver(

        function(entries){

            entries.forEach(function(entry){

                if(entry.isIntersecting){

                    entry.target.classList.add("show");

                }

            });

        },

        {
            threshold:0.15
        }

    );


/* Experience Cards */

document
.querySelectorAll(".experience-card")
.forEach(function(card){

    observer.observe(card);

});


/* Food Cards */

document
.querySelectorAll(".food-card")
.forEach(function(card){

    observer.observe(card);

});


/* Gallery */

document
.querySelectorAll(".gallery-item")
.forEach(function(item){

    observer.observe(item);

});

</script>


</body>
</html>