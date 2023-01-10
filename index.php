<?php
session_start();
include 'config.php';

// save session so if user logs out he can log in and all his items are still in the cart
$user_id = $_SESSION['user_id'];

// if user is not registered take him back to login page so he can not manually go to index.php without logging in
if (!isset($user_id)) {
    header('location:login.php');
};

//if user logs out he will destroy his session
if (isset($_GET['logout'])) {
    unset($user_id);
    session_destroy();
    header('location:login.php');
};

// adding items to the cart on the page with the product name price image and quantity
if (isset($_POST['add_to_cart'])) {

    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity = $_POST['product_quantity'];

//adds the product name to the specific user id so it will only display to them

    $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name'
    AND user_id = '$user_id'") or die('query failed');


// show error product is already added to cart
    if (mysqli_num_rows($select_cart) > 0) {
        $message[] = 'product already added to cart!';
    } else {

//else add the product to the cart
        mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, image, quantity) VALUES
    ('$user_id', '$product_name', '$product_price', '$product_image', '$product_quantity')")
            or die('query failed');
        $message[] = 'product added to cart!';
    }
};
//update items from cart
if(isset($_POST['update_cart'])){
    $update_quantity = $_POST['cart_quantity'];
    $update_id = $_POST['cart_id'];
    mysqli_query($conn, "UPDATE `cart` SET quantity = '$update_quantity' WHERE id = '$update_id' ") or die ('query failed');
    $message[] = 'cart quantity updated successfully!';
}
//Delete items from cart
if(isset($_GET['remove'])){
    $remove_id = $_GET['remove'];
    mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$remove_id'") or die ('query failed');
    header('location:index.php');
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
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous"> -->
    <link rel="stylesheet" , href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.2.1/css/fontawesome.min.css" , integrity="sha384-QYIZto+st3yW+o8+5OHfT6S482Zsvz2WfOzpFSXMF9zqeLcFV0/wlZpMtyFcZALm" , crossorigin="anonymous">
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Audiowide">
    <link rel="stylesheet" href="src/styles_v2.css">
    <title>Apex skateshop</title>
</head>

<body>
    <!-- includes the header for my navigation -->
<?php include __DIR__ . "/bars/header.php"; ?>
    <div>
        <?php
// if error is displayed you click it to remove it from the page        
        if (isset($message)) {
            foreach ($message as $message) {
                echo '<div class="message" onclick="this.remove();">' . $message . '</div>';
            }
        }
        ?>
        <div class="container">
            <div class="user_profile">

<!-- fetching user id and name and displays it on the webpage -->
                <?php
                $select_user = mysqli_query($conn, "SELECT * FROM `user_form` WHERE id = '$user_id'") or die('query_failed');
                if (mysqli_num_rows($select_user) > 0) {
                    $fetch_user = mysqli_fetch_assoc($select_user);
                };
                ?>
                <p> username : <span><?php echo $fetch_user['name']  ?></span> </p>
                <p> email : <span><?php echo $fetch_user['email'] ?></span> </p>
            </div>
            <div class="products">
                <h1 class="heading">Welcome to Apex SkateShop</h1>
                <div class="box-container">
                    <?php
                    $select_product = mysqli_query($conn, "SELECT * FROM `products`") or die('query_failed');
                    if (mysqli_num_rows($select_product) > 0) {
                        while ($fetch_product = mysqli_fetch_assoc($select_product)) {

                    ?>
<!-- displaying cards information from database such as the image rating name description 
price and if you click the button you add it to the cart-->
                            <form method="post" class="box" action="">
                                <img src="src/images/<?php echo $fetch_product['image']; ?>" alt="skateboard image" id="images">
                                <div class="name"><?php echo $fetch_product['name']; ?></div>
                                <div class="rating">Rating : <?php echo $fetch_product['rating']; ?>/10</div>
                                <div class="description">Description : <?php echo $fetch_product['description']; ?></div>
                                <div class="price">R<?php echo $fetch_product['price']; ?>.00</div>
                                <input type="number" min="1" name="product_quantity" value="1">
                                <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?> ">
                                <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
                                <input type="hidden" name="product_rating" value="<?php echo $fetch_product['rating']; ?>">
                                <input type="hidden" name="product_description" value="<?php echo $fetch_product['description']; ?>">
                                <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
                                <input type="submit" value="add to cart" name="add_to_cart" class="btn btn-primary">

                            </form>
                    <?php
                        }
                    };
                    ?>
                </div>
            </div>
 <!--displaying the shopping cart table on the webpage -->
            <div class="shopping-cart">
                <h1 class="heading">shopping cart</h1>
                <table>
                    <thead>
                        <th>image</th>
                        <th>name</th>
                        <th>price</th>
                        <th>quantity</th>
                        <th>total price</th>
                        <th>action</th>
                    </thead>
                    <tbody>

<!-- // function to fetch item in cart price  -->
                        <?php
                        $grand_total = 0;
                        $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query_failed');
                        if (mysqli_num_rows($cart_query) > 0) {
                            while ($fetch_cart = mysqli_fetch_assoc($cart_query)) {
                                $sub_total = $fetch_cart['price'] * $fetch_cart['quantity'];
                        ?>
<!-- fetching images and price from database  -->
                                <tr>
                                    <td><img src="src/images/<?php echo $fetch_cart['image']; ?>" height="100" alt="images of skateboards"></td>
 
                                    <td><?php echo $fetch_cart['name']; ?></td>
                                    <td>R <?php echo $fetch_cart['price']; ?></td>
                                    <td>
                                        <form action="" method="post">
                                            <input type="hidden" name="cart_id" value="<?php echo $fetch_cart['id']; ?>">
<!-- // update cart with quantity of your choosing to the cart -->
                                            <input type="number" min="1" name="cart_quantity" value="<?php echo $fetch_cart['quantity']; ?>">
                                            <input type="submit" name="update_cart" value="update" class="btn btn-secondary">
                                        </form>
                                    </td>
                                    <td>R <?php echo number_format($sub_total); ?></td>
                                    <td><a href="index.php?remove=<?php echo $fetch_cart['id']; ?>" class="btn btn-danger" onclick="return confirm('remove item from cart?');">remove</a></td>
                                </tr>

                        <?php
// calculate the sum of all item prices that is added to cart 
                                $grand_total += $sub_total;
                            };
                        };
                        ?>
<!-- // displays grand total -->
                        <tr class="table-bottom">
                            <td colspan="4">grand total :</td>
                            <td>R<?php echo $grand_total; ?></td>
                        </tr>
                    </tbody>
                </table>
                <div class="flex">
                    <a href="index.php?logout=<?php echo $user_id; ?>" onclick="return confirm('Are you sure you want to Logout?');" class="btn btn-warning">Logout</a>
                </div>
                <div class="cart-btn">
<!-- // if there are no items in the cart you can not check out -->
                    <a href="checkout.php" class="btn <?php echo ($grand_total > 1) ? '' : 'disabled'; ?>">proceed to checkout</a>
                </div>
            </div>

        </div>
    </div>
    <!-- include footer -->
    <?php include __DIR__ . "/bars/footer.php"; ?>
</body>

</html>;