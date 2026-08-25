<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Services | VELOURE Artisan Café</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=DM+Sans:wght@400;500;600;700&display=swap"
rel="stylesheet">

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
    font-family:'DM Sans',sans-serif;
    background:#f7f2ea;
    color:#2c211b;
    overflow-x:hidden;
}

/* ================= NAVBAR ================= */

.navbar{
    position:fixed;
    top:0;
    left:0;
    width:100%;
    z-index:1000;

    display:flex;
    justify-content:space-between;
    align-items:center;

    padding:18px 6%;

    background:rgba(255,250,244,.96);
    backdrop-filter:blur(15px);

    box-shadow:0 5px 25px rgba(50,35,25,.08);
}

.logo{
    font-family:'Cormorant Garamond',serif;
    font-size:32px;
    font-weight:700;
    letter-spacing:4px;
    color:#4b3024;
}

.logo span{
    color:#a36b42;
}

.nav-links{
    display:flex;
    align-items:center;
    gap:24px;
}

.nav-links a{
    text-decoration:none;
    color:#3d2a20;
    font-size:13px;
    font-weight:600;
    position:relative;
    transition:.3s;
}

.nav-links a::after{
    content:"";
    position:absolute;
    left:0;
    bottom:-7px;
    width:0;
    height:2px;
    background:#a36b42;
    transition:.3s;
}

.nav-links a:hover,
.nav-links a.active{
    color:#a36b42;
}

.nav-links a:hover::after,
.nav-links a.active::after{
    width:100%;
}

.reserve-btn{
    text-decoration:none !important;
    background:#4b3024 !important;
    color:white !important;
    padding:11px 20px;
    border-radius:30px;
    font-size:12px !important;
    transition:.3s;
}

.reserve-btn:hover{
    background:#a36b42 !important;
    transform:translateY(-2px);
}


/* ================= HERO ================= */

.hero{
    min-height:70vh;
    padding:160px 8% 100px;

    display:flex;
    align-items:center;
    justify-content:center;

    text-align:center;

    position:relative;
    overflow:hidden;

    background:
    radial-gradient(
        circle at 20% 20%,
        rgba(163,107,66,.16),
        transparent 30%
    ),
    radial-gradient(
        circle at 80% 70%,
        rgba(92,62,44,.12),
        transparent 30%
    );
}

.hero::before{
    content:"";
    position:absolute;

    width:350px;
    height:350px;

    border-radius:50%;

    border:1px solid rgba(163,107,66,.2);

    animation:rotateCircle 15s linear infinite;
}

.hero-content{
    position:relative;
    z-index:2;

    animation:heroReveal 1.3s ease;
}

.small-title{
    color:#a36b42;
    font-size:13px;
    letter-spacing:4px;
    text-transform:uppercase;
    margin-bottom:15px;
}

.hero h1{
    font-family:'Cormorant Garamond',serif;
    font-size:75px;
    line-height:1;
    color:#3b281e;
    margin-bottom:25px;
}

.hero h1 span{
    color:#a36b42;
    font-style:italic;
}

.hero p{
    max-width:650px;
    margin:auto;
    line-height:1.8;
    color:#715d50;
    font-size:15px;
}


/* ================= SERVICES ================= */

.services{
    padding:100px 7%;
    background:#fffaf3;
}

.section-heading{
    text-align:center;
    margin-bottom:65px;
}

.section-heading .mini{
    color:#a36b42;
    letter-spacing:4px;
    font-size:12px;
    text-transform:uppercase;
}

.section-heading h2{
    font-family:'Cormorant Garamond',serif;
    font-size:52px;
    margin:12px 0;
    color:#3b281e;
}

.section-heading p{
    max-width:650px;
    margin:auto;
    color:#79665a;
    line-height:1.7;
}

.service-grid{
    max-width:1200px;
    margin:auto;

    display:grid;
    grid-template-columns:repeat(4,1fr);

    gap:25px;
}

.service-card{
    position:relative;

    padding:20px;

    text-align:center;

    background:rgba(255,255,255,.95);

    border:1px solid rgba(163,107,66,.15);

    border-radius:25px;

    overflow:hidden;

    transition:.5s;

    opacity:0;
    transform:translateY(60px);
}

