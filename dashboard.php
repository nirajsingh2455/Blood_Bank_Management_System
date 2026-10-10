<?php
session_start();
include "db.php";

/* Total Donors */
$total = $conn->query("SELECT COUNT(*) AS total FROM donors")->fetch_assoc()['total'];

/* Blood Group Counts */
$groups = ['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'];

$bloodCounts = [];

foreach ($groups as $group) {
    $stmt = $conn->prepare(
        "SELECT COUNT(*) AS total FROM donors WHERE blood_group = ?"
    );

    $stmt->bind_param("s", $group);
    $stmt->execute();

    $result = $stmt->get_result()->fetch_assoc();

    $bloodCounts[$group] = $result['total'];
}

/* Emergency Requests */
$requestCount = 0;

$requestTable = $conn->query("SHOW TABLES LIKE 'emergency_requests'");

if ($requestTable && $requestTable->num_rows > 0) {
    $requestCount = $conn
        ->query("SELECT COUNT(*) AS total FROM emergency_requests")
        ->fetch_assoc()['total'];
}

/* Low Stock Groups */
$lowStock = [];

foreach ($bloodCounts as $group => $count) {
    if ($count <= 3) {
        $lowStock[] = $group;
    }
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Blood Bank Dashboard</title>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>

* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
}

body {
    background: #f4f6f9;
}

/* SIDEBAR */

.sidebar {
    position: fixed;
    width: 240px;
    height: 100vh;
    background: #172b4d;
    color: white;
    padding-top: 25px;
}

.logo {
    text-align: center;
    font-size: 22px;
    font-weight: bold;
    margin-bottom: 35px;
}

.sidebar a {
    display: block;
    color: white;
    text-decoration: none;
    padding: 15px 25px;
    margin: 4px 10px;
    border-radius: 8px;
}

.sidebar a:hover {
    background: #e63946;
}

/* MAIN */

.main {
    margin-left: 240px;
    padding: 25px;
}

.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
}

.header h1 {
    color: #172b4d;
}

.admin {
    background: white;
    padding: 10px 18px;
    border-radius: 25px;
    box-shadow: 0 2px 8px rgba(0,0,0,.08);
}

/* CARDS */

.cards {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
}

.card {
    background: white;
    padding: 25px;
    border-radius: 14px;
    box-shadow: 0 3px 12px rgba(0,0,0,.08);
}

.card h3 {
    color: #777;
    margin-bottom: 10px;
}

.number {
    font-size: 32px;
    font-weight: bold;
    color: #e63946;
}

/* INVENTORY */

.inventory {
    margin-top: 25px;
    background: white;
    padding: 25px;
    border-radius: 14px;
    box-shadow: 0 3px 12px rgba(0,0,0,.08);
}

.inventory-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 15px;
    margin-top: 20px;
}

.blood-card {
    padding: 20px;
    border-radius: 12px;
    background: #f8f9fa;
    text-align: center;
}

.blood {
    font-size: 28px;
    font-weight: bold;
    color: #e63946;
}

.status {
    margin-top: 8px;
    font-weight: bold;
}

.high {
    color: green;
}

.medium {
    color: orange;
}

.low {
    color: red;
}

/* CHART */

.chart-container {
    margin-top: 25px;
    background: white;
    padding: 25px;
    border-radius: 14px;
    max-width: 600px;
}

/* ALERT */

.alert {
    margin-top: 25px;
    background: #fff3cd;
    padding: 18px;
    border-radius: 10px;
    border-left: 5px solid #ffc107;
}

</style>

</head>

<body>

<!-- SIDEBAR -->

<div class="sidebar">

    <div class="logo">
        🩸 BloodCare
    </div>

    <a href="dashboard.php">🏠 Dashboard</a>

    <a href="add_donor.html">👤 Add Donor</a>

    <a href="view_donors.php">🩸 View Donors</a>

    <a href="emergency_request.php">🚨 Emergency Request</a>

    <a href="logout.php">🚪 Logout</a>

</div>


<!-- MAIN CONTENT -->

<div class="main">

    <div class="header">

        <h1>Blood Bank Dashboard</h1>

        <div class="admin">
            👤 Administrator
        </div>

    </div>


    <!-- STATISTICS -->

    <div class="cards">

        <div class="card">

            <h3>Total Donors</h3>

            <div class="number">
                <?php echo $total; ?>
            </div>

        </div>


        <div class="card">

            <h3>Blood Groups</h3>

            <div class="number">
                8
            </div>

        </div>


        <div class="card">

            <h3>Emergency Requests</h3>

            <div class="number">
                <?php echo $requestCount; ?>
            </div>

        </div>

    </div>


    <!-- BLOOD INVENTORY -->

    <div class="inventory">

        <h2>🩸 Blood Inventory</h2>

        <div class="inventory-grid">

            <?php foreach ($bloodCounts as $group => $count): ?>

                <div class="blood-card">

                    <div class="blood">
                        <?php echo $group; ?>
                    </div>

                    <h2>
                        <?php echo $count; ?>
                    </h2>

                    <?php

                    if ($count <= 3) {
                        echo '<div class="status low">🔴 LOW</div>';
                    }
                    elseif ($count <= 7) {
                        echo '<div class="status medium">🟡 MEDIUM</div>';
                    }
                    else {
                        echo '<div class="status high">🟢 GOOD</div>';
                    }

                    ?>

                </div>

            <?php endforeach; ?>

        </div>

    </div>


    <!-- LOW STOCK ALERT -->

    <?php if (count($lowStock) > 0): ?>

        <div class="alert">

            <strong>⚠ Low Blood Stock:</strong>

            <?php echo implode(", ", $lowStock); ?>

            blood group stock is low.

        </div>

    <?php endif; ?>


    <!-- CHART -->

    <div class="chart-container">

        <h2>Blood Group Distribution</h2>

        <canvas id="bloodChart"></canvas>

    </div>


</div>


<script>

const bloodGroups = <?php echo json_encode(array_keys($bloodCounts)); ?>;

const bloodValues = <?php echo json_encode(array_values($bloodCounts)); ?>;

new Chart(document.getElementById('bloodChart'), {

    type: 'doughnut',

    data: {

        labels: bloodGroups,

        datasets: [{

            data: bloodValues

        }]

    },

    options: {

        responsive: true,

        plugins: {

            legend: {

                position: 'bottom'

            }

        }

    }

});

</script>

</body>
</html>