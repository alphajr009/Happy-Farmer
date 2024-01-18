<?php
@include 'config.php';

if (isset($_GET['edit'])) {
    $productID = $_GET['edit'];

    $result = mysqli_query($conn, "SELECT * FROM products WHERE id = $productID");

    if ($result) {
        $product = mysqli_fetch_assoc($result);

        $productName = $product['name'];
        $productPrice = $product['price'];
        $productType = $product['type'];
        $productDescription = $product['product_description'];
        $productAmount = $product['amount'];

    } else {
        echo "Error retrieving product details: " . mysqli_error($conn);
    }
}

if (isset($_POST['update_product'])) {
    $productName = mysqli_real_escape_string($conn, $_POST['product_name']);
    $productDescription = mysqli_real_escape_string($conn, $_POST['product_description']);
    $productPrice = mysqli_real_escape_string($conn, $_POST['product_price']);
    $productAmount = mysqli_real_escape_string($conn, $_POST['product_amount']);
    $productType = mysqli_real_escape_string($conn, $_POST['product_type']);

    $updateQuery = "UPDATE products SET 
                    name = '$productName', 
                    product_description = '$productDescription', 
                    price = '$productPrice', 
                    amount = '$productAmount', 
                    type = '$productType' 
                    WHERE id = $productID";

    $updateResult = mysqli_query($conn, $updateQuery);

    if ($updateResult) {
        header('Location: product_update.php?edit=' . $productID);
    } else {
        echo "Error updating product: " . mysqli_error($conn);
    }
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin page</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <?php include 'product_addcdd.php'; ?>

</head>

<body>


    <div class="container">

        <div class="admin-product-form-container">

            <form action="" method="post" enctype="multipart/form-data">
                <h3>Update Product Details</h3>
                <label for="product_name">Product Name:</label>
                <input type="text" id="product_name" name="product_name" value="<?php echo $product['name'] ?>"
                    class="box">

                <label for="product_name">Product Description:</label>
                <div style="position: relative;">
                    <textarea id="product_description" name="product_description" class="box" maxlength="250"
                        oninput="updateCharacterCount()"
                        style="resize: vertical;"><?php echo $product['product_description'] ?></textarea>
                    <div id="characterCount" style="position: absolute; bottom: 0; right: 0;">Characters left: 250</div>
                </div>

                <script>
                document.addEventListener("DOMContentLoaded", function() {
                    updateCharacterCount();
                });

                function updateCharacterCount() {
                    var textarea = document.getElementById("product_description");
                    var remainingChars = 250 - textarea.value.length;

                    var countDisplay = document.getElementById("characterCount");
                    countDisplay.textContent = "Characters left: " + remainingChars;
                }
                </script>

                <br>


                <label for="product_price">Product Price:</label>
                <input type="number" id="product_price" name="product_price" value="<?php echo $product['price'] ?>"
                    class="box">

                <label for="product_price">Available Amount(kg):</label>
                <input type="number" id="product_amount" name="product_amount" value="<?php echo $product['amount'] ?>"
                    class="box">


                <label for="product_type">Product Type:</label>
                <select id="product_type" name="product_type" class="box">
                    <option value="vegetables" <?php echo ($product['type'] == 'vegetables') ? 'selected' : ''; ?>>
                        Vegetables</option>
                    <option value="fruits" <?php echo ($product['type'] == 'fruits') ? 'selected' : ''; ?>>Fruits
                    </option>
                    <option value="dried" <?php echo ($product['type'] == 'dried') ? 'selected' : ''; ?>>Dried</option>
                    <option value="materials" <?php echo ($product['type'] == 'materials') ? 'selected' : ''; ?>>
                        Materials</option>
                </select>

                <input type="submit" class="btn" name="update_product" value="Update Product">
                <a href="dashboard.php" class="btn">Go Back</a>

            </form>
        </div>
    </div>
    </div>
</body>

</html>