```php
<?php

// ==========================================
// VELOURE CAFE - GALLERY
// ==========================================

$gallery = [

    [
        "image" => "barista-making-coffee.jpg",
        "title" => "Barista Making Coffee",
        "description" => "Our expert barista prepares freshly brewed coffee with care and precision.",
        "price" => 249,
        "rating" => "4.9"
    ],

    [
        "image" => "cafe-exterior.jpg",
        "title" => "Café Exterior",
        "description" => "A beautiful and elegant exterior welcoming you to the Veloure experience.",
        "price" => 686,
        "rating" => "4.8"
    ],

    [
        "image" => "chef-preparing-food.jpg",
        "title" => "Chef Preparing Food",
        "description" => "Fresh ingredients and expert cooking come together in our kitchen.",
        "price" => 399,
        "rating" => "4.9"
    ],

    [
        "image" => "chocolate-lava-cake.jpg",
        "title" => "Chocolate Lava Cake",
        "description" => "Rich chocolate cake with a warm and delicious molten center.",
        "price" => 299,
        "rating" => "5.0"
    ],

    [
        "image" => "coffee-counter.jpg",
        "title" => "Coffee Counter",
        "description" => "Our stylish coffee counter serves premium freshly prepared beverages.",
        "price" => 199,
        "rating" => "4.8"
    ],

    [
        "image" => "couple-table.jpg",
        "title" => "Couple Table",
        "description" => "A romantic and private table setup for unforgettable moments.",
        "price" => 999,
        "rating" => "4.9"
    ],

    [
        "image" => "cozy-seating.jpg",
        "title" => "Cozy Seating",
        "description" => "Relax in our comfortable seating area with a warm café atmosphere.",
        "price" => 865,
        "rating" => "4.8"
    ],

    [
        "image" => "dessert-presentation.jpg",
        "title" => "Dessert Presentation",
        "description" => "Beautifully presented desserts made to delight your eyes and taste buds.",
        "price" => 349,
        "rating" => "4.9"
    ],

    [
        "image" => "evening-ambience.jpg",
        "title" => "Evening Ambience",
        "description" => "Enjoy a peaceful and elegant evening surrounded by beautiful ambience.",
        "price" => 458,
        "rating" => "4.9"
    ],

    [
        "image" => "hazelnut-latte.jpg",
        "title" => "Hazelnut Latte",
        "description" => "Smooth espresso blended with creamy milk and delicious hazelnut flavour.",
        "price" => 279,
        "rating" => "4.9"
    ],

    [
        "image" => "luxury-exterior.jpg",
        "title" => "Luxury Exterior",
        "description" => "Experience the premium and sophisticated exterior of Veloure Café.",
        "price" => 963,
        "rating" => "4.8"
    ],

    [
        "image" => "pasta-alfredo.jpg",
        "title" => "Pasta Alfredo",
        "description" => "Creamy Alfredo pasta prepared with premium ingredients and rich flavours.",
        "price" => 449,
        "rating" => "4.9"
    ],

    [
        "image" => "premium-cafe-corner.jpg",
        "title" => "Premium Café Corner",
        "description" => "A luxurious corner designed for relaxing conversations and memorable moments.",
        "price" => 849,
        "rating" => "4.8"
    ],

    [
        "image" => "royal-chocolate-frappe.jpg",
        "title" => "Royal Chocolate Frappe",
        "description" => "A rich chocolate frappe topped with creamy chocolate goodness.",
        "price" => 329,
        "rating" => "5.0"
    ],

    [
        "image" => "veloure-signature-coffee.jpg",
        "title" => "Veloure Signature Coffee",
        "description" => "Our signature coffee crafted specially for the unique Veloure experience.",
        "price" => 299,
        "rating" => "5.0"
    ]

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

<title>Veloure | Gallery</title>

<link
    rel="preconnect"
    href="https://fonts.googleapis.com"
>

<link
    href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=DM+Sans:wght@400;500;600&display=swap"
    rel="stylesheet"
>

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
    font-family:"DM Sans",sans-serif;
    background:#f6f1e8;
    color:#35251d;
    overflow-x:hidden;
}


/* ==========================================
   NAVBAR
========================================== */

nav{
    position:fixed;
    top:0;
    left:0;
    width:100%;
    padding:18px 7%;
    display:flex;
    align-items:center;
    justify-content:space-between;
    background:rgba(246,241,232,.96);
    backdrop-filter:blur(15px);
    box-shadow:0 5px 25px rgba(50,30,20,.08);
    z-index:1000;
}

.logo{
    font-family:"Cormorant Garamond",serif;
    font-size:34px;
    font-weight:700;
    letter-spacing:5px;
    color:#a47b4c;
}

nav ul{
    display:flex;
    gap:25px;
    list-style:none;
}

nav ul li a{
    text-decoration:none;
    color:#35251d;
    font-size:14px;
    font-weight:600;
    transition:.3s;
}

nav ul li a:hover{
    color:#a47b4c;
}


/* ==========================================
   HERO
========================================== */

.hero{
    min-height:65vh;
    padding:150px 20px 80px;
    display:flex;
    align-items:center;
    justify-content:center;
    text-align:center;

    background:
    linear-gradient(
        rgba(35,22,15,.55),
        rgba(35,22,15,.75)
    ),
    url("images/cafe-exterior.jpg")
    center/cover no-repeat;
}

.hero-content{
    max-width:800px;
    animation:heroReveal 1.2s ease;
}

.hero-small{
    color:#e7c58f;
    letter-spacing:6px;
    font-size:13px;
    font-weight:600;
}

.hero h1{
    color:white;
    font-family:"Cormorant Garamond",serif;
    font-size:clamp(55px,8vw,100px);
    line-height:1;
    margin:18px 0;
}

.hero p{
    color:#eee;
    max-width:650px;
    margin:auto;
    line-height:1.8;
    font-size:16px;
}


/* ==========================================
   GALLERY
========================================== */

.gallery-section{
    padding:100px 7%;
}

.section-heading{
    text-align:center;
    margin-bottom:60px;
}

.section-heading span{
    color:#a47b4c;
    font-size:13px;
    letter-spacing:5px;
    font-weight:600;
}

.section-heading h2{
    font-family:"Cormorant Garamond",serif;
    font-size:58px;
    margin:10px 0;
}

.section-heading p{
    color:#806f61;
    max-width:650px;
    margin:auto;
    line-height:1.7;
}


/* ==========================================
   GRID
========================================== */

.gallery-grid{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:30px;
}


/* ==========================================
   CARD
========================================== */

.gallery-card{
    background:#fff;
    border-radius:22px;
    overflow:hidden;
    box-shadow:0 15px 45px rgba(50,30,20,.10);
    transition:.5s;
    opacity:0;
    transform:translateY(50px);
}

.gallery-card.show{
    opacity:1;
    transform:translateY(0);
}

.gallery-card:hover{
    transform:translateY(-12px);
    box-shadow:0 25px 60px rgba(50,30,20,.18);
}


/* ==========================================
   IMAGE
========================================== */

.image-box{
    height:270px;
    overflow:hidden;
    position:relative;
}

.image-box img{
    width:100%;
    height:100%;
    object-fit:cover;
    display:block;
    transition:.7s;
}

.gallery-card:hover .image-box img{
    transform:scale(1.1);
}

.image-overlay{
    position:absolute;
    inset:0;

    background:
    linear-gradient(
        transparent 45%,
        rgba(0,0,0,.65)
    );

    opacity:0;
    transition:.4s;
}

.gallery-card:hover .image-overlay{
    opacity:1;
}


/* ==========================================
   CONTENT
========================================== */

.card-content{
    padding:25px;
}

.card-content h3{
    font-family:"Cormorant Garamond",serif;
    font-size:30px;
    margin-bottom:10px;
}

.card-content p{
    color:#806f61;
    font-size:14px;
    line-height:1.7;
    min-height:70px;
}


/* ==========================================
   PRICE + RATING
========================================== */

.card-info{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-top:18px;
    padding-top:16px;
    border-top:1px solid #eee3d6;
}

.price{
    color:#a47b4c;
    font-size:23px;
    font-weight:700;
}

.rating{
    color:#c38b36;
    font-weight:600;
    font-size:14px;
}


/* ==========================================
   BUTTON
========================================== */

.reserve-btn{
    display:block;
    width:100%;
    margin-top:20px;
    padding:13px;
    text-align:center;
    border-radius:10px;
    background:#35251d;
    color:white;
    text-decoration:none;
    font-weight:600;
    transition:.35s;
}

.reserve-btn:hover{
    background:#a47b4c;
    transform:translateY(-3px);
}


/* ==========================================
   CTA
========================================== */

.gallery-cta{
    margin-top:80px;
    padding:70px 30px;
    text-align:center;
    border-radius:25px;

    background:
    linear-gradient(
        rgba(50,30,20,.7),
        rgba(50,30,20,.8)
    ),
    url("images/evening-ambience.jpg")
    center/cover;

    color:white;
}

.gallery-cta h2{
    font-family:"Cormorant Garamond",serif;
    font-size:50px;
    margin-bottom:15px;
}

.gallery-cta p{
    color:#eee;
    margin-bottom:25px;
}

.cta-btn{
    display:inline-block;
    padding:14px 35px;
    border-radius:30px;
    background:#d6b477;
    color:#35251d;
    text-decoration:none;
    font-weight:700;
    transition:.3s;
}

.cta-btn:hover{
    transform:scale(1.08);
}


/* ==========================================
   FOOTER
========================================== */

footer{
    margin-top:80px;
    padding:40px 20px;
    text-align:center;
    background:#35251d;
    color:#cdbfaf;
}

footer strong{
    color:#d6b477;
}


/* ==========================================
   ANIMATION
========================================== */

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


/* ==========================================
   RESPONSIVE
========================================== */

@media(max-width:1000px){

    .gallery-grid{
        grid-template-columns:repeat(2,1fr);
    }

}

@media(max-width:700px){

    nav{
        padding:15px 5%;
    }

    .logo{
        font-size:27px;
    }

    nav ul{
        display:none;
    }

    .gallery-section{
        padding:70px 5%;
    }

    .gallery-grid{
        grid-template-columns:1fr;
    }

    .section-heading h2{
        font-size:45px;
    }

    .gallery-cta h2{
        font-size:40px;
    }

}


/* ==========================================
   REDUCED MOTION
========================================== */

@media(prefers-reduced-motion:reduce){

    *{
        animation:none !important;
        transition:none !important;
    }

}

```php
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

        <li><a href="index.php">Home</a></li>

        <li><a href="about.php">About</a></li>

        <li><a href="menu.php">Menu</a></li>

        <li><a href="offers.php">Offers</a></li>

        <li><a href="gallery.php">Gallery</a></li>

        <li><a href="services.php">Services</a></li>

        <li><a href="reservation.php">Reservation</a></li>

        <li><a href="reviews.php">Reviews</a></li>

    </ul>