.service-card.show{
    opacity:1;
    transform:translateY(0);
}

.service-card:hover{
    transform:translateY(-12px) scale(1.02);

    box-shadow:
        0 25px 50px
        rgba(70,45,30,.12);

    border-color:
        rgba(163,107,66,.4);
}

.service-image-link{
    display:block;

    width:100%;
    height:190px;

    overflow:hidden;

    border-radius:18px;

    margin-bottom:22px;

    position:relative;

    cursor:pointer;
}

.service-image-link::after{
    content:"VIEW & RESERVE";

    position:absolute;

    inset:0;

    display:flex;
    align-items:center;
    justify-content:center;

    background:rgba(45,27,18,.48);

    color:white;

    font-size:11px;
    letter-spacing:2px;
    font-weight:700;

    opacity:0;

    transition:.3s;
}

.service-image-link:hover::after{
    opacity:1;
}

.service-image-link img{
    width:100%;
    height:100%;

    display:block;

    object-fit:cover;

    transition:.4s ease;
}

.service-image-link:hover img{
    transform:scale(1.08);
}

.service-card h3{
    font-family:'Cormorant Garamond',serif;

    font-size:28px;

    margin-bottom:12px;

    color:#3b281e;
}

.service-card p{
    font-size:14px;

    line-height:1.7;

    color:#77665b;
}


/* ================= RESERVATION ================= */

.reservation-section{
    padding:110px 7%;
    background:#f7f2ea;
}

.reservation-box{
    max-width:1100px;

    margin:auto;

    padding:65px;

    background:
        linear-gradient(
            135deg,
            #4b3024,
            #241713
        );

    border-radius:30px;

    color:white;

    box-shadow:
        0 25px 60px
        rgba(50,30,20,.18);
}

.reservation-title{
    text-align:center;
    margin-bottom:40px;
}

.reservation-title small{
    color:#c18a61;
    letter-spacing:4px;
    font-size:12px;
}

.reservation-title h2{
    font-family:'Cormorant Garamond',serif;
    font-size:55px;
    margin:10px 0;
}

.reservation-title p{
    color:rgba(255,255,255,.72);
    line-height:1.7;
}

.reservation-form{
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:20px;
}

.form-group label{
    display:block;
    margin-bottom:8px;

    font-size:13px;
    color:#eadcc9;
    font-weight:600;
}

.form-group input,
.form-group select,
.form-group textarea{
    width:100%;

    padding:14px 15px;

    border:none;
    outline:none;

    border-radius:10px;

    background:#fffaf4;

    color:#38271f;

    font-family:'DM Sans',sans-serif;

    font-size:13px;
}

.form-group textarea{
    min-height:120px;
    resize:vertical;
}

.full-width{
    grid-column:1 / -1;
}

.submit-btn{
    grid-column:1 / -1;

    border:none;

    padding:15px;

    border-radius:30px;

    background:#c18a61;

    color:white;

    font-family:'DM Sans',sans-serif;

    font-weight:700;

    font-size:14px;

    cursor:pointer;

    transition:.35s;
}

.submit-btn:hover{
    background:#d09a70;

    transform:translateY(-3px);

    box-shadow:
        0 12px 25px
        rgba(0,0,0,.25);
}


/* ================= FEATURE ================= */

.feature{
    padding:110px 7%;

    background:#4b3024;

    color:white;

    text-align:center;

    position:relative;

    overflow:hidden;
}

.feature-content{
    position:relative;
    z-index:2;
}

.feature h2{
    font-family:'Cormorant Garamond',serif;
    font-size:55px;
    margin-bottom:15px;
}

.feature p{
    max-width:650px;
    margin:auto;
    line-height:1.8;
    opacity:.85;
}

.feature-btn{
    display:inline-block;

    margin-top:30px;

    padding:14px 30px;

    background:#f3e4d6;

    color:#4b3024;

    border-radius:30px;

    text-decoration:none;

    font-weight:600;

    transition:.4s;
}

