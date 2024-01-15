<?php
@include 'config.php';

if (isset($_POST['add_news'])) {

    $newsName = mysqli_real_escape_string($conn, $_POST['news_name']);
    $newsDescription = mysqli_real_escape_string($conn, $_POST['news_description']);

    $imageName = $_FILES['news_image']['name'];
    $imageTempName = $_FILES['news_image']['tmp_name'];
    $imagePath = "img/" . $imageName;
    move_uploaded_file($imageTempName, $imagePath);

    $insertQuery = "INSERT INTO news (title, body, image) VALUES ('$newsName', '$newsDescription', '$imagePath')";
    mysqli_query($conn, $insertQuery);

}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM news WHERE news_id = $id");
    header('location: news_add.php');
    exit(); 
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

    <?php 
include 'product_style.php';
 ?>

</head>

<body>


    <div class="container">

        <div class="admin-product-form-container">

            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                <h3>Post News</h3>
                <label for="news_name">News Tittle:</label>
                <input type="text" id="news_name" name="news_name" placeholder="Enter news tittle" class="box">

                <label for="news_name">News Body:</label>
                <div style="position: relative;">
                    <textarea id="news_description" name="news_description" placeholder="Enter news body" class="box"
                        maxlength="250" oninput="updateCharacterCount()"
                        style="resize: vertical; height: 300px; "></textarea>
                    <div id="characterCount" style="position: absolute; bottom: 0; right: 0;">Characters left: 2300
                    </div>
                </div>


                <script>
                function updateCharacterCount() {
                    var textarea = document.getElementById("news_description");
                    var remainingChars = 2300 - textarea.value.length;

                    var countDisplay = document.getElementById("characterCount");
                    countDisplay.textContent = "Characters left: " + remainingChars;
                }
                </script>

                <br>

                <label for="product_image">Main Image:</label>
                <input type="file" id="news_image" accept="image/png, image/jpeg, image/jpg" name="news_image"
                    class="box">

                <input type="submit" class="btn" name="add_news" value="Post News">
                <a href="dashboard.php" class="btn">Go Back</a>
            </form>
        </div>

        <?php

   $select = mysqli_query($conn, "SELECT * FROM news");
   
   ?>
        <div class="product-display">
            <table class="product-display-table">
                <thead>
                    <tr>
                        <th>News image</th>
                        <th>News Title</th>
                        <th>action</th>
                    </tr>
                </thead>
                <?php while ($row = mysqli_fetch_assoc($select)) { ?>
                <tr>
                    <td><img src="<?php echo $row['image']; ?>" height="100" alt=""></td>
                    <td><?php echo $row['title']; ?></td>
                    <td>
                        <a href="news_update.php?edit=<?php echo $row['news_id']; ?>" class="btn1"> <i
                                class="fas fa-edit"></i> edit </a>
                        <a href="news_add.php?delete=<?php echo $row['news_id']; ?>" class="btn2"
                            onclick="return confirm('Are you sure you want to delete this news?')"> <i
                                class="fas fa-trash"></i> delete </a>
                    </td>
                </tr>
                <?php } ?>
            </table>

        </div>

    </div>


</body>

</html>