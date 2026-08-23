<?php

// ==========================================
// VELOURE CAFE - ADMIN DASHBOARD
// ==========================================

$ordersFile = __DIR__ . "/order.csv";
$reservationsFile = __DIR__ . "/reservation.csv";


// ==========================================
// READ CSV FUNCTION
// ==========================================

function readCSV($file)
{
    $data = [];

    if (!file_exists($file) || filesize($file) == 0) {
        return $data;
    }

    $handle = fopen($file, "r");

    if ($handle === false) {
        return $data;
    }

    $headers = fgetcsv($handle);

    if ($headers === false) {
        fclose($handle);
        return $data;
    }

    // Remove BOM
    if (isset($headers[0])) {
        $headers[0] = preg_replace('/^\xEF\xBB\xBF/', '', $headers[0]);
    }

    while (($row = fgetcsv($handle)) !== false) {

        if (count(array_filter($row)) == 0) {
            continue;
        }

        $row = array_pad($row, count($headers), "");

        $data[] = array_combine(
            $headers,
            array_slice($row, 0, count($headers))
        );
    }

    fclose($handle);

    return $data;
}


// ==========================================
// LOAD DATA
// ==========================================

$orders = readCSV($ordersFile);
$reservations = readCSV($reservationsFile);


// ==========================================
// STATISTICS
// ==========================================

$totalOrders = count($orders);
$totalReservations = count($reservations);

$totalSales = 0;

$pendingOrders = 0;
$confirmedOrders = 0;
$completedOrders = 0;

$totalPaidReservations = 0;
$totalPendingPayments = 0;


// ==========================================
// ORDER STATISTICS
// ==========================================

foreach ($orders as $order) {

    $price = 0;

    $possiblePriceFields = [
        "Final Price",
        "Total Price",
        "Price",
        "Amount",
        "Total"
    ];

    foreach ($possiblePriceFields as $field) {

        if (isset($order[$field]) && $order[$field] !== "") {

            $price = preg_replace(
                "/[^0-9.]/",
                "",
                $order[$field]
            );

            break;
        }
    }

    $totalSales += (float)$price;


    $status = strtolower(
        trim($order["Status"] ?? "pending")
    );

    if ($status === "pending") {
        $pendingOrders++;
    }

    elseif ($status === "confirmed") {
        $confirmedOrders++;
    }

    elseif ($status === "completed") {
        $completedOrders++;
    }
}


// ==========================================
// RESERVATION PAYMENT STATISTICS
// ==========================================

foreach ($reservations as $reservation) {

    $paymentStatus = strtolower(
        trim($reservation["Payment Status"] ?? "pending")
    );

    if ($paymentStatus === "paid") {
        $totalPaidReservations++;
    }

    else {
        $totalPendingPayments++;
    }
}

?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>VELOURE Café | Admin Dashboard</title>


<link rel="preconnect"
      href="https://fonts.googleapis.com">

<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=DM+Sans:wght@400;500;600;700&display=swap"
      rel="stylesheet">


<style>

/* ==========================================
   RESET
========================================== */

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

html {
    scroll-behavior: smooth;
}

body {
    font-family: "DM Sans", sans-serif;
    background: #f6f1e8;
    color: #35251d;
}


/* ==========================================
   SIDEBAR
========================================== */

.sidebar {

    position: fixed;

    left: 0;
    top: 0;

    width: 250px;
    height: 100vh;

    background: #2b1d17;

    color: white;

    padding: 30px 20px;

    z-index: 1000;
}

.logo {

    text-align: center;

    margin-bottom: 45px;
}

.logo h1 {

    font-family: "Cormorant Garamond", serif;

    font-size: 36px;

    letter-spacing: 3px;

    color: #ffffff;
}

.logo span {

    display: block;

    color: #c9a878;

    font-size: 9px;

    letter-spacing: 3px;
}


/* ==========================================
   NAVIGATION
========================================== */

.nav {

    list-style: none;
}

.nav li {

    margin: 10px 0;
}

.nav a {

    display: flex;

    align-items: center;

    gap: 14px;

    padding: 14px 16px;

    color: #eee;

    text-decoration: none;

    border-radius: 12px;

    transition: 0.3s;
}

.nav a:hover,
.nav a.active {

    background: #c9a878;

    color: #2b1d17;

    transform: translateX(5px);
}


/* ==========================================
   MAIN
========================================== */

.main {

    margin-left: 250px;

    padding: 35px;
}


/* ==========================================
   HEADER
========================================== */

.header {

    display: flex;

    justify-content: space-between;

    align-items: center;

    margin-bottom: 30px;
}

.header h2 {

    font-family: "Cormorant Garamond", serif;

    font-size: 44px;
}

.header p {

    color: #806f61;

    margin-top: 4px;
}

.admin {

    background: #ffffff;

    padding: 12px 20px;

    border-radius: 30px;

    box-shadow: 0 5px 20px rgba(50,30,20,.08);

    font-weight: 600;
}


/* ==========================================
   STATISTICS
========================================== */

