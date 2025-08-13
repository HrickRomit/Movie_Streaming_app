<?php
session_start();
require '../config/db.php'; // Database connection
require '../vendor/autoload.php'; // PHPMailer via Composer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$emailOrMobile = trim($_POST['email']); 
$password = $_POST['password'];

if (empty($emailOrMobile) || empty($password)) {
    header("Location: ../pages/login.php?error=Please+fill+in+all+fields");
    exit();
}

// Check if user exists by email
$query = "SELECT * FROM User WHERE Email = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "s", $emailOrMobile);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) === 1) {
    $user = mysqli_fetch_assoc($result);

    if ($user['Password'] === $password) { // NOTE: no hashing as per your original code

        // Generate OTP
        $otp = rand(100000, 999999);
        $expiry = date("Y-m-d H:i:s", strtotime("+5 minutes"));

        // Store OTP & expiry in DB
        $update = "UPDATE User SET otp_code = ?, otp_expires_at = ? WHERE UserID = ?";
        $updateStmt = mysqli_prepare($conn, $update);
        mysqli_stmt_bind_param($updateStmt, "ssi", $otp, $expiry, $user['UserID']);
        mysqli_stmt_execute($updateStmt);

        // Send OTP via email
        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; 
            $mail->SMTPAuth = true;
            $mail->Username = 'dbms311project@gmail.com'; // change this
            $mail->Password = 'gkca efms ezck jviu'; // Gmail app password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            // Recipients
            $mail->setFrom('dbms311project@gmail.com', 'Movie Streaming App');
            $mail->addAddress($user['Email'], $user['Username']);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Your OTP Code';
            $mail->Body = "<p>Your OTP code is: <b>$otp</b></p><p>It will expire in 5 minutes.</p>";

            $mail->send();

            // Redirect to OTP form
            header("Location: ../pages/login.php?otp=1&email=" . urlencode($user['Email']));
            exit();
        } catch (Exception $e) {
            header("Location: ../pages/login.php?error=Could+not+send+OTP");
            exit();
        }

    } else {
        header("Location: ../pages/login.php?error=Incorrect+password");
        exit();
    }
} else {
    header("Location: ../pages/login.php?error=User+not+found");
    exit();
}
