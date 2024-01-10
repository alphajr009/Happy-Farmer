<?php
@include 'config.php';
include 'nav.php';

if(isset($_SESSION['user_id'])) {
    $userid = $_SESSION['user_id'];

	$cartQuery = "SELECT cart.*, products.name AS product_name, products.image, cart.newprice
	FROM cart
	INNER JOIN products ON cart.itemid = products.id
	WHERE cart.userid = $userid";
$cartResult = mysqli_query($conn, $cartQuery);


    if ($cartResult) {
?>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<div class="hero-wrap hero-bread" style="background-image: url('images/bg_1.jpg');">
    <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home</a></span> <span>Cart</span></p>
                <h1 class="mb-0 bread">My Cart</h1>
            </div>
        </div>
    </div>
</div>

<section class="ftco-section ftco-cart">
    <div class="container">
        <div class="row">
            <div class="col-md-12 ftco-animate">
                <div class="cart-list">
                    <table class="table">
                        <thead class="thead-primary">
                            <tr class="text-center">
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                                <th>Product name</th>
                                <th>Price</th>
                                <th>Size</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                while ($cartItem = mysqli_fetch_assoc($cartResult)) {
                            ?>
                            <tr class="text-center">
                                <td class="product-remove"><a href="#"><span class="ion-ios-close"></span></a></td>

                                <td class="image-prod">
                                    <div class="img"
                                        style="background-image: url('images/<?php echo $cartItem['image']; ?>');">
                                    </div>
                                </td>

                                <td class="product-name">
                                    <h3><?php echo $cartItem['product_name']; ?></h3>
                                </td>

                                <td class="price">Rs.<?php echo $cartItem['newprice']; ?></td>

                                <td class="price"><?php echo $cartItem['size']; ?>kg</td>

                                <td class="quantity">
                                    <div class="input-group mb-3">
                                        <input type="text" name="quantity" class="quantity form-control input-number"
                                            value="<?php echo $cartItem['quantity']; ?>" min="1" max="100"
                                            data-itemid="<?php echo $cartItem['itemid']; ?>">
                                    </div>
                                </td>

                                <td class="total total-value">
                                    Rs.<?php echo $cartItem['newprice'] * $cartItem['quantity']; ?></td>

                            </tr>
                            <?php
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row justify-content-end">
            <div class="col-lg-12 mt-5 cart-wrap ftco-animate">
                <div class="cart-total mb-3">
                    <h3>Cart Totals</h3>
                    <p class="d-flex">
                        <span id="subtotal-label">Subtotal</span>
                        <span id="subtotal-value">Rs.0.00</span>
                    </p>
                    <p class="d-flex">
                        <span id="delivery-label">Delivery</span>
                        <span id="delivery-value">Rs.400</span>
                    </p>
                    <hr>
                    <p class="d-flex total-price">
                        <span id="total-label">Total</span>
                        <span id="total-value">Rs.400.00</span>
                    </p>

                </div>
                <p><a href="checkout.php" class="btn btn-primary py-3 px-4">Proceed to Checkout</a></p>
            </div>
        </div>
    </div>
</section>

<script>
$(document).ready(function() {
    function updateSubtotal() {
        var subtotal = 0;
        $('.total-value').each(function() {
            subtotal += parseFloat($(this).text().replace('Rs.', ''));
        });
        $('#subtotal-value').text('Rs.' + subtotal);

        var deliveryCharge = 400;
        var total = subtotal + deliveryCharge;
        $('#total-value').text('Rs.' + total);
    }

    updateSubtotal();

    $('.quantity').on('input', function() {
        var quantity = $(this).val();
        var itemid = $(this).data('itemid');

        $.ajax({
            type: 'POST',
            url: 'updatecart.php',
            data: {
                itemid: itemid,
                quantity: quantity
            },
            success: function(response) {
                try {
                    var responseData = JSON.parse(response);

                    if (responseData.total !== undefined) {
                        var totalColumn = $('[data-itemid="' + itemid + '"]').closest('tr')
                            .find('.total-value');
                        totalColumn.text('Rs.' + responseData.total);

                        updateSubtotal();
                    }

                    console.log(responseData.message);
                } catch (error) {
                    console.log('Error parsing JSON response: ' + error);
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
    });
});
</script>

<?php
    } else {
        echo "Error retrieving cart items: " . mysqli_error($conn);
    }
} else {
    echo "User not logged in!";
}
include 'footer.php';
?>