.stats {

    display: grid;

    grid-template-columns: repeat(4, 1fr);

    gap: 20px;

    margin-bottom: 30px;
}

.card {

    background: #ffffff;

    padding: 25px;

    border-radius: 20px;

    box-shadow: 0 10px 30px rgba(50,30,20,.08);

    transition: 0.4s;
}

.card:hover {

    transform: translateY(-8px);

    box-shadow: 0 20px 40px rgba(50,30,20,.14);
}

.icon {

    font-size: 30px;

    margin-bottom: 10px;
}

.card h3 {

    font-size: 13px;

    color: #806f61;

    font-weight: 500;
}

.number {

    font-size: 28px;

    font-weight: 700;

    margin-top: 6px;
}


/* ==========================================
   SECTION
========================================== */

.section {

    background: #ffffff;

    border-radius: 20px;

    padding: 25px;

    margin-bottom: 30px;

    box-shadow: 0 10px 30px rgba(50,30,20,.07);
}

.section-head {

    display: flex;

    justify-content: space-between;

    align-items: center;

    margin-bottom: 20px;
}

.section-head h2 {

    font-family: "Cormorant Garamond", serif;

    font-size: 32px;
}

.download {

    background: #35251d;

    color: white;

    text-decoration: none;

    padding: 11px 18px;

    border-radius: 10px;

    font-size: 13px;
}

.download:hover {

    background: #c9a878;

    color: #35251d;
}


/* ==========================================
   TABLE
========================================== */

.table-box {

    width: 100%;

    overflow-x: auto;
}

table {

    width: 100%;

    border-collapse: collapse;

    min-width: 900px;
}

th {

    background: #f6f1e8;

    padding: 14px;

    text-align: left;

    font-size: 12px;

    white-space: nowrap;
}

td {

    padding: 13px 14px;

    border-bottom: 1px solid #eee3d6;

    font-size: 12px;

    white-space: nowrap;
}

tbody tr:hover {

    background: #fffaf3;
}


/* ==========================================
   STATUS
========================================== */

.status {

    display: inline-block;

    padding: 6px 12px;

    border-radius: 20px;

    font-size: 10px;

    font-weight: 700;
}

.pending {

    background: #fff0c7;

    color: #8b6500;
}

.confirmed {

    background: #dff3e4;

    color: #25733c;
}

.completed {

    background: #e1e7ff;

    color: #4053a1;
}

.cancelled {

    background: #ffe0e0;

    color: #a52d2d;
}


/* ==========================================
   PAYMENT
========================================== */

.payment-paid {

    display: inline-block;

    padding: 6px 12px;

    border-radius: 20px;

    font-size: 10px;

    font-weight: 700;

    background: #dff3e4;

    color: #25733c;
}

.payment-pending {

    display: inline-block;

    padding: 6px 12px;

    border-radius: 20px;

    font-size: 10px;

    font-weight: 700;

    background: #fff0c7;

    color: #8b6500;
}


/* ==========================================
   EMPTY
========================================== */

.empty {

    text-align: center;

    padding: 40px;

    color: #806f61;
}

.empty-icon {

    font-size: 40px;

    margin-bottom: 10px;
}


/* ==========================================
   FOOTER
========================================== */

.footer {

    text-align: center;

    padding: 25px;

    color: #806f61;

    font-size: 12px;
}


/* ==========================================
   RESPONSIVE
========================================== */

@media(max-width:1100px) {

    .stats {

        grid-template-columns: repeat(2,1fr);
    }
}

@media(max-width:700px) {

    .sidebar {

        width: 70px;

        padding: 20px 8px;
    }

    .logo h1 {

        font-size: 18px;
    }

    .logo span {

        display: none;
    }

    .nav a {

        justify-content: center;

        padding: 14px 5px;
    }

    .nav-text {

        display: none;
    }

    .main {

        margin-left: 70px;

        padding: 20px;
    }

    .header {

        align-items: flex-start;

        gap: 10px;
    }

    .header h2 {

        font-size: 32px;
    }

    .admin {

        font-size: 11px;

        padding: 9px 12px;
    }

    .stats {

        grid-template-columns: 1fr;
    }
}

</style>

</head>


<body>


<!-- ==========================================
     SIDEBAR
========================================== -->

<aside class="sidebar">

    <div class="logo">

        <h1>VELOURE</h1>

        <span>ARTISAN CAFÉ</span>

    </div>


    <ul class="nav">

        <li>

            <a href="#dashboard" class="active">

                📊

                <span class="nav-text">
                    Dashboard
                </span>

            </a>

        </li>


        <li>

            <a href="#orders">

                📦

                <span class="nav-text">
                    Orders
                </span>

            </a>

        </li>


        <li>

            <a href="#reservations">

                📅

                <span class="nav-text">
                    Reservations
                </span>

            </a>

        </li>

    </ul>

</aside>



<!-- ==========================================
     MAIN
========================================== -->

<main class="main">


<header class="header" id="dashboard">

    <div>

        <h2>
            Admin Dashboard
        </h2>

        <p>
            Veloure Café Management System
        </p>

    </div>


    <div class="admin">
        👤 Admin
    </div>

