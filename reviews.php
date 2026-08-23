
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Veloure | Customer Reviews</title>

    <link rel="stylesheet" href="css/style.css">
    <script src="js/script"></script>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Poppins, sans-serif;
        }

        body {
            background: #090909;
            color: white;
        }


        /* =========================
           NAVBAR
        ========================= */

        nav {
            padding: 20px 8%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #080808;
        }

        .logo {
            font-size: 30px;
            font-weight: bold;
            letter-spacing: 4px;
            color: #d6a85f;
        }

        nav ul {
            display: flex;
            gap: 25px;
            list-style: none;
        }

        nav a {
            color: white;
            text-decoration: none;
        }

        nav a:hover {
            color: #d6a85f;
        }


        /* =========================
           HERO
        ========================= */

        .hero {
            padding: 100px 20px;
            text-align: center;

            background:
                linear-gradient(
                    rgba(0,0,0,.6),
                    rgba(0,0,0,.8)
                ),
                url("images/reviews-bg.jpg")
                center/cover;
        }

        .hero span {
            color: #d6a85f;
            letter-spacing: 4px;
        }

        .hero h1 {
            font-family: Georgia, serif;
            font-size: 65px;
            margin: 15px 0;
        }

        .hero p {
            color: #ccc;
        }


        /* =========================
           REVIEWS
        ========================= */

        .reviews {
            padding: 90px 8%;
        }

        .title {
            text-align: center;
            margin-bottom: 55px;
        }

        .title span {
            color: #d6a85f;
            letter-spacing: 4px;
        }

        .title h2 {
            font-family: Georgia, serif;
            font-size: 42px;
            margin-top: 12px;
        }


        /* =========================
           REVIEW CONTAINER
        ========================= */

        .review-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }


        /* =========================
           REVIEW CARD
        ========================= */

        .review-card {
            padding: 35px;
            background: #151515;
            border: 1px solid #292929;
            border-radius: 20px;
            transition: .4s;
        }

        .review-card:hover {
            transform: translateY(-10px);
            border-color: #d6a85f;
        }


        /* =========================
           STARS
        ========================= */

        .stars {
            color: #d6a85f;
            font-size: 22px;
            margin-bottom: 20px;
        }


        /* =========================
           REVIEW TEXT
        ========================= */

        .review-card p {
            color: #bbb;
            line-height: 1.8;
            margin-bottom: 25px;
        }


        /* =========================
           CUSTOMER
        ========================= */

        .customer {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .customer-img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: #d6a85f;

            display: flex;
            justify-content: center;
            align-items: center;

            color: #111;
            font-weight: bold;
        }

        .customer h3 {
            font-size: 17px;
        }

        .customer small {
            color: #888;
        }


        /* =========================
           FOOTER
        ========================= */

        footer {
            text-align: center;
            padding: 35px;
            background: #050505;
            color: #777;
        }

        footer strong {
            color: #d6a85f;
        }


        /* =========================
           TABLET
        ========================= */

        @media(max-width: 850px) {

            .review-container {
                grid-template-columns: 1fr 1fr;
            }

            nav ul {
                display: none;
            }

        }


        /* =========================
           MOBILE
        ========================= */

        @media(max-width: 600px) {

            .review-container {
                grid-template-columns: 1fr;
            }

            .hero h1 {
                font-size: 45px;
            }

        }

    </style>

</head>


<body>


    <!-- =========================
         NAVBAR
    ========================= -->

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
                <a href="offers.php">
                    Offers
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



    <!-- =========================
         HERO
    ========================= -->

    <section class="hero">

        <span>
            WHAT OUR GUESTS SAY
        </span>

        <h1>
            Customer Reviews
        </h1>

        <p>
            Real experiences from people who visited Veloure.
        </p>

    </section>



    <!-- =========================
         REVIEWS
    ========================= -->

    <section class="reviews">


        <div class="title">

            <span>
                HAPPY CUSTOMERS
            </span>

            <h2>
                What Our Guests Say
            </h2>

        </div>



        <div class="review-container">


            <!-- REVIEW 1 -->

            <div class="review-card">

                <div class="stars">
                    ★★★★★
                </div>

                <p>
                    "The ambience was beautiful and the food was
                    absolutely delicious. Perfect place for a relaxing
                    evening."
                </p>

                <div class="customer">

                    <div class="customer-img">
                        AS
                    </div>

                    <div>

                        <h3>
                            Ananya Sharma
                        </h3>

                        <small>
                            Verified Customer
                        </small>

                    </div>

                </div>

            </div>



            <!-- REVIEW 2 -->

            <div class="review-card">

                <div class="stars">
                    ★★★★★
                </div>

                <p>
                    "Amazing café with wonderful service. The staff
                    was friendly and the presentation of every dish
                    was excellent."
                </p>

                <div class="customer">

                    <div class="customer-img">
                        RK
                    </div>

                    <div>

                        <h3>
                            Rohan Kulkarni
                        </h3>

                        <small>
                            Verified Customer
                        </small>

                    </div>

                </div>

            </div>



            <!-- REVIEW 3 -->

            <div class="review-card">

                <div class="stars">
                    ★★★★★
                </div>

                <p>
                    "We celebrated our anniversary at Veloure and
                    everything was beautifully arranged. Highly
                    recommended!"
                </p>

                <div class="customer">

                    <div class="customer-img">
                        PM
                    </div>

                    <div>

                        <h3>
                            Priya Mehta
                        </h3>

                        <small>
                            Verified Customer
                        </small>

                    </div>

                </div>

            </div>



            <!-- REVIEW 4 -->

            <div class="review-card">

                <div class="stars">
                    ★★★★☆
                </div>

                <p>
                    "Loved the coffee and desserts. The atmosphere
                    is peaceful and perfect for spending time with
                    friends."
                </p>

                <div class="customer">

                    <div class="customer-img">
                        VN
                    </div>

                    <div>

                        <h3>
                            Vikram Nair
                        </h3>

                        <small>
                            Verified Customer
                        </small>

                    </div>

                </div>

            </div>



            <!-- REVIEW 5 -->

            <div class="review-card">

                <div class="stars">
                    ★★★★★
                </div>

                <p>
                    "One of the best café experiences I've had.
                    Beautiful interiors, tasty food and excellent
                    customer service."
                </p>

                <div class="customer">

                    <div class="customer-img">
                        SK
                    </div>

                    <div>

                        <h3>
                            Sneha Kapoor
                        </h3>

                        <small>
                            Verified Customer
                        </small>

                    </div>

                </div>

            </div>



            <!-- REVIEW 6 -->

            <div class="review-card">

                <div class="stars">
                    ★★★★★
                </div>

                <p>
                    "A perfect place for a date night. The ambience,
                    food and service were all wonderful."
                </p>

                <div class="customer">

                    <div class="customer-img">
                        AD
                    </div>

                    <div>

                        <h3>
                            Aditya Deshmukh
                        </h3>

                        <small>
                            Verified Customer
                        </small>

                    </div>

                </div>

            </div>


        </div>

    </section>



    <!-- =========================
         FOOTER
    ========================= -->

    <footer>

        © 2026

        <strong>
            VELOURE
        </strong>

        — Crafted for unforgettable moments.

    </footer>


</body>
</html>