<?php 
@include 'config.php';
include 'nav.php';


$select = mysqli_query($conn, "SELECT * FROM news WHERE news_id = {$_GET['news_id']}");

$row = mysqli_fetch_assoc($select);

$newsImage = '../admin_panal/' . $row['image'];
$title = $row['title'];
$body = $row['body'];
$timestamp = $row['timestamp_column'];

 ?>

<div class="hero-wrap hero-bread" style="background-image: url('images/bg_1.jpg');">
    <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home</a></span> <span>Blog</span></p>
                <h1 class="mb-0 bread">Blog</h1>
            </div>
        </div>
    </div>
</div>

<section class="ftco-section ftco-degree-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 ftco-animate">
                <h2 class="mb-3"> <?php echo $title?> </h2>
                <p><?php echo date('F j, Y', strtotime($row['timestamp_column'])); ?></p>

                <img src="<?php echo $newsImage?>" alt="" class="img-fluid">
                </p>
                <p><?php echo nl2br($body)?></p>

            </div>
        </div>

    </div>
    </div>
</section>

<?php 
include 'bfooter.php';
 ?>