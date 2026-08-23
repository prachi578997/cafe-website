<?php
// ==========================================
// VELOURE CAFE - RESERVATION PAGE
// ==========================================

date_default_timezone_set("Asia/Kolkata");

$today = date("Y-m-d");
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Veloure Café | Reservation</title>

<link rel="preconnect" href="https://fonts.googleapis.com">

<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

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
    background:#f6f1e8;
    color:#35251d;
    overflow-x:hidden;
}


/* ==============================
   NAVBAR
============================== */

.navbar{
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:78px;
    padding:0 7%;
    display:flex;
    align-items:center;
    justify-content:space-between;
    background:rgba(246,241,232,.95);
    backdrop-filter:blur(15px);
    border-bottom:1px solid #e1d5c5;
    z-index:1000;
    animation:navDown .8s ease;
}

.logo{
    text-decoration:none;
    color:#35251d;
    text-align:center;
}

.logo h1{
    font-family:"Cormorant Garamond",serif;
    font-size:32px;
    letter-spacing:3px;
    line-height:.8;
}

.logo span{
    display:block;
    color:#a47b4c;
    font-size:8px;
    letter-spacing:4px;
    margin-top:7px;
}

.back-btn{
    text-decoration:none;
    color:#35251d;
    border:1px solid #bfa88e;
    padding:10px 20px;
    border-radius:30px;
    font-size:13px;
    font-weight:600;
    transition:.3s;
}

.back-btn:hover{
    background:#35251d;
    color:#fff;
    transform:translateY(-2px);
}


/* ==============================
   PAGE
============================== */

.reservation-section{
    min-height:100vh;
    padding:125px 20px 70px;
    display:flex;
    align-items:center;
    justify-content:center;
    position:relative;
    overflow:hidden;
}


/* Decorative animation */

.reservation-section::before{
    content:"";
    position:absolute;
    width:400px;
    height:400px;
    border-radius:50%;
    background:#c9a878;
    opacity:.10;
    top:-170px;
    left:-160px;
    animation:floatOne 7s ease-in-out infinite;
}

.reservation-section::after{
    content:"";
    position:absolute;
    width:350px;
    height:350px;
    border-radius:50%;
    background:#a47b4c;
    opacity:.08;
    right:-150px;
    bottom:-150px;
    animation:floatTwo 8s ease-in-out infinite;
}


/* ==============================
   MAIN BOX
============================== */

.reservation-box{
    width:100%;
    max-width:1100px;
    display:grid;
    grid-template-columns:40% 60%;
    background:#fff;
    border-radius:28px;
    overflow:hidden;
    position:relative;
    z-index:2;
    box-shadow:0 30px 80px rgba(53,37,29,.16);
    animation:boxAnimation 1s ease;
}


/* ==============================
   LEFT SIDE
============================== */

.info-side{
    background:#35251d;
    color:#fff;
    padding:50px 42px;
    position:relative;
    overflow:hidden;
}

.info-side::before{
    content:"";
    position:absolute;
    width:280px;
    height:280px;
    border:1px solid rgba(214,178,123,.25);
    border-radius:50%;
    right:-110px;
    top:-90px;
    animation:rotateCircle 18s linear infinite;
}

.info-side::after{
    content:"";
    position:absolute;
    width:180px;
    height:180px;
    border:1px solid rgba(214,178,123,.18);
    border-radius:50%;
    left:-90px;
    bottom:-70px;
    animation:rotateCircle 14s linear infinite reverse;
}

.info-label{
    color:#d4b27f;
    font-size:11px;
    letter-spacing:4px;
    font-weight:700;
    margin-bottom:15px;
}

.info-side h2{
    font-family:"Cormorant Garamond",serif;
    font-size:52px;
    line-height:1;
    margin-bottom:20px;
}

.info-side > p{
    color:#d8c9bb;
    font-size:14px;
    line-height:1.8;
    margin-bottom:35px;
}

.info-list{
    border-top:1px solid rgba(255,255,255,.15);
    padding-top:15px;
}

.info-item{
    display:flex;
    align-items:center;
    gap:14px;
    margin:20px 0;
    font-size:13px;
    color:#eee4db;
}

.info-icon{
    width:42px;
    height:42px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:50%;
    background:rgba(255,255,255,.08);
    font-size:18px;
    transition:.3s;
    flex-shrink:0;
}

.info-item:hover .info-icon{
    background:#c9a878;
    color:#35251d;
    transform:scale(1.1) rotate(8deg);
}


/* ==============================
   FORM SIDE
============================== */

.form-side{
    padding:50px;
    background:#fff;
}