</nav>


<!-- ==========================================
     HERO
========================================== -->

<section class="hero">

    <div class="hero-content">

        <span class="hero-small">
            A VISUAL JOURNEY
        </span>

        <h1>
            Veloure Gallery
        </h1>

        <p>
            Explore the flavours, spaces, people and
            unforgettable moments that make Veloure Café special.
        </p>

    </div>

</section>


<!-- ==========================================
     GALLERY SECTION
========================================== -->

<section class="gallery-section">

    <div class="section-heading">

        <span>
            OUR EXPERIENCE
        </span>

        <h2>
            Moments at Veloure
        </h2>

        <p>
            Discover our premium coffee, delicious food,
            elegant interiors and beautiful café experiences.
        </p>

    </div>


    <div class="gallery-grid">

        <?php foreach($gallery as $item): ?>

        <article class="gallery-card">

            <div class="image-box">

                <img
                    src="images/<?php echo htmlspecialchars($item["image"]); ?>"
                    alt="<?php echo htmlspecialchars($item["title"]); ?>"
                    loading="lazy"
                >

                <div class="image-overlay"></div>

            </div>


            <div class="card-content">

                <h3>
                    <?php
                    echo htmlspecialchars($item["title"]);
                    ?>
                </h3>


                <p>
                    <?php
                    echo htmlspecialchars($item["description"]);
                    ?>
                </p>


                <div class="card-info">

                    <span class="price">
                        ₹<?php
                        echo number_format($item["price"]);
                        ?>
                    </span>

                    <span class="rating">
                        ★ <?php
                        echo htmlspecialchars($item["rating"]);
                        ?>
                    </span>

                </div>


                <!-- ======================================
                     GALLERY RESERVATION
                     CURRENT ITEM + CURRENT PRICE
                ======================================= -->

                <a
                    href="reservation.php"
                    class="reserve-btn gallery-reserve-btn"
                    data-name="<?php echo htmlspecialchars($item["title"], ENT_QUOTES); ?>"
                    data-price="<?php echo (int)$item["price"]; ?>"
                >
                    Reserve This Experience
                </a>

            </div>

        </article>

        <?php endforeach; ?>

    </div>


    <!-- ==========================================
         CTA
    ========================================== -->

    <div class="gallery-cta">

        <h2>
            Experience Veloure Yourself
        </h2>

        <p>
            Come for the coffee. Stay for the experience.
        </p>

        <a
            href="reservation.php"
            class="cta-btn"
        >
            Reserve Your Table
        </a>

    </div>