.feature-btn:hover{
    transform:translateY(-5px) scale(1.05);

    box-shadow:
        0 15px 30px
        rgba(0,0,0,.2);
}


/* ================= FOOTER ================= */

footer{
    background:#241914;

    color:white;

    text-align:center;

    padding:40px 20px;
}

footer .footer-logo{
    font-family:'Cormorant Garamond',serif;

    font-size:30px;

    letter-spacing:4px;
}

footer p{
    margin-top:8px;

    font-size:13px;

    opacity:.65;
}


/* ================= ANIMATIONS ================= */

@keyframes heroReveal{

    from{
        opacity:0;
        transform:translateY(50px);
    }

    to{
        opacity:1;
        transform:translateY(0);
    }
}

@keyframes rotateCircle{

    from{
        transform:rotate(0deg) scale(.8);
    }

    to{
        transform:rotate(360deg) scale(1.2);
    }
}


/* ================= RESPONSIVE ================= */

@media(max-width:1100px){

    .nav-links{
        gap:12px;
    }

    .nav-links a{
        font-size:11px;
    }

    .service-grid{
        grid-template-columns:repeat(3,1fr);
    }
}

@media(max-width:900px){

    .service-grid{
        grid-template-columns:repeat(2,1fr);
    }

    .reservation-form{
        grid-template-columns:1fr;
    }

    .full-width,
    .submit-btn{
        grid-column:auto;
    }
}

@media(max-width:700px){

    .navbar{
        padding:15px 5%;
    }

    .nav-links{
        display:none;
    }

    .reserve-btn{
        padding:10px 16px;
    }

    .hero{
        min-height:60vh;
        padding:140px 6% 80px;
    }

    .hero h1{
        font-size:48px;
    }

    .section-heading h2{
        font-size:42px;
    }

    .service-grid{
        grid-template-columns:1fr;
    }

    .feature h2{
        font-size:42px;
    }

    .reservation-box{
        padding:40px 25px;
    }

    .reservation-title h2{
        font-size:42px;
    }
}

@media(max-width:450px){

    .logo{
        font-size:27px;
    }

    .hero h1{
        font-size:42px;
    }

    .hero p{
        font-size:13px;
    }

    .services{
        padding:75px 5%;
    }

    .service-image-link{
        height:210px;
    }
}

</style>

</head>

<body>


<!-- ================= NAVBAR ================= -->

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

        <a href="services.php" class="active">Services</a>

        <a href="reservation.php">Reservation</a>

        <a href="reviews.php">Reviews</a>

    </div>

    <a
        href="reservation.php#booking"
        class="reserve-btn"
        onclick="openServiceReservation(event)"
    >
        Reserve Table
    </a>

</nav>


<!-- ================= HERO ================= -->

<section class="hero">

    <div class="hero-content">

        <div class="small-title">
            The VELOURE Experience
        </div>

        <h1>
            Services Designed<br>
            <span>For You</span>
        </h1>

        <p>
            From handcrafted coffee to memorable
            celebrations, every experience at
            VELOURE is thoughtfully designed
            to make your visit special.
        </p>

    </div>

</section>


<!-- ================= SERVICES ================= -->

