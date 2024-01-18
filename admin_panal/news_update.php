<?php
@include 'config.php';

if (isset($_GET['edit'])) {
    $newsID = $_GET['edit'];

    $result = mysqli_query($conn, "SELECT * FROM news WHERE news_id = $newsID");

    if ($result) {
        $news = mysqli_fetch_assoc($result);

        $newsTitle = $news['title'];
        $newsBody = $news['body'];
    } else {
        echo "Error retrieving news details: " . mysqli_error($conn);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_news'])) {
  
    
    $updatedTitle = $_POST['news_name'];
    $updatedBody = $_POST['news_description'];


    $updateQuery = "UPDATE news SET title = ?, body = ? WHERE news_id = ?";

    $stmt = mysqli_prepare($conn, $updateQuery);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssi", $updatedTitle, $updatedBody, $newsID);

        if (mysqli_stmt_execute($stmt)) {
            header('Location: news_update.php?edit=' . $newsID);
            exit(); 
        } else {
            echo "Error updating news: " . mysqli_stmt_error($stmt);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing statement: " . mysqli_error($conn);
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

    <?php 
include 'product_style.php';
 ?>

</head>

<body>
    <div class="container">
        <div class="admin-product-form-container">
            <form action="" method="post" enctype="multipart/form-data">
                <h3>Update News</h3>
                <label for="news_name">News Title:</label>
                <input type="text" id="news_name" name="news_name" class="box" value="<?php echo $newsTitle ?>">

                <label for="news_description">News Body:</label>
                <div style="position: relative;">
                    <textarea id="news_description" name="news_description" class="box" oninput="updateCharacterCount()"
                        style="resize: vertical; height: 300px;"><?php echo $newsBody ?></textarea>

                    <div id="characterCount" style="position: absolute; bottom: 0; right: 0;">Characters left: 2300
                    </div>
                </div>

                <script>
                document.addEventListener("DOMContentLoaded", function() {
                    updateCharacterCount();
                });

                function updateCharacterCount() {
                    var textarea = document.getElementById("news_description");
                    var remainingChars = 2300 - textarea.value.length;

                    var countDisplay = document.getElementById("characterCount");
                    countDisplay.textContent = "Characters left: " + remainingChars;
                }
                </script>

                <br>

                <input type="submit" class="btn" name="update_news" value="Update News">
                <a href="news_add.php" class="btn">Go Back</a>
            </form>
        </div>
    </div>
</body>

</html>