<?php
session_start();
include("../config.php");
$con=connect();
$customers=$con->query("SELECT * FROM `customers`");
$customer_info=$con->query("SELECT * FROM `customers`");
$customer_info_lot=$con->query("SELECT * FROM `customers`");

if (isset($_POST['btn-login'])) {
    $email = mysqli_real_escape_string($con, $_POST['email-login']);
    $password = mysqli_real_escape_string($con, $_POST['nickname-login']);

    // Query to check if user exists
    $query = "SELECT * FROM customers WHERE email = '$email' AND nickname = '$password'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) == 1) {
        // User found - start session and save customer_id
        $row = mysqli_fetch_assoc($result);
        session_start();
        $_SESSION['user_id'] = $row['id']; // Assuming 'id' is the primary key for customers
        $_SESSION['customer_id'] = $row['customer_id']; // Assuming 'customer_id' is the field you want to retain
        $_SESSION['email'] = $row['email'];

        // Redirect to buying page
        header("Location: ../Admin/buying_page.php");
        exit();
    } else {
        // Invalid credentials - show error message
        echo "
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Login Failed',
                text: 'Invalid email or password!',
                confirmButtonColor: '#3085d6'
            });
        </script>";
    }
}

// Logout functionality (if needed)
if(isset($_GET['logout'])) {
    session_start();
    session_destroy();
    header("Location: index.php");
    exit();
}

