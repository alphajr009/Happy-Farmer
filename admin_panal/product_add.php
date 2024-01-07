<?php

@include 'config.php';

if (isset($_POST['add_product'])) {

    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_type = $_POST['product_type']; 
    $product_description = $_POST['product_description'];
    $product_amount = $_POST['product_amount'];
    $product_image = $_FILES['product_image']['name'];
    $product_image_tmp_name = $_FILES['product_image']['tmp_name'];
    $product_image_folder = 'img/' . $product_image;

    if (empty($product_name) || empty($product_price) || empty($product_image) || empty($product_type)) {
        $message[] = 'Please fill out all fields';
    } else {
        $insert = "INSERT INTO products(name, price, type, image,product_description,amount) VALUES('$product_name', '$product_price', '$product_type', '$product_image', '$product_description','$product_amount')";
        $upload = mysqli_query($conn, $insert);
        if ($upload) {
            move_uploaded_file($product_image_tmp_name, $product_image_folder);
            $message[] = 'New product added successfully';
        } else {
            $message[] = 'Could not add the product';
        }
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM products WHERE id = $id");
    header('location: product_add.php');
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

    <style>
    :root {
        --green: #006400;
        --black: #e6f9ff;
        --white: #fff;
        --bg-color: #eee;
        --box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .1);
        --border: .1rem solid var(--black);
    }

    * {
        font-family: 'Poppins', sans-serif;
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        outline: none;
        border: none;
        text-decoration: none;
        text-transform: capitalize;
    }

    html {
        font-size: 62.5%;
        overflow-x: hidden;
    }

    .btn {
        display: block;
        width: 100%;
        cursor: pointer;
        border-radius: .5rem;
        margin-top: 1rem;
        font-size: 1.7rem;
        padding: 1rem 3rem;
        background: var(--green);
        color: black;
        text-align: center;
    }

    .btn1 {
        display: block;
        width: 100%;
        cursor: pointer;
        border-radius: .5rem;
        margin-top: 1rem;
        font-size: 1.7rem;
        padding: 1rem 3rem;
        background: #006400;
        color: black;
        text-align: center;
    }

    .btn2 {
        display: block;
        width: 100%;
        cursor: pointer;
        border-radius: .5rem;
        margin-top: 1rem;
        font-size: 1.7rem;
        padding: 1rem 3rem;
        background: #b22222;
        color: black;
        text-align: center;
    }

    .btn:hover {
        background: var(--black);
    }

    .btn1:hover {
        background: var(--black);
    }

    .btn2:hover {
        background: var(--black);
    }

    .message {
        display: block;
        background: var(--bg-color);
        padding: 1.5rem 1rem;
        font-size: 2rem;
        color: black;
        margin-bottom: 2rem;
        text-align: center;
    }

    .container {
        max-width: 1200px;
        padding: 2rem;
        margin: 0 auto;
    }

    .admin-product-form-container.centered {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;

    }

    .admin-product-form-container form {
        max-width: 50rem;
        margin: 0 auto;
        padding: 2rem;
        border-radius: .5rem;
        background: var(--bg-color);
    }

    .admin-product-form-container form h3 {
        text-transform: uppercase;
        color: #006400;
        margin-bottom: 1rem;
        text-align: center;
        font-size: 2.5rem;
    }

    .admin-product-form-container form .box {
        width: 100%;
        border-radius: .5rem;
        padding: 1.2rem 1.5rem;
        font-size: 1.7rem;
        margin: 1rem 0;
        background: var(--white);
        text-transform: none;
    }

    .container label {
        font-size: 1.5rem;
    }

    .product-display {
        margin: 2rem 0;
    }

    .product-display .product-display-table {
        width: 100%;
        text-align: center;
    }

    .product-display .product-display-table thead {
        background: var(--bg-color);
    }

    .product-display .product-display-table th {
        padding: 1rem;
        font-size: 2rem;
    }


    .product-display .product-display-table td {
        padding: 1rem;
        font-size: 2rem;
        border-bottom: var(--border);
    }

    .product-display .product-display-table .btn:first-child {
        margin-top: 0;
    }

    .product-display .product-display-table .btn:last-child {
        background: crimson;
    }

    .product-display .product-display-table .btn:last-child:hover {
        background: var(--black);
    }


    @media (max-width:991px) {

        html {
            font-size: 55%;
        }

    }

    @media (max-width:768px) {

        .product-display {
            overflow-y: scroll;
        }

        .product-display .product-display-table {
            width: 80rem;
        }

    }

    @media (max-width:450px) {

        html {
            font-size: 50%;
        }

    }
    </style>

</head>

<body>

    <?php

if(isset($message)){
   foreach($message as $message){
      echo '<span class="message">'.$message.'</span>';
   }
}

?>

    <div class="container">

        <div class="admin-product-form-container">

            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                <h3>Add a New Product</h3>
                <label for="product_name">Product Name:</label>
                <input type="text" id="product_name" name="product_name" placeholder="Enter product name" class="box">

                <label for="product_name">Product Description:</label>
                <div style="position: relative;">
                    <textarea id="product_description" name="product_description"
                        placeholder="Enter product description" class="box" maxlength="250"
                        oninput="updateCharacterCount()" style="resize: vertical;"></textarea>
                    <div id="characterCount" style="position: absolute; bottom: 0; right: 0;">Characters left: 250</div>
                </div>

                <script>
                function updateCharacterCount() {
                    var textarea = document.getElementById("product_description");
                    var remainingChars = 250 - textarea.value.length;

                    var countDisplay = document.getElementById("characterCount");
                    countDisplay.textContent = "Characters left: " + remainingChars;
                }
                </script>

                <br>


                <label for="product_price">Product Price:</label>
                <input type="number" id="product_price" name="product_price" placeholder="Enter product price"
                    class="box">

                <label for="product_price">Available Amount(kg):</label>
                <input type="number" id="product_amount" name="product_amount"
                    placeholder="Enter Available Amount in Kilograms" class="box">

                <label for="product_type">Product Type:</label>
                <select id="product_type" name="product_type" class="box">
                    <option value="vegetables">Vegetables</option>
                    <option value="fruits">Fruits</option>
                    <option value="dried">Dried</option>
                    <option value="materials">Materials</option>
                </select>

                <label for="product_image">Product Image:</label>
                <input type="file" id="product_image" accept="image/png, image/jpeg, image/jpg" name="product_image"
                    class="box">

                <input type="submit" class="btn" name="add_product" value="Add Product">
                <a href="dashboard.php" class="btn">Go Back</a>
            </form>
        </div>

        <?php

   $select = mysqli_query($conn, "SELECT * FROM products");
   
   ?>
        <div class="product-display">
            <table class="product-display-table">
                <thead>
                    <tr>
                        <th>product image</th>
                        <th>product name</th>
                        <th>product price</th>
                        <th>product type</th>
                        <th>Amount</th>
                        <th>action</th>
                    </tr>
                </thead>
                <?php while($row = mysqli_fetch_assoc($select)){ ?>
                <tr>
                    <td><img src="img/<?php echo $row['image']; ?>" height="100" alt=""></td>
                    <td><?php echo $row['name']; ?></td>
                    <td>LKR <?php echo $row['price']; ?>/=</td>
                    <td><?php echo $row['type']; ?></td>
                    <td><?php echo $row['amount']; ?></td>
                    <td>
                        <a href="product_update.php?edit=<?php echo $row['id']; ?>" class="btn1"> <i
                                class="fas fa-edit"></i> edit </a>
                        <a href="product_add.php?delete=<?php echo $row['id']; ?>" class="btn2"> <i
                                class="fas fa-trash"></i> delete </a>
                    </td>
                </tr>
                <?php } ?>
            </table>

        </div>

    </div>


</body>

</html>