</header>



<!-- ==========================================
     STATISTICS
========================================== -->

<div class="stats">


    <div class="card">

        <div class="icon">📦</div>

        <h3>
            Total Orders
        </h3>

        <div class="number">

            <?php echo $totalOrders; ?>

        </div>

    </div>



    <div class="card">

        <div class="icon">📅</div>

        <h3>
            Total Reservations
        </h3>

        <div class="number">

            <?php echo $totalReservations; ?>

        </div>

    </div>



    <div class="card">

        <div class="icon">💰</div>

        <h3>
            Total Sales
        </h3>

        <div class="number">

            ₹<?php echo number_format($totalSales, 2); ?>

        </div>

    </div>



    <div class="card">

        <div class="icon">💳</div>

        <h3>
            Paid Reservations
        </h3>

        <div class="number">

            <?php echo $totalPaidReservations; ?>

        </div>

    </div>


</div>



<!-- ==========================================
     ORDERS
========================================== -->

<section class="section" id="orders">


<div class="section-head">

    <h2>
        All Orders
    </h2>


    <?php if(file_exists($ordersFile)): ?>

        <a href="order.csv"
           download
           class="download">

            📥 Download Orders CSV

        </a>

    <?php endif; ?>

</div>



<?php if(count($orders) > 0): ?>


<div class="table-box">

<table>

<thead>

<tr>

<?php

$orderHeaders = array_keys($orders[0]);

foreach($orderHeaders as $header):

?>

<th>

<?php

echo htmlspecialchars($header);

?>

</th>

<?php endforeach; ?>

</tr>

</thead>



<tbody>


<?php foreach($orders as $order): ?>

<tr>


<?php foreach($orderHeaders as $header): ?>

<td>


<?php

$value = $order[$header] ?? "";


if(strtolower(trim($header)) === "status") {

    $status = strtolower(trim($value));

    $class = "pending";

    if($status === "confirmed") {
        $class = "confirmed";
    }

    elseif($status === "completed") {
        $class = "completed";
    }

    elseif($status === "cancelled") {
        $class = "cancelled";
    }

    echo '<span class="status '
        . $class .
        '">'
        . htmlspecialchars($value)
        . '</span>';

}

else {

    echo htmlspecialchars($value);

}

?>


</td>

<?php endforeach; ?>


</tr>

<?php endforeach; ?>


</tbody>

</table>

</div>


<?php else: ?>


<div class="empty">

    <div class="empty-icon">
        📦
    </div>

    <p>
        No orders available yet.
    </p>

</div>


<?php endif; ?>


</section>



<!-- ==========================================
     RESERVATIONS
========================================== -->

<section class="section" id="reservations">


<div class="section-head">

    <h2>
        All Reservations
    </h2>


    <?php if(file_exists($reservationsFile)): ?>

        <a href="reservation.csv"
           download
           class="download">

            📥 Download Reservations CSV

        </a>

    <?php endif; ?>

</div>



<?php if(count($reservations) > 0): ?>


<div class="table-box">

<table>

<thead>

<tr>

<?php

$reservationHeaders = array_keys($reservations[0]);

foreach($reservationHeaders as $header):

?>

<th>

<?php echo htmlspecialchars($header); ?>

</th>

<?php endforeach; ?>

</tr>

</thead>



<tbody>


<?php foreach($reservations as $reservation): ?>

<tr>


<?php foreach($reservationHeaders as $header): ?>

<td>


<?php

$value = $reservation[$header] ?? "";


if(strtolower(trim($header)) === "payment status") {

    $paymentStatus = trim($value);

    if($paymentStatus === "") {
        $paymentStatus = "Pending";
    }

    $paymentClass =
        strtolower($paymentStatus) === "paid"
        ? "payment-paid"
        : "payment-pending";

    echo '<span class="' .
        $paymentClass .
        '">' .
        htmlspecialchars($paymentStatus) .
        '</span>';

}


elseif(strtolower(trim($header)) === "status") {

    $status = trim($value);

    if($status === "") {
        $status = "Pending";
    }

    $statusClass =
        strtolower($status);

    if(
        $statusClass !== "confirmed" &&
        $statusClass !== "completed" &&
        $statusClass !== "cancelled"
    ) {

        $statusClass = "pending";
    }

    echo '<span class="status ' .
        $statusClass .
        '">' .
        htmlspecialchars($status) .
        '</span>';

}


else {

    echo htmlspecialchars($value);

}

?>


</td>

<?php endforeach; ?>


</tr>

<?php endforeach; ?>


</tbody>

</table>

</div>


<?php else: ?>


<div class="empty">

    <div class="empty-icon">
        📅
    </div>

    <p>
        No reservations available yet.
    </p>

</div>


<?php endif; ?>


</section>



<!-- ==========================================
     FOOTER
========================================== -->

<div class="footer">

    © 2026 VELOURE Café.
    Admin Dashboard.

</div>


</main>

</body>

</html>