<?php
// check for any errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'config.php';

if(isset($_POST['submit'])){
//This function is used to create a legal SQL string that can be used in an SQL statement.
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
    $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));

 // if user exists
    $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE email = '$email' AND password = '$pass'") or die('query failed');
    if(mysqli_num_rows($select) > 0){
        $message[] = 'user already exist!';

// else insert into database username email and password
    }else{
        mysqli_query($conn, "INSERT INTO `user_form`(name, email, password) VALUES('$name','$email','$pass')") or die('query failed');
        $message[] = 'registered successfully!';
        header('location:login.php');
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
    <title>Register Apex</title>

</head>

<body>

  <?php
  // any message pops up because an username already exist show error otherwise add to database
  // register page was done using Bootstrap 5
    if(isset($message)){
        foreach($message as $message){
            echo '<div class="message" onclick="this.remove();">' .$message.'</div>';
        }
    }
  ?>

    <div class="vh-150 gradient-custom " id="wallpaperLogin">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-dark text-white" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">
                          <div class="mb-md-1 mt-md-1 pb-1">
                                <h2 class="fw-bold mb-2 text-uppercase">Register now</h2>
                                <form action='' method="post">
                                    <div class="form-outline form-white mb-4">
                                        <input type="text" id="typeTextX" class="form-control form-control-lg" name="name" required placeholder="enter username">
                                        <label class="form-label" for="InputText">Username</label>
                                    </div>
                                    <div class="form-outline form-white mb-4">
                                        <input type="email" id="typeEmailX" class="form-control form-control-lg" name="email" required placeholder="enter email">
                                        <label class="form-label" for="InputText">Email</label>
                                    </div>
                                    <div class="form-outline form-white mb-4">
                                        <input type="password" id="typePasswordX" class="form-control form-control-lg" name="password" required placeholder="enter password" />
                                        <label class="form-label" for="typePasswordX">Password</label>
                                    </div>
                                    <div class="form-outline form-white mb-4">
                                        <input type="password" id="typePasswordX" class="form-control form-control-lg" name="cpassword" required placeholder="confirm password" />
                                        <label class="form-label" for="typePasswordX">Confirm Password</label>
                                    </div>
                                    <div>
                                        <button class="btn btn-outline-light btn-lg px-5" value="register now" type="submit" name="submit">Register</button>
                                    </div>
                                </form>
                                <p class="text-white-50 mb-5">Already have an account? <a href="login.php">Login now</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</body>

</html>