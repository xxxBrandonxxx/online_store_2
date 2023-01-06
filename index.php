<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
};

if (isset($_GET['logout'])) {
    unset($user_id);
    session_destroy();
    header('location:login.php');
};

if(isset($_POST['add_to_cart'])){

   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];

   $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name'
    AND user_id = '$user_id'") or die ('query failed');

   if(mysqli_num_rows($select_cart) > 0){
    $message[] = 'product already added to cart!';
   }else{
    mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, image, quantity) VALUES
    ('$user_id', '$product_name', '$product_price', '$product_image', '$product_quantity')")
     or die('query failed');
     $message[] = 'product added to cart!';
   }

}




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
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Audiowide">
    <link rel="stylesheet" href="src/styles.css">
    <title>Apex skateshop</title>
</head>

<body>
    <?php
    if (isset($message)) {
        foreach ($message as $message) {
            echo '<div class="message" onclick="this.remove();">' . $message . '</div>';
        }
    }
    ?>
    <div class="container">
        <div class="user_profile">

            <?php
            $select_user = mysqli_query($conn, "SELECT * FROM `user_form` WHERE id = '$user_id'") or die('query_failed');
            if (mysqli_num_rows($select_user) > 0) {
                $fetch_user = mysqli_fetch_assoc($select_user);
            };
            ?>

            <p> username : <span><?php echo $fetch_user['name']  ?></span> </p>
            <p> email : <span><?php echo $fetch_user['email'] ?></span> </p>
            <div class="flex">
                <!-- <a href="login.php" class="btn btn-outline-light btn-lg px-5">Login</a>
            <a href="register.php" class="btn btn-outline-light btn-lg px-5">Register</a> -->
                <a href="index.php?logout=<?php echo $user_id; ?>" onclick="return confirm('Are you sure you want to Logout?');" class="btn btn-warning">Logout</a>
            </div>
        </div>

        <div class="products">

          <h1 class="heading">Latest products</h1>

            <div class="box-container">

                <?php
                $select_product = mysqli_query($conn, "SELECT * FROM `products`") or die('query_failed');
                if (mysqli_num_rows($select_product) > 0) {
                    while ($fetch_product = mysqli_fetch_assoc($select_product)) {
                ?>

                        <form method="post" class="box" action="">
                            <img src="src/images/<?php echo $fetch_product['image']; ?>" alt="skateboard image" id="images">
                            <div class="name"><?php echo $fetch_product['name']; ?></div>
                            <div class="price">R<?php echo $fetch_product['price']; ?>.00</div>
                            <input type="number" min="1" name="product_quantity" value="1">
                            <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?> ">
                            <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
                            <input type="hidden" name="product_price"  value="<?php echo $fetch_product['price']; ?>">
                            <input type="submit" value="add to cart" name="add_to_cart" class="btn btn-primary">

                        </form>

                <?php
                    }
                };

                ?>


            </div>

        </div>


    </div>


</body>

</html>