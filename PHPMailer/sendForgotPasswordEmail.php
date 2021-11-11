<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;



// Load Composer's autoloader
require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';



// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

// include_once("dbconnect.php");
// $email=$_POST['email'];

include_once("config.php");
$conn = new mysqli('localhost', 'justforl_projectadmin', 'JxNB&sx$SP*x', 'justforl_project');

$email = $_GET['email'];

// echo nl2br("email = ".$email."\n");

//try {
    //Server settings
    // $mail->SMTPDebug = 3;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    // $mail->isMail();                                            
    $mail->Host       = 'smtp.justforlhdb.com';                    // Set the SMTP server to send through
    $mail->Host = gethostbyname('mail.justforlhdb.com');
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'dashboard_project@justforlhdb.com';                     // SMTP username
    $mail->Password   = '5N=}9f*5Mwyi';                               // SMTP password
    $mail->SMTPSecure = 'ssl';  //TLS       // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 465;    //587                                // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
    $mail->SMTPOptions = array(
                            'ssl' => array(
                            'verify_peer' => false,
                            'verify_peer_name' => false,
                            'allow_self_signed' => true
                            )
                            );
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
    

$sqlchoose = "SELECT * FROM USERS WHERE EMAIL = '$email'";
$result = $conn->query($sqlchoose);

if($result-> num_rows>0){
    $mail->setFrom('dashboard_project@justforlhdb.com', 'Dashboard for Top Executive (DFTE)');
    $mail->addAddress($email, 'Receiver'); 
    $mail->isHTML(true);                                 
    $mail->Subject = 'From Justforlhdb Dashboard. Reset Password';
    $mail->Body    = 'Please use the following link to reset your password: <br/><br/>https://justforlhdb.com/project/resetPassword.php?email='.$email;
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    
    $mail->send();
    
    echo"Please check ".$email." to reset the password.";
    
}else{
    echo"failed";
}