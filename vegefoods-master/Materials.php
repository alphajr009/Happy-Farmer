<?php 
@include 'config.php';
include 'nav.php';

 ?>



<div class="hero-wrap hero-bread" style="background-image: url('images/bg_1.jpg');">
    <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home</a></span> <span>Products</span>
                </p>
                <h1 class="mb-0 bread">Materials</h1>
            </div>
        </div>
    </div>
</div>

<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 mb-5 text-center">
                <ul class="product-category">
                    <li><a href="Vegetables.php">Vegetables</a></li>
                    <li><a href="Fruits.php">Fruits</a></li>
                    <li><a href="Dried.php">Dried</a></li>
                    <li><a href="Materials.php"
                            style="display: inline-block; padding: 10px 20px; background-color: #82ae46; color: #fff; text-decoration: none; border-radius: 12px; transition: background-color 0.3s;">Materials</a>
                    </li>

                </ul>
            </div>
        </div>

        <div class="row">
            <?php
    // Retrieve and display only vegetable products
    $result = mysqli_query($conn, "SELECT * FROM products WHERE type = 'materials'");
    while ($row = mysqli_fetch_assoc($result)) {
        $productId = $row['id'];
        $productName = $row['name'];
        $productPrice = $row['price'];
        $productImage = '../admin_panal/img/' . $row['image'];
    ?>
            <div class="col-md-6 col-lg-3 ftco-animate">
                <div class="product" style="height: 100%;">
                    <a href="single-product.php?id=<?php echo $productId; ?>" class="img-prod"
                        style="display: block; overflow: hidden; height: 200px;">
                        <img class="img-fluid" style="width: 100%; height: 100%; object-fit: cover;"
                            src="<?php echo $productImage; ?>" alt="<?php echo $productName; ?>">
                        <div class="overlay"></div>
                    </a>
                    <div class="text py-3 pb-4 px-3 text-center">
                        <h3><a href="single-product.php?id=<?php echo $productId; ?>"><?php echo $productName; ?></a>
                        </h3>
                        <div class="d-flex">
                            <div class="pricing">
                                <p class="price"><span class="price-sale">Rs.<?php echo $productPrice; ?></span></p>
                            </div>
                        </div>
                        <div class="bottom-area d-flex px-3">
                            <div class="m-auto d-flex">
                                <a href="single-product.php?id=<?php echo $productId; ?>"
                                    class="add-to-cart d-flex justify-content-center align-items-center text-center">
                                    <span><i class="ion-ios-menu"></i></span>
                                </a>
                                <a href="single-product.php?id=<?php echo $productId; ?>"
                                    class="buy-now d-flex justify-content-center align-items-center mx-1">
                                    <span><i class="ion-ios-cart"></i></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
    }
    ?>
        </div>






</section>

<?php include 'footer.php'; ?>