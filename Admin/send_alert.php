<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require '/Users/Adrian Kyle/vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['send-alert'])) {
    include("../config.php");
    $con = connect();
    
    if (!$con) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    // Get all customer emails
    $query = $con->query("SELECT email, CONCAT(first_name, ' ', family_name) as full_name FROM customers");
    if (!$query) {
        die("Query failed: " . $con->error);
    }
    
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    
    $mail = new PHPMailer(true);
    
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'nedrudarey101@gmail.com';
        $mail->Password = 'ioxleoxedxjppedc';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587; // Use 587 for TLS encryption
        
        // Sender
        $mail->setFrom('nedrudarey101@gmail.com', 'Holy Gardens Matutum Memorial Park');
        
        // Add all customers to BCC
        while ($row = $query->fetch_assoc()) {
            $mail->addBCC($row['email'], $row['full_name']);
        }
        
        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = '
        <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
            <h2 style="color: #333;">Holy Gardens Matutum Memorial Park</h2>
            <div style="padding: 20px; background-color: #f9f9f9; border-radius: 5px;">
                ' . nl2br(htmlspecialchars($message)) . '
            </div>
            <p style="color: #666; font-size: 12px; margin-top: 20px;">
                This is an automated message. Please do not reply to this email.
            </p>
        </div>';
        
        $mail->send();
        
        $_SESSION['success'] = "Alert has been sent to all customers successfully!";
    } catch (Exception $e) {
        $_SESSION['error'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
    
    header("Location: alert.php");
    exit();
}
?>
