<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<title>About | VELOURE Café</title>

<link rel="stylesheet" href="style.css">

<link rel="preconnect" href="https://fonts.googleapis.com">

<link
    rel="preconnect"
    href="https://fonts.gstatic.com"
    crossorigin
>

<link
    href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=DM+Sans:wght@400;500;600;700&display=swap"
    rel="stylesheet"
>


<style>

/* ================= RESET ================= */

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

html {
    scroll-behavior: smooth;
}

body {
    font-family: 'DM Sans', sans-serif;
    background: #f7f1e8;
    color: #2d2119;
    overflow-x: hidden;
}

a {
    text-decoration: none;
    color: inherit;
}

img {
    width: 100%;
    display: block;
}


/* ================= LOADER ================= */

.loader {
    position: fixed;
    inset: 0;
    background: #21140d;
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 99999;
    animation: loaderHide 1s ease 2s forwards;
}

.loader-box {
    text-align: center;
}

.loader-cup {
    font-size: 60px;
    animation: cupFloat 1s ease-in-out infinite alternate;
}

.loader h2 {
    font-family: 'Cormorant Garamond', serif;
    color: #e3b17a;
    letter-spacing: 7px;
    margin-top: 10px;
}

@keyframes cupFloat {

    from {
        transform: translateY(0);
    }

    to {
        transform: translateY(-15px);
    }

}

@keyframes loaderHide {

    to {
        opacity: 0;
        visibility: hidden;
    }

}


/* ================= NAVBAR ================= */

.navbar {

    position: fixed;

    top: 0;
    left: 0;

    width: 100%;
    height: 78px;

    padding: 0 7%;

    display: flex;
    justify-content: space-between;
    align-items: center;

    background: rgba(43, 30, 21, 0.92);

    backdrop-filter: blur(18px);

    border-bottom: 1px solid rgba(255, 255, 255, 0.1);

    z-index: 1000;

    animation: navDown 1s ease;
}

@keyframes navDown {

    from {
        transform: translateY(-100%);
        opacity: 0;
    }

    to {
        transform: translateY(0);
        opacity: 1;
    }

}

.logo {

    font-family: 'Cormorant Garamond', serif;

    font-size: 32px;

    font-weight: 700;

    letter-spacing: 4px;

    color: #e5b37c;
}

.logo span {
    color: #ffffff;
}

.nav-links {

    display: flex;

    align-items: center;

    gap: 27px;
}

.nav-links a {

    color: #eee3da;

    font-size: 14px;

    position: relative;

    transition: 0.3s;
}

.nav-links a::after {

    content: "";

    position: absolute;

    left: 0;

    bottom: -7px;

    width: 0;

    height: 2px;

    background: #dfa66c;

    transition: 0.3s;
}

.nav-links a:hover,
.nav-links a.active {

    color: #e5b37c;
}

.nav-links a:hover::after,
.nav-links a.active::after {

    width: 100%;
}

.reserve {

    padding: 11px 21px;

    border: 1px solid #dca56c;

    border-radius: 30px;

    color: #f1c58f !important;
}

.reserve::after {
    display: none;
}

.reserve:hover {

    background: #dca56c;

    color: #24150c !important;
}

.menu-toggle {

    display: none;

    color: white;

    font-size: 28px;

    cursor: pointer;
}


/* ================= HERO ================= */

.about-hero {

    min-height: 100vh;

    padding: 130px 7% 80px;

    display: grid;

    grid-template-columns: 1.05fr 0.95fr;

    align-items: center;

    gap: 70px;

    position: relative;

    overflow: hidden;

    background:

        radial-gradient(
            circle at 80% 20%,
            rgba(191, 137, 78, 0.20),
            transparent 30%
        ),

        linear-gradient(
            135deg,
            #faf5ed,
            #eee1d1
        );
}


/* Animated circles */

.about-hero::before {

    content: "";

    position: absolute;

    width: 450px;
    height: 450px;

    border-radius: 50%;

    background: rgba(184, 128, 69, 0.08);

    top: -180px;
    right: -100px;

    animation: circleMove 8s ease-in-out infinite alternate;
}

