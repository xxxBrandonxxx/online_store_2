<?php
include __DIR__ . "/config/config.php";
session_start()
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" , href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.2.1/css/fontawesome.min.css" , integrity="sha384-QYIZto+st3yW+o8+5OHfT6S482Zsvz2WfOzpFSXMF9zqeLcFV0/wlZpMtyFcZALm" , crossorigin="anonymous">
    <link rel="stylesheet" href="src/styles.css">
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Audiowide">
    <title>Apex SkateShop</title>
</head>

<?php include __DIR__ . "/bars/header.php"; ?>
<section>
    <div id="about" class="bg-dark">
        <div class="container py-5">
            <div class="row h-100 align-items-center py-5">
                <div class="col-lg-6">
                    <h1 class="lead text-muted">With roots stretching back to the early 1960's surf and skate culture, Kingdom Boards® is a father and son founded brand. Officially
                        established in 2012 and inspired by a journey of following our passion for both wood and creation.<br><br>
                    </h1>
                    <h2 class="lead text-muted mb-0">OUR MISSION AND VISION.</h2>
                    <p class="lead text-muted">At Apex Boards, we set our minds and skills to tell a story through individually handcrafting each board and building a relationship between our owners, board shapers and customers. We take pride in paying great attention to detail and craftsmanship making our product's unique and one of a kind.
                        While on this journey, we are equally as passionate about inspiring others to pursue their own passions, find their purpose and find freedom in living life to the fullest.
                        Our vision is to inspire people to experience freedom under their feet and share adventurous memories through board riding around the world.<a href="https://bootstrapious.com/snippets" class="text-muted">
                            <u>Bootstrapious</u></a>
                    </p>
                </div>
                <div class="col-lg-6 d-none d-lg-block"><img src="src/images/desktop-img.jpg" alt="me on skateboard" class="img-fluid">
                    <h1 class="lead text-muted">This is me going down a set of 8 back in 2012 Man This was the life! </h1>
                </div>
            </div>
        </div>
    </div>
    <?php include __DIR__ . "/bars/footer.php"; ?>
</section>