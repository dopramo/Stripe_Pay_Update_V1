<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$conn = new mysqli("localhost", "root", "vgr&pmd1031P", "Stripe_Pay");
$session_id = $_GET['session_id'] ?? '';
$status = '';
if ($session_id) {
    $stmt = $conn->prepare("SELECT status FROM payments WHERE stripe_session_id = ?");
    $stmt->bind_param("s", $session_id);
    $stmt->execute();
    $stmt->bind_result($status);
    $stmt->fetch();
    $stmt->close();
}
?>
<!DOCTYPE html>
<html>
<head><title>Payment Success</title></head>
<body>
  <h1>Thank you!</h1>
  <p>Your payment status: <strong><?= htmlspecialchars($status) ?></strong></p>
</body>
</html>

