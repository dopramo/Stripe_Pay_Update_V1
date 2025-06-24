<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use Dompdf\Dompdf;

\Stripe\Stripe::setApiKey('sk_test_51O8hN1EqXnZAamc5xAGQrgO2SCcJkCGsylRg6RazDZfZiE3teZzBQufPiUUuQiFj8fQiBoLcjksob4o4mFJXaaSa00gNgFxooI');

$conn = new mysqli("localhost", "root", "vgr&pmd1031P", "Stripe_Pay");

$payload = @file_get_contents("php://input");
$sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
$event = \Stripe\Webhook::constructEvent($payload, $sig_header, 'whsec_GqQsOTTguyHFPvoArqf9UFJ5daxErtra');

$session = $event->data->object;

if ($event->type == 'checkout.session.completed') {
    $status = 'paid';
} elseif ($event->type == 'checkout.session.expired') {
    $status = 'canceled';
} else {
    exit();
}

$stmt = $conn->prepare("UPDATE payments SET status = ? WHERE stripe_session_id = ?");
$stmt->bind_param("ss", $status, $session->id);
$stmt->execute();

// Retrieve the payment record
$stmt = $conn->prepare("SELECT reference_no, email, amount FROM payments WHERE stripe_session_id = ?");
$stmt->bind_param("s", $session->id);
$stmt->execute();
$stmt->bind_result($reference_no, $email, $amount);
$stmt->fetch();

// Generate updated PDF
$pdf = new Dompdf();
$html = "<h1>Auto Bravia Payment - $status</h1><p>Reference No: $reference_no</p><p>Email: $email</p><p>Amount: $$amount</p><p>Status: $status</p>";
$pdf->loadHtml($html);
$pdf->render();
$pdfPath = __DIR__ . "/invoices/$reference_no-final.pdf";
file_put_contents($pdfPath, $pdf->output());

// Send updated email
$mail = new PHPMailer();
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'fundmenow23@gmail.com';
$mail->Password = 'viywkbgmwmmctqaq';
$mail->SMTPSecure = 'tls';
$mail->Port = 587;

$mail->setFrom('fundmenow23@gmail.com', 'Auto Bravia');
$mail->addAddress($email);
$mail->Subject = "Payment $status - Reference $reference_no";
$mail->Body = "Thank you. Your payment status is: $status\n\nReference: $reference_no";
$mail->addAttachment($pdfPath);

$mail->send();
?>