<section class="services">

    <div class="section-heading">

        <div class="mini">
            What We Offer
        </div>

        <h2>
            Our Premium Services
        </h2>

        <p>
            Discover thoughtful services created
            to make every visit comfortable,
            memorable and effortless.
        </p>

    </div>


    <div class="service-grid">


        <!-- SERVICE 1 -->

        <div class="service-card">

            <a
                href="reservation.php#booking"
                onclick="openServiceReservation(event)"
                class="service-image-link"
            >

                <img
                    src="images/dine-in.jpg"
                    alt="Dine-In Experience"
                >

            </a>

            <h3>
                Dine-In Experience
            </h3>

            <p>
                Relax in our elegant ambience
                and enjoy freshly prepared coffee,
                food and desserts.
            </p>

        </div>


        <!-- SERVICE 2 -->

        <div class="service-card">

            <a
                href="reservation.php#booking"
                onclick="openServiceReservation(event)"
                class="service-image-link"
            >

                <img
                    src="images/takeaway.jpg"
                    alt="Takeaway"
                >

            </a>

            <h3>
                Takeaway
            </h3>

            <p>
                Order your favourite coffee and
                meals and enjoy them wherever
                you go.
            </p>

        </div>


        <!-- SERVICE 3 -->

        <div class="service-card">

            <a
                href="reservation.php#booking"
                onclick="openServiceReservation(event)"
                class="service-image-link"
            >

                <img
                    src="images/delivery.jpg"
                    alt="Home Delivery"
                >

            </a>

            <h3>
                Home Delivery
            </h3>

            <p>
                Enjoy VELOURE favourites
                delivered fresh and conveniently
                to your doorstep.
            </p>

        </div>


        <!-- SERVICE 4 -->

        <div class="service-card">

            <a
                href="reservation.php#booking"
                onclick="openServiceReservation(event)"
                class="service-image-link"
            >

                <img
                    src="images/celebration.jpg"
                    alt="Celebrations"
                >

            </a>

            <h3>
                Celebrations
            </h3>

            <p>
                Celebrate birthdays, anniversaries
                and special moments with us.
            </p>

        </div>


        <!-- SERVICE 5 -->

        <div class="service-card">

            <a
                href="reservation.php#booking"
                onclick="openServiceReservation(event)"
                class="service-image-link"
            >

                <img
                    src="images/couple-dining.jpg"
                    alt="Couple Dining"
                >

            </a>

            <h3>
                Couple Dining
            </h3>

            <p>
                Enjoy a cozy and intimate dining
                experience designed for special
                moments together.
            </p>

        </div>


        <!-- SERVICE 6 -->

        <div class="service-card">

            <a
                href="reservation.php#booking"
                onclick="openServiceReservation(event)"
                class="service-image-link"
            >

                <img
                    src="images/event-booking.jpg"
                    alt="Event Booking"
                >

            </a>

            <h3>
                Event Booking
            </h3>

            <p>
                Host private gatherings,
                parties and small events
                in our stylish café.
            </p>

        </div>


        <!-- SERVICE 7 -->

        <div class="service-card">

            <a
                href="reservation.php#booking"
                onclick="openServiceReservation(event)"
                class="service-image-link"
            >

                <img
                    src="images/wifi.jpg"
                    alt="Free Wi-Fi"
                >

            </a>

            <h3>
                Free Wi-Fi
            </h3>

            <p>
                Work, study or relax with
                complimentary high-speed
                Wi-Fi.
            </p>

        </div>


        <!-- SERVICE 8 -->

        <div class="service-card">

            <a
                href="reservation.php#booking"
                onclick="openServiceReservation(event)"
                class="service-image-link"
            >

                <img
                    src="images/reservation.jpg"
                    alt="Online Reservation"
                >

            </a>

            <h3>
                Online Reservation
            </h3>

            <p>
                Reserve your preferred table
                online quickly and conveniently.
            </p>

        </div>


    </div>

</section>


<!-- ================= RESERVATION ================= -->

<section
    class="reservation-section"
    id="booking"