// Function to check if user is logged in (use this on protected pages)
function isLoggedIn() {
    if(isset($_SESSION['user_id'])) {
        return true;
    }
    return false;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
   <script src="https://kit.fontawesome.com/ec4303cca5.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" href="../Assets/image/logopngplain1.png" type="image/x-icon">
<title>Booking | Holy Gardens Matutum Memorial Park</title>

<link rel="stylesheet" href="../Assets/css/style.css">
<link rel="stylesheet" href="../Assets/css/index_admin.css">
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css"/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="../Assets/DataTables/datatables.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>

<script src="../Assets/js/index.js" defer></script>
<script src="../Assets/js/sweetalert.js"></script>

 
</head>
<style>
    :root{
        --Poppins: 'Poppins', sans-serif;
        --Font2: 'Roboto', sans-serif;
        --Font3: 'Inter', sans-serif;

        --color1: #00563B;
        --color2: white;
        --color3: rgb(107, 21, 21);
    }
    .get-started-btn a{
        background-color: var(--color1);
    }
    .navlogo{
        height:65px;
        width: 65px;
    }
    .cont-1{
    width: 100%;
    text-align: center;
    margin:50px 0px -50px 0px;
    }
    .cont-1 p{
    width: 60%;
    margin: 0 auto;
    }
</style>
<body>
 <?php include("../Admin/queries/application.php");?>
    <header class="primary-header">
        <div class="logo">
            <img src="../Assets/image/logopngplain1.png" alt="navLogo" class="navlogo">
        </div>

        <button aria-controls="primary-nav" aria-expanded="false" class="nav-toggle">
            <span class="sr-only">
                Menu
            </span>
        </button>

        <nav>
            <ul class="primary-nav" id="primary-nav" data-visible="false">
                <li> 
                    <a href="../index.php">HOME</a> 
                </li>
                <li> 
                    <a href="../index.php#service">SERVICES</a> 
                </li>
                <li> 
                    <a href="../index.php#faqs">FAQs</a> 
                </li>
                <li> 
                    <a href="../index.php#news">NEWS & EVENTS</a> 
                </li>
                <li> 
                    <a href="../index.php#contact">CONTACT</a> 
                </li>
            </ul>
        </nav>

    </header>

    <div class="findgrave-cont">
        <div class="findgrave-cont-main">
            <div class="main-cont cont-1">
                <h1>Booking Makes Easier</h1>
            </div>
            <div class="main-cont cont-2">
                <div class="cont-2-img first">
                    <img src="../Assets/image/stepno1.svg" alt="">
                    <h2>1. Select Your Plot Type</h2>
                </div>
                <div class="cont-2-img">
                    <img src="../Assets/image/stepno2.svg" alt="">
                    <h2>2. Complete the Booking Form</h2>
                </div>
                <div class="cont-2-img">
                    <img src="../Assets/image/stepno3.svg" alt="">
                    <h2>3. Reserve Lawn Lot </h2>
                </div>
            </div>
         
              <<div class="sec2">
    <div class="container">
        <!-- Modal Form -->
        <div class="modal fade" id="add-customer" tabindex="-1" aria-labelledby="addCustomerLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="addCustomerLabel">Registration Form</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post">
                            <div class="row mb-2">
                                <div class="col-md-3 col-sm-6">
                                    <label for="family-name">Family name:<i class="req">*</i></label>
                                    <input type="text" name="family-name" id="family-name" class="form-control" placeholder="Surname" required>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <label for="first-name">First name:<i class="req">*</i></label>
                                    <input type="text" name="first-name" id="first-name" class="form-control" placeholder="Given name" required>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <label for="middle-name">Middle name:</label>
                                    <input type="text" name="middle-name" id="middle-name" class="form-control" placeholder="Middle name">
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <label for="nickname">Password:</label>
                                    <input type="password" name="nickname" id="nickname" class="form-control" placeholder="Password">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-12 col-sm-12">
                                    <label for="home-address">Home Address:<i class="req">*</i></label>
                                    <input type="text" name="home-address" id="home-address" class="form-control" placeholder="House No./Unit/Purok/Subdivision/Village - Brgy. - City - Province" required>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-3 col-sm-6">
                                    <label for="contact">Contact No:<i class="req">*</i></label>
                                    <input type="text" name="contact" id="contact" class="form-control" pattern="(\+?\d{2}?\s?\d{3}\s?\d{3}\s?\d{4})|([0]\d{3}\s?\d{3}\s?\d{4})" maxlength="11" placeholder="09XXxxxxxxx" required>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <label for="email">Email:<i class="req">*</i></label>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="Email address" required>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <label for="bday">Birthday:<i class="req">*</i></label>
                                    <input type="date" name="bday" id="bday" class="form-control" required>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <label for="gender">Gender:<i class="req">*</i></label>
                                    <select name="gender" id="gender" class="form-select" required>
                                        <option value="" selected disabled>Select gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-3 col-sm-6">
                                    <label for="religion">Religion:<i class="req">*</i></label>
                                    <input type="text" name="religion" id="religion" class="form-control" placeholder="Religion" required>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <label for="citizenship">Citizenship:<i class="req">*</i></label>
                                    <input type="text" name="citizenship" id="citizenship" class="form-control" placeholder="Citizenship" required>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <label for="civil-status">Civil Status:<i class="req">*</i></label>
                                    <select name="civil-status" id="civil-status" class="form-select" required>
                                        <option value="" selected disabled>Select status</option>
                                        <option value="Single">Single</option>
                                        <option value="Married">Married</option>
                                        <option value="Widowed">Widowed</option>
                                        <option value="Seperated">Seperated</option>
                                    </select>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <label for="work">Occupation:<i class="req">*</i></label>
                                    <select name="work" id="work" class="form-select" required>
                                        <option value="" selected disabled>Select occupation</option>
                                        <option value="Government Employee">Government Employee</option>
                                        <option value="Private Employee">Private Employee</option>
                                        <option value="Self-Employed">Self-Employed</option>
                                        <option value="Unemployed">Unemployed</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="btn-submit-customer" class="btn btn-success">Register</button>
                                <button type="reset" class="btn btn-danger">Reset</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal for buy no-->
       <div class="modal fade" id="buy-now" tabindex="-1" aria-labelledby="buyNowLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="buyNowLabel">Login to Proceed</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <div class="row mb-2">
                        <div class="col-md-12 col-sm-12">
                            <label for="email-login">Email:<i class="req">*</i></label>
                            <input type="email" name="email-login" id="email-login" class="form-control" placeholder="Email address" required>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-12 col-sm-12">
                            <label for="nickname-login">Password:<i class="req">*</i></label>
                            <div class="input-group">
                                <input type="password" name="nickname-login" id="nickname-login" class="form-control" placeholder="Enter password" required>
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="bx bx-hide"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="btn-login" class="btn btn-success">Login</button>
                      
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


        <!-- Centered Register Button -->
        <div class="row justify-content-center mt-5">
                        <div class="col-auto d-flex gap-3"> 
                            <button class="btn btn-success add-customer d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#add-customer">
                                <i class='bx bxs-user-plus fs-4'></i> 
                                &nbsp;Register
                            </button>
                            <button class="btn btn-success d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#buy-now">
                                <i class='bx bxs-cart fs-4'></i> 
                                &nbsp;Buy Now
                            </button>
                        </div>
                    </div>

        </div>
    </div>

    <!-- Swiper JS -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
      <script src="https://unpkg.com/boxicons@2.1.1/dist/boxicons.js"></script>
  <script src="https://kit.fontawesome.com/ec4303cca5.js" crossorigin="anonymous"></script>
  <script src="../Assets/js/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  <script type="text/javascript" src="../Assets/DataTables/datatables.min.js"></script>
  <script src="../Assets/js/index_admin.js" defer></script>
</body>
</html>