.about-hero::after {

    content: "";

    position: absolute;

    width: 250px;
    height: 250px;

    border-radius: 50%;

    border: 1px solid rgba(157, 108, 59, 0.15);

    bottom: -80px;
    left: -60px;

    animation: rotateCircle 15s linear infinite;
}

@keyframes circleMove {

    from {
        transform: translate(0, 0);
    }

    to {
        transform: translate(-50px, 50px);
    }

}

@keyframes rotateCircle {

    to {
        transform: rotate(360deg);
    }

}


/* Hero text */

.hero-text {

    position: relative;

    z-index: 2;
}

.hero-label {

    color: #a66c39;

    letter-spacing: 5px;

    text-transform: uppercase;

    font-size: 12px;

    animation: fadeUp 1s 0.2s both;
}

.hero-text h1 {

    font-family: 'Cormorant Garamond', serif;

    font-size: clamp(65px, 8vw, 110px);

    line-height: 0.86;

    margin: 20px 0;

    color: #2c2018;

    animation: fadeUp 1s 0.4s both;
}

.hero-text h1 span {

    color: #b17640;
}

.hero-text p {

    max-width: 580px;

    color: #716157;

    line-height: 1.9;

    font-size: 16px;

    animation: fadeUp 1s 0.6s both;
}

.hero-buttons {

    margin-top: 30px;

    display: flex;

    gap: 15px;

    animation: fadeUp 1s 0.8s both;
}

.btn {

    padding: 14px 25px;

    border-radius: 30px;

    font-weight: 600;

    transition: 0.4s;

    display: inline-block;
}

.btn-primary {

    background: #9d6338;

    color: #ffffff;

    box-shadow:
        0 12px 30px rgba(117, 70, 35, 0.25);
}

.btn-primary:hover {

    transform: translateY(-6px);

    background: #7f4c2a;

    box-shadow:
        0 20px 40px rgba(117, 70, 35, 0.35);
}

.btn-outline {

    border: 1px solid #9d6338;

    color: #8b542f;
}

.btn-outline:hover {

    background: #9d6338;

    color: #ffffff;

    transform: translateY(-6px);
}


/* ================= HERO IMAGE ================= */

.hero-image {

    position: relative;

    z-index: 2;

    animation: imageReveal 1.2s 0.5s both;
}

.hero-image img {

    height: 560px;

    object-fit: cover;

    border-radius: 180px 180px 25px 25px;

    box-shadow:
        0 30px 70px rgba(60, 38, 22, 0.25);

    transition: 0.8s;
}

.hero-image:hover img {

    transform: scale(1.03);
}

.hero-image::before {

    content: "";

    position: absolute;

    inset: 18px -18px -18px 18px;

    border: 1px solid #b88959;

    border-radius: 180px 180px 25px 25px;

    z-index: -1;

    animation: borderFloat 4s ease-in-out infinite;
}

@keyframes imageReveal {

    from {
        opacity: 0;
        transform: translateX(80px) scale(0.9);
    }

    to {
        opacity: 1;
        transform: translateX(0) scale(1);
    }

}

@keyframes borderFloat {

    50% {
        transform: translate(8px, -8px);
    }

}

