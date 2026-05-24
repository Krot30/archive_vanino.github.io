<?php
require_once 'config.php';
checkAuth();
$id = $_GET['id'] ?? 0;
if ($id) {
    $stmt = $pdo->prepare("DELETE FROM storage_units WHERE id = ?");
    $stmt->execute([$id]);
}
$referer = $_SERVER['HTTP_REFERER'] ?? 'funds.php';
header("Location: $referer");
exit;