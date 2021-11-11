<?php
error_reporting(0);
require_once("config.php");
session_start();

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

//Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

$email = $_GET['email'];


echo"hi";
echo" email = ".$email;

// $sql = "SELECT * FROM USERS WHERE Email = '$email'";

// $result = $connect->query($sql);
// if ($result->num_rows > 0) {
//     while ($row = $result ->fetch_assoc()){
		// set session
	    $code = $row['Code'];
		$mail->SMTPDebug = 0;  
	    $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'mail.justforlhdb.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'dashboard_project@justforlhdb.com';                     //SMTP username
        $mail->Password   = '5N=}9f*5Mwyi';                               //SMTP password
        $mail->SMTPSecure = 'TLS';    
        //$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 465;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        //Recipients
        $mail->setFrom('dashboard_project@justforlhdb.com', 'HTCW');
        //$mail->addAddress('joe@example.net', 'Joe User');     //Add a recipient
        $mail->addAddress($email);               //Name is optional
        //$mail->addReplyTo('justforjmproject@gmail.com', 'Information');

        //Content
        //$mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'HTCW Verification Code';
        $mail->Body    = 'This is your verification code: ' . $code ;
        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        echo " 1";
        $mail->send();

		echo "success";
		//resendEmail($email, $code);
		
		echo "<script type='text/javascript'>alert('Code has been resent to your mailbox');
        window.location='index.php';
    </script>";
//     }
// }else{
//     echo "<script type='text/javascript'>alert('This email did not register！Please register an account!');
//         window.location='registerCode.php';
//     </script>";
// }


function resendEmail($useremail, $code)
{
    $to      = $useremail;
    $subject = 'HTCW Verification Code';
    $message = 'This is your verification code: ' . $code;
    $headers = 'From: noreply@hcw.com' . "\r\n" .
        'Reply-To: ' . $useremail . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
    mail($to, $subject, $message, $headers);
}


?>