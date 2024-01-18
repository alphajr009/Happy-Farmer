<?php include 'dashboard_top.php'; ?>

<?php
// Include the database connection
include('config.php');

// Fetch data based on the selected time period
$timePeriod = isset($_GET['time_period']) ? $_GET['time_period'] : 'daily';

if ($timePeriod == 'daily') {
    $query = "SELECT DATE_FORMAT(order_date, '%Y-%m-%d') AS date, SUM(total_amount) AS total_amount 
              FROM order_details 
              GROUP BY DATE_FORMAT(order_date, '%Y-%m-%d')";
}else {
    $query = "SELECT DATE_FORMAT(order_date, '%Y-%m') AS date, SUM(total_amount) AS total_amount 
              FROM order_details 
              GROUP BY DATE_FORMAT(order_date, '%Y-%m')";
}

$result = mysqli_query($conn, $query);

// Fetch data into an associative array
$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}


?>

<?php
$sql = "SELECT COUNT(*) AS customer_count FROM users WHERE isAdmin = 0";
$result = $conn->query($sql);

if ($result) {
    $row = $result->fetch_assoc();
    $customerCount = $row['customer_count'];
} else {
    echo "Error: " . $conn->error;
}


$sql2 = "SELECT COUNT(*) AS order_count FROM order_details" ;
$result2 = $conn->query($sql2);

if ($result2) {
    $row1 = $result2->fetch_assoc();
    $orderCount = $row1['order_count'];
} else {
    echo "Error: " . $conn->error;
}


$conn->close();
?>

<body>
    <!-- =============== Navigation ================ -->
    <div class="container">
        <div class="navigation">
            <ul>
                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="logo-apple"></ion-icon>
                        </span>
                        <span class="title">Brand Name</span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="home-outline"></ion-icon>
                        </span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="user_mange.php">
                        <span class="icon">
                            <ion-icon name="people-outline"></ion-icon>
                        </span>
                        <span class="title">Customers</span>
                    </a>
                </li>

                <li>
                    <a href="news_add.php">
                        <span class="icon">
                            <ion-icon name="chatbubble-outline"></ion-icon>
                        </span>
                        <span class="title">News</span>
                    </a>
                </li>

                <li>
                    <a href="product_add.php">
                        <span class="icon">
                            <ion-icon name="help-outline"></ion-icon>
                        </span>
                        <span class="title">product</span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="settings-outline"></ion-icon>
                        </span>
                        <span class="title">Settings</span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="lock-closed-outline"></ion-icon>
                        </span>
                        <span class="title">Password</span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="log-out-outline"></ion-icon>
                        </span>
                        <span class="title">Sign Out</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- ========================= Main ==================== -->
        <div class="main">
            <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>

                <div class="search">
                    <label>
                        <input type="text" placeholder="Search here">
                        <ion-icon name="search-outline"></ion-icon>
                    </label>
                </div>

                <div class="user">
                    <img src="assets/imgs/customer01.jpg" alt="">
                </div>
            </div>

            <!-- ======================= Cards ================== -->



            <div class="cardBox">
                <div class="card">
                    <div>
                        <div class="numbers"><?= $customerCount ?></div>
                        <div class="cardName">Customers</div>
                    </div>

                    <div class="iconBx">
                        <ion-icon name="eye-outline"></ion-icon>
                    </div>
                </div>

                <div class="card">
                    <div>
                        <div class="numbers"><?= $orderCount ?></div>
                        <div class="cardName">Sales</div>
                    </div>

                    <div class="iconBx">
                        <ion-icon name="cart-outline"></ion-icon>
                    </div>
                </div>

                <div class="card">
                    <div>
                        <div class="numbers">0</div>
                        <div class="cardName">Comments</div>
                    </div>

                    <div class="iconBx">
                        <ion-icon name="chatbubbles-outline"></ion-icon>
                    </div>
                </div>

                <div class="card">
                    <div>
                        <div class="numbers"></div>
                        <div class="cardName">Earning</div>
                    </div>

                    <div class="iconBx">
                        <ion-icon name="cash-outline"></ion-icon>
                    </div>
                </div>
            </div>

            <div class="chart">
                <!-- Create buttons for time period selection -->
                <button class="time-period-btn <?php echo ($timePeriod == 'daily') ? 'active' : ''; ?>"
                    onclick="changeTimePeriod('daily')">Daily</button>

                <button class="time-period-btn <?php echo ($timePeriod == 'monthly') ? 'active' : ''; ?>"
                    onclick="changeTimePeriod('monthly')">Monthly</button>

                <canvas id="orderChart" width="400" height="200"></canvas>

                <script>
                var orderDates = <?php echo json_encode(array_column($data, 'date')); ?>;
                var totalAmounts = <?php echo json_encode(array_column($data, 'total_amount')); ?>;

                var ctx = document.getElementById('orderChart').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: orderDates,
                        datasets: [{
                            label: 'Total Amount',
                            data: totalAmounts,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });

                // Function to change time period and reload the page
                function changeTimePeriod(period) {
                    window.location.href = 'dashboard.php?time_period=' + period;
                }
                </script>
            </div>




            <!-- =========== Scripts =========  -->
            <script src="assets/js/main.js"></script>

            <!-- ====== ionicons ======= -->
            <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
            <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>