.form-heading{
    margin-bottom:30px;
}

.form-heading h1{
    font-family:"Cormorant Garamond",serif;
    font-size:45px;
    margin-bottom:5px;
}

.form-heading p{
    color:#806f61;
    font-size:13px;
}


/* ==============================
   FORM ROW
============================== */

.form-row{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:18px;
}

.form-group{
    margin-bottom:18px;
}

.form-group label{
    display:block;
    font-size:13px;
    font-weight:600;
    margin-bottom:7px;
    color:#49372d;
}

.form-group input,
.form-group select,
.form-group textarea{
    width:100%;
    padding:13px 14px;
    border:1px solid #ded1c1;
    border-radius:10px;
    background:#fffdf9;
    color:#35251d;
    outline:none;
    font-family:"DM Sans",sans-serif;
    font-size:13px;
    transition:.3s;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus{
    border-color:#a47b4c;
    background:#fff;
    box-shadow:0 0 0 4px rgba(164,123,76,.10);
    transform:translateY(-1px);
}

.form-group textarea{
    min-height:100px;
    resize:vertical;
}


/* ==============================
   BUTTON
============================== */

.submit-btn{
    width:100%;
    padding:16px;
    border:none;
    border-radius:12px;
    background:#35251d;
    color:#fff;
    font-size:15px;
    font-weight:700;
    font-family:"DM Sans",sans-serif;
    cursor:pointer;
    transition:.35s;
    position:relative;
    overflow:hidden;
}

.submit-btn::before{
    content:"";
    position:absolute;
    top:0;
    left:-100%;
    width:100%;
    height:100%;
    background:linear-gradient(
        90deg,
        transparent,
        rgba(255,255,255,.18),
        transparent
    );
    transition:.6s;
}

.submit-btn:hover::before{
    left:100%;
}

.submit-btn:hover{
    background:#a47b4c;
    transform:translateY(-3px);
    box-shadow:0 12px 30px rgba(164,123,76,.25);
}

.submit-btn span{
    position:relative;
    z-index:2;
}


/* ==============================
   NOTE
============================== */

.form-note{
    text-align:center;
    color:#8b7a6d;
    font-size:11px;
    margin-top:12px;
}


/* ==============================
   ANIMATIONS
============================== */

@keyframes navDown{
    from{
        opacity:0;
        transform:translateY(-100%);
    }
    to{
        opacity:1;
        transform:translateY(0);
    }
}

@keyframes boxAnimation{
    from{
        opacity:0;
        transform:translateY(45px) scale(.97);
    }
    to{
        opacity:1;
        transform:translateY(0) scale(1);
    }
}

@keyframes floatOne{
    0%,100%{
        transform:translate(0,0);
    }
    50%{
        transform:translate(30px,25px);
    }
}

@keyframes floatTwo{
    0%,100%{
        transform:translate(0,0);
    }
    50%{
        transform:translate(-25px,-20px);
    }
}

@keyframes rotateCircle{
    from{
        transform:rotate(0deg);
    }
    to{
        transform:rotate(360deg);
    }
}


/* ==============================
   RESPONSIVE
============================== */

@media(max-width:850px){

    .reservation-box{
        grid-template-columns:1fr;
    }

    .info-side{
        padding:40px 30px;
    }

    .info-side h2{
        font-size:45px;
    }

    .form-side{
        padding:40px 30px;
    }
}

@media(max-width:600px){

    .navbar{
        height:70px;
        padding:0 5%;
    }

    .logo h1{
        font-size:27px;
    }

    .back-btn{
        padding:8px 13px;
        font-size:11px;
    }

    .reservation-section{
        padding:100px 14px 40px;
    }

    .form-row{
        grid-template-columns:1fr;
        gap:0;
    }

    .form-side{
        padding:35px 22px;
    }

    .form-heading h1{
        font-size:38px;
    }

    .info-side h2{
        font-size:40px;
    }
}

</style>

</head>


<body>


<!-- ==============================
     NAVBAR
============================== -->

<nav class="navbar">

    <a href="index.php" class="logo">

        <h1>VELOURE</h1>

        <span>ARTISAN CAFÉ</span>

    </a>

    <a href="offers.php" class="back-btn">
        ← Back to Offers
    </a>

</nav>



<!-- ==============================
     RESERVATION SECTION
============================== -->

<section class="reservation-section">


<div class="reservation-box">


    <!-- ==========================
         INFORMATION
    =========================== -->

    <div class="info-side">

        <div class="info-label">
            RESERVE YOUR EXPERIENCE
        </div>

        <h2>
            Your Table,<br>
            Your Moment.
        </h2>

        <p>
            Reserve your table at Veloure Café
            and enjoy handcrafted coffee,
            delicious cuisine and an elegant
            ambience made for memorable moments.
        </p>


        <div class="info-list">


            <div class="info-item">

                <div class="info-icon">
                    ☕
                </div>

                <span>
                    Premium Coffee & Cuisine
                </span>

            </div>


            <div class="info-item">

                <div class="info-icon">
                    🕐
                </div>

                <span>
                    9:00 AM – 11:00 PM
                </span>

            </div>


            <div class="info-item">

                <div class="info-icon">
                    ✨
                </div>

                <span>
                    Elegant Café Ambience
                </span>

            </div>


            <div class="info-item">

                <div class="info-icon">
                    🎉
                </div>

                <span>
                    Perfect for Celebrations
                </span>

            </div>


        </div>

    </div>



    <!-- ==========================
         FORM
    =========================== -->

    <div class="form-side">


        <div class="form-heading">

            <h1>
                Reserve a Table
            </h1>

            <p>
                Enter your details below to confirm your reservation.
            </p>

        </div>


        <form
            action="save_reservation.php"
            method="POST"
            id="reservationForm"
        >


            <!-- NAME + PHONE -->

            <div class="form-row">


                <div class="form-group">

                    <label>
                        Customer Name *
                    </label>

                    <input
                        type="text"
                        name="name"
                        placeholder="Enter your full name"
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
                        name="phone"
                        id="phone"
                        placeholder="10-digit mobile number"
                        pattern="[0-9]{10}"
                        maxlength="10"
                        inputmode="numeric"
                        required
                    >

                </div>


            </div>



            <!-- EMAIL -->

            <div class="form-group">

                <label>
                    Email Address
                </label>

                <input
                    type="email"
                    name="email"
                    placeholder="Enter your email address"
                >

            </div>



            <!-- DATE + TIME -->

            <div class="form-row">


                <div class="form-group">

                    <label>
                        Reservation Date *
                    </label>

                    <input
                        type="date"
                        name="date"
                        id="date"
                        min="<?php echo $today; ?>"
                        required
                    >

                </div>


                <div class="form-group">

                    <label>
                        Reservation Time *
                    </label>

                    <input
                        type="time"
                        name="time"
                        required
                    >

                </div>


            </div>



            <!-- GUESTS + OCCASION -->

            <div class="form-row">


                <div class="form-group">

                    <label>
                        Number of Guests *
                    </label>

                    <select name="guests" required>

                        <option value="">
                            Select guests
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
                        Occasion
                    </label>

                    <select name="occasion">

                        <option value="">
                            Select occasion
                        </option>

                        <option value="Casual Visit">
                            Casual Visit
                        </option>

                        <option value="Birthday">
                            Birthday
                        </option>

                        <option value="Anniversary">
                            Anniversary
                        </option>

                        <option value="Date">
                            Date
                        </option>

                        <option value="Family Gathering">
                            Family Gathering
                        </option>

                        <option value="Business Meeting">
                            Business Meeting
                        </option>

                        <option value="Other">
                            Other
                        </option>

                    </select>

                </div>


            </div>



            <!-- SPECIAL REQUEST -->

            <div class="form-group">

                <label>
                    Special Request
                </label>

                <textarea
                    name="message"
                    placeholder="Any special request? (Optional)"
                    maxlength="300"
                ></textarea>

            </div>



            <!-- SUBMIT -->

            <button
                type="submit"
                class="submit-btn"
                id="submitBtn"
            >

                <span>
                    Confirm Reservation →
                </span>

            </button>


            <p class="form-note">
                🔒 Your reservation details are securely saved.
            </p>


        </form>

    </div>


</div>

</section>



<script>

/* ==============================
   MOBILE NUMBER
============================== */

const phone =
document.getElementById("phone");

phone.addEventListener(
    "input",
    function(){

        this.value =
        this.value.replace(
            /[^0-9]/g,
            ""
        );

    }
);


/* ==============================
   FORM SUBMIT
============================== */

const form =
document.getElementById(
    "reservationForm"
);

const button =
document.getElementById(
    "submitBtn"
);

form.addEventListener(
    "submit",
    function(event){

        const phoneValue =
        phone.value.trim();

        if(
            !/^[0-9]{10}$/.test(
                phoneValue
            )
        ){

            event.preventDefault();

            alert(
                "Please enter a valid 10-digit mobile number."
            );

            phone.focus();

            return;
        }

        button.querySelector("span")
        .textContent =
        "Saving Reservation...";

        button.style.pointerEvents =
        "none";

    }
);

</script>


</body>

</html>