>

    <div class="reservation-box">

        <div class="reservation-title">

            <small>
                BOOK YOUR TABLE
            </small>

            <h2>
                Online Reservation
            </h2>

            <p>
                Choose your preferred date and time
                and reserve your table at VELOURE
                Artisan Café.
            </p>

        </div>


        <form
            class="reservation-form"
            action="reservation.php"
            method="POST"
        >


            <div class="form-group">

                <label>
                    Full Name
                </label>

                <input
                    type="text"
                    name="name"
                    placeholder="Enter your name"
                    required
                >

            </div>


            <div class="form-group">

                <label>
                    Phone Number
                </label>

                <input
                    type="tel"
                    name="phone"
                    placeholder="Enter phone number"
                    required
                >

            </div>


            <div class="form-group">

                <label>
                    Email Address
                </label>

                <input
                    type="email"
                    name="email"
                    placeholder="Enter email address"
                    required
                >

            </div>


            <div class="form-group">

                <label>
                    Number of Guests
                </label>

                <select
                    name="guests"
                    required
                >

                    <option value="">
                        Select Guests
                    </option>

                    <option value="1">1 Guest</option>
                    <option value="2">2 Guests</option>
                    <option value="3">3 Guests</option>
                    <option value="4">4 Guests</option>
                    <option value="5">5 Guests</option>
                    <option value="6">6 Guests</option>
                    <option value="7">7 Guests</option>
                    <option value="8">8 Guests</option>
                    <option value="9">9 Guests</option>
                    <option value="10">10 Guests</option>

                </select>

            </div>


            <div class="form-group">

                <label>
                    Reservation Date
                </label>

                <input
                    type="date"
                    name="date"
                    required
                >

            </div>


            <div class="form-group">

                <label>
                    Reservation Time
                </label>

                <select
                    name="time"
                    required
                >

                    <option value="">
                        Select Time
                    </option>

                    <option>10:00 AM</option>
                    <option>11:00 AM</option>
                    <option>12:00 PM</option>
                    <option>01:00 PM</option>
                    <option>02:00 PM</option>
                    <option>04:00 PM</option>
                    <option>05:00 PM</option>
                    <option>06:00 PM</option>
                    <option>07:00 PM</option>
                    <option>08:00 PM</option>
                    <option>09:00 PM</option>

                </select>

            </div>


            <div class="form-group">

                <label>
                    Occasion
                </label>

                <select name="occasion">

                    <option value="">
                        Select Occasion
                    </option>

                    <option>
                        Regular Dining
                    </option>

                    <option>
                        Birthday
                    </option>

                    <option>
                        Anniversary
                    </option>

                    <option>
                        Couple Date
                    </option>

                    <option>
                        Family Gathering
                    </option>

                    <option>
                        Business Meeting
                    </option>

                    <option>
                        Other
                    </option>

                </select>

            </div>


            <div class="form-group full-width">

                <label>
                    Special Request
                </label>

                <textarea
                    name="special_request"
                    placeholder="Any special request..."
                ></textarea>

            </div>


            <button
                type="submit"
                class="submit-btn"
            >

                Reserve My Table

            </button>

        </form>

    </div>

</section>


<!-- ================= FEATURE ================= -->

<section class="feature">

    <div class="feature-content">

        <h2>
            Make Every Moment Special
        </h2>

        <p>
            Whether you're meeting friends,
            celebrating a special occasion
            or enjoying coffee alone,
            VELOURE is your place to slow
            down and enjoy.
        </p>

        <a
            href="reservation.php#booking"
            class="feature-btn"
            onclick="openServiceReservation(event)"
        >

            Reserve Your Table

        </a>

    </div>

</section>


<!-- ================= FOOTER ================= -->

<footer>

    <div class="footer-logo">
        VELOURE
    </div>

    <p>
        Artisan Café · Crafted with Passion
    </p>

    <p>
        © 2026 VELOURE Artisan Café.
        All Rights Reserved.
    </p>

</footer>


<script>

/* =====================================================
   SERVICE → RESERVATION FIX
===================================================== */

function openServiceReservation(event){

    if(event){
        event.preventDefault();
    }

    /*
     * Menu मधून आधी selected केलेले items
     * Services मधून reservation करताना clear होतील.
     */
    localStorage.removeItem("veloureReservations");

    /*
     * Clean reservation page open होईल.
     */
    window.location.href =
        "reservation.php#booking";
}


/* =====================================================
   SERVICE CARD ANIMATION
===================================================== */

const cards =
    document.querySelectorAll(".service-card");

const observer =
    new IntersectionObserver(

        (entries) => {

            entries.forEach(entry => {

                if(entry.isIntersecting){

                    entry.target.classList.add("show");

                }

            });

        },

        {
            threshold:0.15
        }

    );

cards.forEach(card => {

    observer.observe(card);

});


/* =====================================================
   DATE VALIDATION
===================================================== */

const dateInput =
    document.querySelector(
        'input[name="date"]'
    );

if(dateInput){

    const today =
        new Date()
        .toISOString()
        .split("T")[0];

    dateInput.min = today;

}

</script>

</body>
</html>