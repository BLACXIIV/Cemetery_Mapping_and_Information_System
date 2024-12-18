<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// Check if the user is logged in
if (!isset($_SESSION['customer_id'])) {
    header("Location: login_page.php");
    exit();
}

include("../config.php");
$con = connect();

// Get the customer ID from the session
$customer_id = $_SESSION['customer_id'];

// Check if the form is submitted
if (isset($_POST["btn-owner-setup"])) {
    $site_id = mysqli_real_escape_string($con, $_POST["customer-site"]);
    $block_id = mysqli_real_escape_string($con, $_POST["customer-block"]);
    $lot_id = mysqli_real_escape_string($con, $_POST["customer-lot"]);
    
    $deed_of_sale = 'pending';

    // Check if the lot is already owned
    $sql_check = $con->query("SELECT * FROM `lot_owners` WHERE `site_id`='$site_id' AND `block_id`='$block_id' AND `lot_id`='$lot_id'");
    
    if (!$sql_check) {
        $_SESSION['error'] = "Error in query: " . $con->error;
        header("Location: buying_page.php");
        exit();
    }

    if ($sql_check->num_rows > 0) {
        // Lot is already owned
        $_SESSION['error'] = "This lot is already owned. Please select another lot.";
        header("Location: buying_page.php");
        exit();
    } else {
        // Insert new lot ownership including deed_of_sale
        $sql_insert = $con->query("INSERT INTO `lot_owners`(`customer_id`, `site_id`, `block_id`, `lot_id`, `deed_of_sale`) 
                                  VALUES ('$customer_id','$site_id','$block_id','$lot_id','$deed_of_sale')");
        
        if (!$sql_insert) {
            $_SESSION['error'] = "Error in insert query: " . $con->error;
            header("Location: buying_page.php");
            exit();
        }

        // Insert successful
        $_SESSION['success'] = "Lot Ownership Added Successfully";
        header("Location: buying_page.php");
        exit();
    }
}
?>