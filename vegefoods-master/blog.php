<?php 
@include 'config.php';
include 'nav.php';

$select = mysqli_query($conn, "SELECT * FROM news");



?>

<div class="hero-wrap hero-bread" style="background-image: url('images/bg_1.jpg');">
    <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home</a></span> <span>NEWS</span></p>
                <h1 class="mb-0 bread">NEWS</h1>
            </div>
        </div>
    </div>
</div>

<section class="ftco-section ftco-degree-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 ftco-animate">
                <div class="row">


                    <?php while ($row = mysqli_fetch_assoc($select)) { 
                        $newsImage = '/admin_panal/img/' . $row['image'];

                        ?>
                    <div class="col-md-12 d-flex ftco-animate">
                        <div class="blog-entry align-self-stretch d-md-flex">

                            <img class="block-20" src="<?php echo '../admin_panal/' . $row['image']; ?>"
                                alt="News Image" class="img-fluid">
                            </a>

                            <div class="text d-block pl-md-4">
                                <div class="meta mb-3">
                                    <div><a
                                            href="#"><?php echo date('F j, Y', strtotime($row['timestamp_column'])); ?></a>
                                    </div>
                                </div>
                                <h3 class="heading"><a href="#"><?php echo $row['title']; ?></a></h3>
                                <p><?php echo substr($row['body'], 0, 90); ?>...</p>
                                <p><a href="blog-single.php?news_id=<?php echo $row['news_id']; ?>"
                                        class="btn btn-primary py-2 px-3">Read more</a></p>
                            </div>
                        </div>
                    </div>
                    <br>
                    <?php } ?>



                    <?php include 'blog_footer.php' ?>