@keyframes fadeUp {

    from {
        opacity: 0;
        transform: translateY(40px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }

}


/* ================= STORY ================= */

.story {

    padding: 120px 7%;

    background: #fffaf3;
}

.section-label {

    color: #a66c39;

    text-transform: uppercase;

    letter-spacing: 4px;

    font-size: 12px;
}

.story-grid {

    display: grid;

    grid-template-columns: 0.9fr 1.1fr;

    gap: 80px;

    align-items: center;
}

.story-image {

    position: relative;

    overflow: hidden;

    border-radius: 25px;
}

.story-image img {

    height: 550px;

    object-fit: cover;

    transition: 0.8s;
}

.story-image:hover img {

    transform: scale(1.08);
}

.story-content h2 {

    font-family: 'Cormorant Garamond', serif;

    font-size: 65px;

    line-height: 0.95;

    margin: 15px 0 25px;

    color: #302119;
}

.story-content h2 span {

    color: #ae7542;
}

.story-content p {

    color: #74665b;

    line-height: 1.9;

    margin-bottom: 18px;
}

.story-signature {

    margin-top: 30px;

    font-family: 'Cormorant Garamond', serif;

    font-size: 28px;

    color: #9b6237;
}


/* ================= STATS ================= */

.stats {

    padding: 70px 7%;

    background: #2c1d14;

    color: #ffffff;

    position: relative;

    overflow: hidden;
}

.stats-grid {

    display: grid;

    grid-template-columns: repeat(4, 1fr);

    gap: 25px;

    text-align: center;
}

.stat {

    padding: 25px;

    border-right: 1px solid rgba(255,255,255,0.1);

    animation: statFloat 4s ease-in-out infinite;
}

.stat:last-child {

    border-right: none;
}

.stat h3 {

    font-family: 'Cormorant Garamond', serif;

    font-size: 52px;

    color: #e2ae77;
}

.stat p {

    color: #c9b8aa;

    font-size: 13px;

    letter-spacing: 1px;
}

@keyframes statFloat {

    50% {
        transform: translateY(-8px);
    }

}


/* ================= VALUES ================= */

.values {

    padding: 120px 7%;

    background: #f5ede2;
}

.section-heading {

    text-align: center;

    max-width: 700px;

    margin: 0 auto 60px;
}

.section-heading h2 {

    font-family: 'Cormorant Garamond', serif;

    font-size: 65px;

    color: #302119;

    margin: 12px 0;
}

.section-heading p {

    color: #74665b;

    line-height: 1.8;
}

.values-grid {

    display: grid;

    grid-template-columns: repeat(3, 1fr);

    gap: 25px;
}

.value-card {

    padding: 45px 30px;

    background: rgba(255,255,255,0.65);

    border: 1px solid rgba(125,83,48,0.12);

    border-radius: 25px;

    text-align: center;

    transition: 0.5s;

    opacity: 0;

    transform: translateY(50px);
}

.value-card.show {

    opacity: 1;

    transform: translateY(0);
}

.value-card:hover {

    transform: translateY(-12px);

    box-shadow:
        0 25px 50px rgba(70,43,23,0.12);
}

.value-icon {

    font-size: 45px;

    margin-bottom: 20px;

    display: inline-block;

    animation: iconBounce 3s ease-in-out infinite;
}

@keyframes iconBounce {

    50% {
        transform: translateY(-10px) rotate(4deg);
    }

}

.value-card h3 {

    font-family: 'Cormorant Garamond', serif;

    font-size: 30px;

    color: #8f5b35;

    margin-bottom: 12px;
}

.value-card p {

    color: #74665b;

    line-height: 1.8;

    font-size: 14px;
}


/* ================= TEAM ================= */

.team {

    padding: 120px 7%;

    background: #fffaf3;
}

.team-grid {

    display: grid;

    grid-template-columns: repeat(3, 1fr);

    gap: 25px;
}

.team-card {

    position: relative;

    overflow: hidden;

    border-radius: 25px;

    opacity: 0;

    transform: translateY(50px);

    transition: 0.6s;
}

.team-card.show {

    opacity: 1;

    transform: translateY(0);
}

.team-card img {

    height: 430px;

    object-fit: cover;

    transition: 0.8s;
}

.team-card:hover img {

    transform: scale(1.08);
}

.team-info {

    position: absolute;

    left: 20px;

    right: 20px;

    bottom: 20px;

    padding: 20px;

    background: rgba(35,23,15,0.85);

    backdrop-filter: blur(12px);

    border-radius: 18px;

    color: #ffffff;
}

.team-info h3 {

    font-family: 'Cormorant Garamond', serif;

    font-size: 28px;

    color: #e6b982;
}

.team-info p {

    color: #d4c4b8;

    font-size: 13px;

    margin-top: 4px;
}


/* ================= CTA ================= */

.cta {

    padding: 120px 7%;

    text-align: center;

    background:
        linear-gradient(
            rgba(39,25,17,0.90),
            rgba(39,25,17,0.90)
        ),
        url("veloure-signature-coffee.jpg");

    background-size: cover;

    background-position: center;

    background-attachment: fixed;

    color: #ffffff;
}

.cta h2 {

    font-family: 'Cormorant Garamond', serif;

    font-size: 75px;

    color: #edc18e;
}

.cta p {

    max-width: 650px;

    margin: 15px auto 30px;

    color: #d3c2b4;

    line-height: 1.8;
}


/* ================= FOOTER ================= */

footer {

    padding: 60px 7% 25px;

    background: #21140d;

    color: #ffffff;
}

.footer-grid {

    display: grid;

    grid-template-columns: 2fr 1fr 1fr;

    gap: 40px;
}

.footer-brand h2 {

    font-family: 'Cormorant Garamond', serif;

    font-size: 38px;

    color: #e2ae77;
}

.footer-brand p {

    color: #a9988c;

    line-height: 1.8;

    margin-top: 12px;

    max-width: 360px;
}

footer h3 {

    color: #e3c19d;

    margin-bottom: 15px;
}

footer a {

    display: block;

    color: #a9988c;

    margin: 9px 0;

    font-size: 14px;

    transition: 0.3s;
}

footer a:hover {

    color: #e2ae77;

    transform: translateX(5px);
}

.copyright {

    text-align: center;

    margin-top: 45px;

    padding-top: 20px;

    border-top: 1px solid rgba(255,255,255,0.08);

    color: #75665c;

    font-size: 13px;
}


/* ================= MOBILE ================= */

@media (max-width: 1000px) {

    .nav-links {

        display: none;

    }

    .menu-toggle {

        display: block;

    }

    .about-hero {

        grid-template-columns: 1fr;

    }

    .hero-image {

        max-width: 600px;

        margin: auto;

    }

    .story-grid {

        grid-template-columns: 1fr;

    }

    .stats-grid {

        grid-template-columns: repeat(2, 1fr);

    }

    .values-grid,
    .team-grid {

        grid-template-columns: 1fr 1fr;

    }

    .footer-grid {

        grid-template-columns: 1fr 1fr;

    }

}


@media (max-width: 650px) {

    .navbar {

        padding: 0 5%;

    }

    .logo {

        font-size: 25px;

    }

    .about-hero {

        padding: 120px 5% 70px;

        gap: 45px;

    }

    .hero-text h1 {

        font-size: 65px;

    }

    .hero-buttons {

        flex-direction: column;

        align-items: flex-start;

    }

    .hero-image img {

        height: 430px;

    }

    .story,
    .values,
    .team {

        padding: 80px 5%;

    }

    .story-content h2,
    .section-heading h2 {

        font-size: 50px;

    }

    .story-image img {

        height: 400px;

    }

    .stats-grid {

        grid-template-columns: 1fr 1fr;

    }

    .stat {

        border-right: none;

    }

    .stat h3 {

        font-size: 40px;

    }

    .values-grid,
    .team-grid,
    .footer-grid {

        grid-template-columns: 1fr;

    }

    .team-card img {

        height: 420px;

    }

    .cta h2 {

        font-size: 52px;

    }

}

</style>

</head>


<body>


<!-- ================= LOADER ================= -->

<div class="loader">

    <div class="loader-box">

        <div class="loader-cup">
            ☕
        </div>

        <h2>
            VELOURE
        </h2>

    </div>

</div>


<!-- ================= NAVBAR ================= -->

<nav class="navbar">

    <a href="index.php" class="logo">
        VELOURE
    </a>


    <div class="nav-links">

        <a href="index.php">
            Home
        </a>

        <a href="about.php" class="active">
            About
        </a>

        <a href="menu.php">
            Menu
        </a>

        <a href="offers.php">
            Offers
        </a>

        <a href="gallery.php">
            Gallery
        </a>

        <a href="services.php">
            Services
        </a>

        <a href="reservation.php" class="reserve">
            Reserve Table
        </a>

        <a href="reviews.php">
            Reviews
        </a>

    </div>


    <div
        class="menu-toggle"
        onclick="mobileMenu()"
    >
        ☰
    </div>

</nav>

<!-- ================= HERO ================= -->

<section class="about-hero">

    <div class="hero-text">

        <div class="hero-label">
            Discover VELOURE
        </div>

        <h1>
            More Than
            <br>
            <span>A Café.</span>
        </h1>

        <p>
            VELOURE is a place where handcrafted
            coffee, gourmet flavours and beautiful
            moments come together. Every detail is
            designed to make your experience memorable.
        </p>

        <div class="hero-buttons">

            <a href="menu.php" class="btn btn-primary">
                Explore Our Menu →
            </a>

            <a href="reservation.php" class="btn btn-outline">
                Reserve a Table
            </a>

        </div>

    </div>


    <div class="hero-image">

        <img
            src="coffee.jpg"
            alt="VELOURE Coffee"
        >

    </div>

</section>


<!-- ================= STORY ================= -->

<section class="story">

    <div class="story-grid">

        <div class="story-image">

            <img
                src="fast-food.jpg"
                alt="VELOURE Fast Food"
            >

        </div>


        <div class="story-content">

            <div class="section-label">
                Our Story
            </div>

            <h2>
                Born from a love
                <br>
                <span>of great coffee.</span>
            </h2>

            <p>
                VELOURE began with a simple idea —
                create a cafe where exceptional coffee
                and beautiful experiences meet.
            </p>

            <p>
                From carefully selected coffee beans
                to freshly prepared gourmet dishes,
                every creation is made with passion
                and attention to detail.
            </p>

            <p>
                Whether you are meeting someone special,
                working on your next big idea or simply
                enjoying a quiet coffee, VELOURE is designed
                to feel like your favourite place.
            </p>

            <div class="story-signature">
                Crafted with ♥ at VELOURE
            </div>

        </div>

    </div>

</section>


<!-- ================= STATS ================= -->

<section class="stats">

    <div class="stats-grid">


        <div class="stat">

            <h3>
                10+
            </h3>

            <p>
                Years of Passion
            </p>

        </div>


        <div class="stat">

            <h3>
                25K+
            </h3>

            <p>
                Happy Guests
            </p>

        </div>


        <div class="stat">

            <h3>
                40+
            </h3>

            <p>
                Signature Creations
            </p>

        </div>


        <div class="stat">

            <h3>
                4.9★
            </h3>

            <p>
                Guest Rating
            </p>

        </div>


    </div>

</section>


<!-- ================= VALUES ================= -->

<section class="values">

    <div class="section-heading">

        <div class="section-label">
            What We Believe
        </div>

        <h2>
            Our Values
        </h2>

        <p>

            The principles behind every cup,
            every dish and every experience
            at VELOURE.

        </p>

    </div>


    <div class="values-grid">


        <div class="value-card">

            <div class="value-icon">
                ☕
            </div>

            <h3>
                Quality First
            </h3>

            <p>

                We carefully select ingredients
                and coffee beans to deliver
                exceptional quality every time.

            </p>

        </div>


        <div class="value-card">

            <div class="value-icon">
                ✨
            </div>

            <h3>
                Beautiful Experiences
            </h3>

            <p>

                From ambience to presentation,
                we believe every detail should
                feel special.

            </p>

        </div>


        <div class="value-card">

            <div class="value-icon">
                ❤️
            </div>
            <h3>
                Made With Passion
            </h3>

            <p>

                Passion is at the heart of
                everything we carate and server

            </p>

        </div>


    </div>

</section>


<!-- ================= TEAM ================= -->

<section class="team">

    <div class="section-heading">

        <div class="section-label">
            The People Behind VELOURE
        </div>

        <h2>
            Crafted By Passionate People
        </h2>

        <p>

            Our team brings creativity,
            warmth and expertise to every
            guest experience.

        </p>

    </div>


    <div class="team-grid">


        <div class="team-card">

            <img
                src="head-barista.jpg"
                alt="Head Barista"
            >

            <div class="team-info">

                <h3>
                    Head Barista
                </h3>

                <p>
                    Coffee & Craft
                </p>

            </div>

        </div>


        <div class="team-card">

            <img
                src="executive-chef.jpg"
                alt="Executive Chef"
            >

            <div class="team-info">

                <h3>
                    Executive Chef
                </h3>

                <p>
                    Gourmet Kitchen
                </p>

            </div>

        </div>


        <div class="team-card">

            <img
                src="pastry-chef.jpg"
                alt="Pastry Artist"
            >

            <div class="team-info">

                <h3>
                    Pastry Artist
                </h3>

                <p>
                    Desserts & Creativity
                </p>

            </div>

        </div>


    </div>

</section>


<!-- ================= CTA ================= -->

<section class="cta">

    <h2>

        Your Perfect Coffee
        <br>
        Awaits.

    </h2>


    <p>

        Come to VELOURE and discover
        handcrafted coffee, delicious food
        and moments worth remembering.

    </p>


    <a
        href="reservation.php"
        class="btn btn-primary"
    >
        Reserve Your Table →
    </a>

</section>


<!-- ================= FOOTER ================= -->

<footer>

    <div class="footer-grid">


        <div class="footer-brand">

            <h2>
                VELOURE
            </h2>

            <p>

                A place where handcrafted coffee,
                gourmet flavours and beautiful
                moments come together.

            </p>

        </div>


        <div>

            <h3>
                Quick Links
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

            <a href="gallery.php">
                Gallery
            </a>

        </div>


        <div>

            <h3>
                Customer
            </h3>

            <a href="services.php">
                Services
            </a>

            <a href="reservation.php">
                Reservation
            </a>

            <a href="reviews.php">
                Reviews
            </a>

            <a href="reservation.php#booking">
                Contact Us
            </a>

        </div>


    </div>


    <div class="copyright">

        © 2026 VELOURE Artisan Café.
        All Rights Reserved.

    </div>

</footer>


<!-- ================= JAVASCRIPT ================= -->

<script>

/* ================= MOBILE MENU ================= */

function mobileMenu() {

    const nav =
        document.querySelector(".nav-links");

    if (nav.style.display === "flex") {

        nav.style.display = "none";

    } else {

        nav.style.display = "flex";

        nav.style.flexDirection = "column";

        nav.style.position = "absolute";

        nav.style.top = "78px";

        nav.style.left = "0";

        nav.style.width = "100%";

        nav.style.padding = "25px";

        nav.style.background = "#2b1e15";

        nav.style.gap = "20px";

    }

}


/* ================= SCROLL ANIMATION ================= */

const animatedElements =
    document.querySelectorAll(
        ".value-card, .team-card"
    );


const observer =
    new IntersectionObserver(
        function(entries) {

            entries.forEach(
                function(entry) {

                    if (
                        entry.isIntersecting
                    ) {

                        entry.target.classList.add(
                            "show"
                        );

                    }

                }
            );

        },
        {
            threshold: 0.15
        }
    );


animatedElements.forEach(
    function(element) {

        observer.observe(element);

    }
);


/* ================= NAVBAR SCROLL ================= */

window.addEventListener(
    "scroll",
    function() {

        const navbar =
            document.querySelector(".navbar");

        if (window.scrollY > 50) {

            navbar.style.background =
                "rgba(35,23,15,0.97)";

        } else {

            navbar.style.background =
                "rgba(43,30,21,0.92)";

        }

    }
);


/* ================= CLOSE MOBILE MENU ================= */

document
    .querySelectorAll(".nav-links a")
    .forEach(
        function(link) {

            link.addEventListener(
                "click",
                function() {

                    if (
                        window.innerWidth <= 1000
                    ) {

                        document
                            .querySelector(".nav-links")
                            .style.display = "none";

                    }

                }
            );

        }
    );

</script>


</body>

</html>