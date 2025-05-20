<?php
// Tải các file PHPMailer thủ công
require_once 'app/libs/PHPMailer/src/Exception.php';
require_once 'app/libs/PHPMailer/src/PHPMailer.php';
require_once 'app/libs/PHPMailer/src/SMTP.php';

// Khai báo namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function getMailer() {
    $mail = new PHPMailer(true);
    try {
        $mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);
        // Cấu hình server SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'trit56789@gmail.com';
        $mail->Password = 'wgutxdskvrlmofue'; // Loại bỏ khoảng trắng
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Cấu hình người gửi
        $mail->setFrom('trit56789@gmail.com', 'Droppy Shop');
        $mail->CharSet = 'UTF-8';

        return $mail;
    } catch (Exception $e) {
        error_log("Mailer Error: {$mail->ErrorInfo}");
        return null;
    }
}
?>