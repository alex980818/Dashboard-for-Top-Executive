<?
require 'PHPMailer2/PHPMailerAutoload.php';
$email = $_GET['email'];

echo" email = ".$email;

$mail = new PHPMailer;
$mail->isSMTP();
$mail->SMTPDebug = 0;
$mail->Debugoutput = 'html';
$mail->Host = "mail.justforlhdb.com";
$mail->Port = 2525;
$mail->SMTPAuth = true;
$mail->SMTPAutoTLS = false;
$mail->SMTPSecure = 'tls'; // To enable TLS/SSL encryption change to 'tls'
$mail->AuthType = "CRAM-MD5";
$mail->Username = "dashboard_project@justforlhdb.com";
$mail->Password = "8cT{8-+AZ~bM";
$mail->setFrom('dashboard_project@justforlhdb.com', 'YOUR NAME');
$mail->addReplyTo($email, 'YOUR NAME');
$mail->addAddress($email, 'YOUR NAME'); //(Send the test to yourself)
$mail->Subject = 'PHPMailer SMTP test';
$mail->isHTML(true);
$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent!";
}
?>