</section>


<!-- ==========================================
     FOOTER
========================================== -->

<footer>

    © 2026
    <strong>VELOURE</strong>
    — Crafted for unforgettable moments.

</footer>


<!-- ==========================================
     JAVASCRIPT
========================================== -->

<script>

document.addEventListener(
    "DOMContentLoaded",
    function(){

        const cards =
            document.querySelectorAll(
                ".gallery-card"
            );


        /* ======================================
           CARD REVEAL
        ====================================== */

        const observer =
            new IntersectionObserver(
                function(entries){

                    entries.forEach(
                        function(entry,index){

                            if(
                                entry.isIntersecting
                            ){

                                setTimeout(
                                    function(){

                                        entry.target
                                            .classList
                                            .add("show");

                                    },
                                    index * 100
                                );

                                observer.unobserve(
                                    entry.target
                                );

                            }

                        }
                    );

                },
                {
                    threshold:0.12
                }
            );


        cards.forEach(
            function(card){

                observer.observe(card);

            }
        );


        /* ======================================
           GALLERY RESERVATION
           
           IMPORTANT:
           Only the clicked gallery item
           will be saved.
           
           Old menu/gallery reservation
           will be replaced.
        ====================================== */

        document
            .querySelectorAll(
                ".gallery-reserve-btn"
            )
            .forEach(
                function(button){

                    button.addEventListener(
                        "click",
                        function(event){

                            event.preventDefault();


                            /* Get CURRENT item */

                            const name =
                                this.getAttribute(
                                    "data-name"
                                );


                            /* Get CURRENT price */

                            const price =
                                parseFloat(
                                    this.getAttribute(
                                        "data-price"
                                    )
                                );


                            /* Validate */

                            if(
                                !name ||
                                isNaN(price) ||
                                price <= 0
                            ){

                                alert(
                                    "Please select a valid gallery item."
                                );

                                return;

                            }


                            /* ==================================
                               CLEAR OLD RESERVATION
                            ================================== */

                            let selectedReservation = [

                                {
                                    name: name,
                                    price: price,
                                    quantity: 1
                                }

                            ];


                            /* ==================================
                               SAVE CURRENT ITEM ONLY
                            ================================== */

                            localStorage.setItem(
                                "veloureReservations",
                                JSON.stringify(
                                    selectedReservation
                                )
                            );


                            /* ==================================
                               ALSO SAVE GALLERY DETAILS
                            ================================== */

                            localStorage.setItem(
                                "veloureGalleryReservation",
                                JSON.stringify({

                                    name: name,

                                    price: price,

                                    quantity: 1,

                                    source: "Gallery"

                                })
                            );


                            /* ==================================
                               OPEN RESERVATION PAGE
                            ================================== */

                            window.location.href =
                                "reservation.php";

                        }
                    );

                }
            );


        /* ======================================
           BUTTON ANIMATION
        ====================================== */

        document
            .querySelectorAll(
                ".reserve-btn,.cta-btn"
            )
            .forEach(
                function(button){

                    button.addEventListener(
                        "click",
                        function(){

                            this.style.transform =
                                "scale(.96)";

                            setTimeout(
                                function(){

                                    button.style.transform =
                                        "";

                                },
                                150
                            );

                        }
                    );

                }
            );

    }
);

</script>


</body>

</html>
```

