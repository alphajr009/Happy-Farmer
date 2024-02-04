<?php
@include 'config.php';
include 'nav.php';

?>

<div class="hero-wrap hero-bread" style="background-image: url('images/bg_1.jpg');">
    <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home</a></span> <span>Wishlist</span></p>
                <h1 class="mb-0 bread">My Wishlist</h1>
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
                                <th>Product List</th>
                                <th>&nbsp;</th>
                                <th>Quantity(Kg)</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $wishlistQuery = "SELECT * FROM wishlist";
                            $wishlistResult = mysqli_query($conn, $wishlistQuery);

                            while ($row = mysqli_fetch_assoc($wishlistResult)) {
                                $productId = $row['productid'];

                                $productQuery = "SELECT * FROM products WHERE id = $productId";
                                $productResult = mysqli_query($conn, $productQuery);

                                if ($productRow = mysqli_fetch_assoc($productResult)) {
                                    echo '<tr class="text-center" id="wishlist_row_' . $row['productid'] . '">';
                                    echo '<td class="product-remove"><a href="javascript:void(0);" onclick="removeFromWishlist(' . $productId . ', \'wishlist_row_' . $row['productid'] . '\');"><span class="ion-ios-close"></span></a></td>';
                                    echo '<td class="image-prod">';
                                    echo '<div class="img" style="background-image:url(images/' . $productRow['image'] . ');"></div>';
                                    echo '</td>';
                                    echo '<td class="product-name">';
                                    echo '<h3>' . $productRow['name'] . '</h3>';
                                    echo '</td>';
                                    echo '<td class="price">0.5</td>'; 
                                    echo '<td class="price">Rs ' . $productRow['price'] . '</td>';
                                    echo '</tr>';
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
function removeFromWishlist(productId, rowId) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById(rowId).remove();
        }
    };

    xhr.open("GET", "remove_from_wishlist.php?productId=" + productId, true);
    xhr.send();
}
</script>

<?php include 'footer.php'; ?>