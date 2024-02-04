<?php
@include 'config.php';
include 'nav.php';



if (isset($_GET['id'])) {
    $productId = $_GET['id'];


    if (isset($_GET['success']) && $_GET['success'] == 1) {
        echo '<div class="alert alert-success" style="position: fixed; top: 120px; left: 25px; z-index: 1000;">';
        echo 'Item added to cart successfully!';
        echo '</div>';
  
        echo '<script>';
        echo 'setTimeout(function(){ $(".alert").fadeOut("slow"); }, 5000);';
        echo '</script>';
     }
  


    $result = mysqli_query($conn, "SELECT * FROM products WHERE id = $productId");

    if ($result) {
        $product = mysqli_fetch_assoc($result);

        $productName = $product['name'];
        $productPrice = $product['price'];
        $productDescription = $product['product_description'];
        $productAmount = $product['amount'];
        $productImage = $product['image'];
    } else {
        echo "Error retrieving product details: " . mysqli_error($conn);
    }
}

echo '<script>
document.addEventListener("DOMContentLoaded", function() {
    var productId = ' . json_encode($productId) . ';
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var wishStatus = xhr.responseText;
            console.log("Wish Status: " + wishStatus);
            updateWishlistButton(wishStatus);
        }
    };
    xhr.open("POST", "checkwishlist.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("id=" + productId);
});
</script>';
?>


<script>
function updateWishlistButton(wishStatus) {
    var wishlistButton = document.getElementById("wishlistButton");

    if (wishStatus === "1") {
        wishlistButton.innerText = "Remove from Wishlist";
        wishlistButton.onclick = removeFromWishlist;
    } else {
        wishlistButton.innerText = "Add to Wishlist";
        wishlistButton.onclick = addToWishlist;
    }
}
</script>



<div class="hero-wrap hero-bread" style="background-image: url('images/bg_1.jpg');">
    <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home</a></span> <span class="mr-2"><a
                            href="index.html">Product</a></span> <span>Product Single</span></p>
                <h1 class="mb-0 bread"><?php echo $productName; ?></h1>
            </div>
        </div>
    </div>
</div>

<section class="ftco-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mb-5 ftco-animate">
                <a href="images/product-1.jpg" class="image-popup"><img src="images/<?php echo $productImage; ?>"
                        class="img-fluid" alt="Colorlib Template"></a>
            </div>
            <div class="col-lg-6 product-details pl-md-5 ftco-animate">


                <h3><?php echo $productName; ?></h3>
                <p class="price"><span id="displayedPrice">Rs <?php echo $productPrice; ?></span></p>

                <script>
                function updatePrice() {
                    var sizeSelect = document.getElementById("size");
                    var selectedOption = sizeSelect.options[sizeSelect.selectedIndex];
                    var multiplier = selectedOption.getAttribute("data-multiplier");
                    var originalPrice = <?php echo $productPrice; ?>;
                    var newPrice = originalPrice * multiplier;
                    document.getElementById("displayedPrice").innerText = "Rs " + newPrice;
                }
                </script>

                <p><?php echo $productDescription; ?></p>
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="form-group d-flex">
                            <div class="select-wrap">
                                <div class="icon"><span class="ion-ios-arrow-down"></span></div>
                                <select name="size" id="size" class="form-control" onchange="updatePrice()">
                                    <option value="0.5" data-multiplier="1">Small-0.5kg</option>
                                    <option value="1" data-multiplier="2">Medium-1kg</option>
                                    <option value="2" data-multiplier="4">Large-2kg</option>
                                    <option value="5" data-multiplier="10">Extra Large -5kg</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="w-100"></div>
                    <div class="input-group col-md-6 d-flex mb-3">
                        <span class="input-group-btn mr-2">
                            <button type="button" class="quantity-left-minus btn" data-type="minus" data-field="">
                                <i class="ion-ios-remove"></i>
                            </button>
                        </span>
                        <input type="text" id="quantity" name="quantity" class="form-control input-number" value="1"
                            min="1" max="100">
                        <span class="input-group-btn ml-2">
                            <button type="button" class="quantity-right-plus btn" data-type="plus" data-field="">
                                <i class="ion-ios-add"></i>
                            </button>
                        </span>
                    </div>
                    <div class="w-100"></div>
                    <div class="col-md-12">
                        <p style="color: #000;"><?php echo $productAmount; ?> kg available</p>
                    </div>
                </div>
                <script>
                function addToCart() {
                    var quantity = document.getElementById("quantity").value;
                    var size = document.getElementById("size").value;
                    window.location.href = 'addtocart.php?id=<?php echo $productId; ?>&quantity=' + quantity +
                        '&size=' + size;
                }


                function addToWishlist() {
                    window.location.href = 'addtowishlist.php?id=<?php echo $productId; ?>';
                }
                </script>

                <div class="col-md-12 d-flex">
                    <div class="mr-2">
                        <p><a href="#" class="btn btn-black py-3 px-5" onclick="addToCart()">Add to Cart</a></p>
                    </div>
                    <div>
                        <p><a href="#" id="wishlistButton" class="btn btn-black py-3 px-5"
                                onclick="updateWishlistButton()">Add to Wishlist</a></p>
                    </div>

                    <script>
                    function removeFromWishlist() {
                        var productId = <?php echo json_encode($productId); ?>;
                        var xhr = new XMLHttpRequest();
                        xhr.onreadystatechange = function() {
                            if (xhr.readyState === 4) {
                                if (xhr.status === 200) {
                                    var response = xhr.responseText;
                                    if (response === 'removed_success') {
                                        console.log('Successfully removed from Wishlist');
                                        location.reload();
                                    } else {
                                        console.error('Error removing from Wishlist');
                                        location.reload();

                                    }
                                } else {
                                    console.error('Failed to send the request');
                                    location.reload();

                                }
                            }
                        };
                        xhr.open('POST', 'removewishlist.php', true);
                        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                        xhr.send('id=' + productId);
                    }
                    </script>


                </div>
            </div>
        </div>
    </div>
</section>




<?php include 'single-footer.php'; ?>