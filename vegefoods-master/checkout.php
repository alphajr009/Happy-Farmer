<?php
@include 'config.php';
include 'nav.php';

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    $query = "SELECT * FROM users WHERE user_id = '$userId'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $userDetails = mysqli_fetch_assoc($result);
    }

    $cartQuery = "SELECT * FROM cart WHERE userid = '$userId'";
    $cartResult = mysqli_query($conn, $cartQuery);

    $subtotal = 0; 

    if ($cartResult) {
        while ($cartItem = mysqli_fetch_assoc($cartResult)) {
            $quantity = $cartItem['quantity'];
            $newPrice = $cartItem['newprice'];

            $itemSubtotal = $quantity * $newPrice;

            $subtotal += $itemSubtotal;
        }
    }
    $deliveryCharge = 400;
    $total = $subtotal + $deliveryCharge;
}

?>

<div class="hero-wrap hero-bread" style="background-image: url('images/bg_1.jpg');">
    <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home</a></span> <span>Checkout</span></p>
                <h1 class="mb-0 bread">Checkout</h1>
            </div>
        </div>
    </div>
</div>

<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-7 ftco-animate">
                <form action="#" class="billing-form">
                    <h3 class="mb-4 billing-heading">Billing Details</h3>
                    <div class="row align-items-end">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control"
                                    value=" <?php echo isset($userDetails['name']) ? $userDetails['name'] : ''; ?>">
                            </div>
                        </div>
                        <div class="w-100"></div>

                        <div class="w-100"></div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="adddressline">Address Line</label>
                                <input type="text" class="form-control"
                                    value="<?php echo isset($userDetails['address']) ? $userDetails['address'] : ''; ?>">
                            </div>
                        </div>
                        <div class="w-100"></div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="province">Province</label>
                                <input type="text" class="form-control"
                                    value="<?php echo isset($userDetails['province']) ? $userDetails['province'] : ''; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="postcodezip">Postcode / ZIP </label>
                                <input type="text" class="form-control"
                                    value="<?php echo isset($userDetails['postcode']) ? $userDetails['postcode'] : ''; ?>">
                            </div>
                        </div>
                        <div class="w-100"></div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="text" class="form-control"
                                    value="<?php echo isset($userDetails['mobile']) ? $userDetails['mobile'] : ''; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="emailaddress">Email Address</label>
                                <input type="text" class="form-control"
                                    value="<?php echo isset($userDetails['email']) ? $userDetails['email'] : ''; ?>">
                            </div>
                        </div>
                        <div class="w-100"></div>

                    </div>
                </form>
            </div>
            <div class="col-xl-5">
                <div class="row mt-5 pt-3">
                    <div class="col-md-12 d-flex mb-5">
                        <div class="cart-detail cart-total p-3 p-md-4">
                            <h3 class="billing-heading mb-4">Cart Total</h3>
                            <p class="d-flex">
                                <span>Subtotal</span>
                                <span>Rs. <?php echo number_format($subtotal, 2); ?></span>
                            </p>
                            <p class="d-flex">
                                <span>Delivery</span>
                                <span>Rs. 400.00</span>
                            </p>
                            <hr>
                            <p class="d-flex total-price">
                                <span>Total</span>
                                <span>Rs. <?php echo number_format($total, 2); ?></span>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="cart-detail p-3 p-md-4">
                            <h3 class="billing-heading mb-4">Payment Method</h3>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="radio">
                                        <label><input type="radio" name="optradio" id="cashOnDelivery" class="mr-2">
                                            Cash on Delivery</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="radio">
                                        <label><input type="radio" name="optradio" id="cardPayment" class="mr-2"
                                                checked> Card Payment</label>
                                    </div>
                                </div>
                            </div>

                            <p><a href="#" class="btn btn-primary py-3 px-4" id="placeOrderBtn">Place an order</a></p>

                            <script>
                            document.getElementById('placeOrderBtn').addEventListener('click', function() {
                                var cashOnDelivery = document.getElementById('cashOnDelivery');
                                var cardPayment = document.getElementById('cardPayment');

                                if (cashOnDelivery.checked) {
                                    window.location.href = 'orderplace.php';
                                } else if (cardPayment.checked) {
                                    window.location.href = 'stripepayportal.php';
                                }
                            });
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>