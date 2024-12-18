<?php
session_start();
include("../config.php");
$con = connect();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $lot_owner_id = $_POST['lot_owner_id'];
    $service_id = $_POST['service_id'];
    $request_date = $_POST['request_date'];
    $additional_notes = $_POST['additional_notes'];

    // Prepare and bind
    $stmt = $con->prepare("INSERT INTO service_requests (lot_owner_id, service_id, request_date, additional_notes) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $lot_owner_id, $service_id, $request_date, $additional_notes);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Service request added successfully!";
    } else {
        $_SESSION['error'] = "Error adding service request: " . $stmt->error;
    }

    $stmt->close();
    $con->close();
    header("Location: buying_page.php"); // Redirect back to the page with the form
    exit();
}