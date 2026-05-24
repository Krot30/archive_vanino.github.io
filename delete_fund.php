<?php
require_once 'config.php';
checkAuth();
$id = $_GET['id'] ?? 0;
if ($id) {
    $stmt = $pdo->prepare("DELETE FROM funds WHERE id = ?");
    $stmt->execute([$id]);
}
header('Location: funds.php');
exit;