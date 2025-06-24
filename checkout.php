<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Dompdf\Dompdf;

\Stripe\Stripe::setApiKey('sk_test_51O8hN1EqXnZAamc5xAGQrgO2SCcJkCGsylRg6RazDZfZiE3teZzBQufPiUUuQiFj8fQiBoLcjksob4o4mFJXaaSa00gNgFxooI');

$customer_email = $_POST['customer_email'];
$amount = $_POST['amount'] * 100;
$reference_no = 'REF-' . strtoupper(uniqid());

$conn = new mysqli("localhost", "root", "vgr&pmd1031P", "Stripe_Pay");

$session = \Stripe\Checkout\Session::create([
    'payment_method_types' => ['card'],
    'line_items' => [[
        'price_data' => [
            'currency' => 'usd',
            'product_data' => ['name' => 'Invoice Payment'],
            'unit_amount' => $amount,
        ],
        'quantity' => 1,
    ]],
    'mode' => 'payment',
    'success_url' => 'http://localhost/StripePayUpdate/success.php?session_id={CHECKOUT_SESSION_ID}',
    'cancel_url' => 'http://localhost/StripePayUpdate/index.php?canceled=true',
    'customer_email' => $customer_email,
]);

$amount_value = $amount / 100;
$stripe_session_id = $session->id;
$stmt = $conn->prepare("INSERT INTO payments (reference_no, email, amount, stripe_session_id) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssds", $reference_no, $customer_email, $amount_value, $stripe_session_id);
$stmt->execute();

$paymentUrl = $session->url;

$qrCode = new QrCode($paymentUrl);
$writer = new PngWriter();
$result = $writer->write($qrCode);
$qrPath = "/var/www/html/StripePayUpdate/payment_qr.png";
$result->saveToFile($qrPath);

$pdf = new Dompdf();
$html = "<h1>Auto Bravia Payment</h1><p>Reference No: $reference_no</p><p>Email: $customer_email</p><p>Amount: $" . ($amount / 100) . "</p>";
$pdf->loadHtml($html);
$pdf->render();
$pdfPath = "/var/www/html/StripePayUpdate/invoices/$reference_no.pdf";
file_put_contents($pdfPath, $pdf->output()) or die("Failed to save PDF");

$mail = new PHPMailer();
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'fundmenow23@gmail.com';
$mail->Password = 'viywkbgmwmmctqaq';
$mail->SMTPSecure = 'tls';
$mail->Port = 587;

$mail->setFrom('fundmenow23@gmail.com', 'Auto Bravia');
$mail->addAddress($customer_email);
$mail->Subject = 'Your Payment Link';
$mail->Body = "Click to pay: $paymentUrl\n\nReference: $reference_no\nOr scan the attached QR code.";
$mail->addAttachment($qrPath);
$mail->addAttachment($pdfPath);

if (!$mail->send()) {
    error_log('Mailer Error: ' . $mail->ErrorInfo);
    die('Email failed');
}

header("Location: " . $paymentUrl);
exit;
?>