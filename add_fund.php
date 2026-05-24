<?php
$pageTitle = 'Добавить фонд';
require_once 'header.php';
checkAuth();

$error = '';
$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fund_number = trim($_POST['fund_number']);
    $fund_name = trim($_POST['fund_name']);
    $extreme_dates = trim($_POST['extreme_dates']);
    if ($fund_number && $fund_name) {
        $stmt = $pdo->prepare("INSERT INTO funds (fund_number, fund_name, extreme_dates) VALUES (?,?,?)");
        $stmt->execute([$fund_number, $fund_name, $extreme_dates]);
        $success = "Фонд успешно добавлен!";
    } else {
        $error = "Заполните номер и название фонда.";
    }
}
?>
<h1>Добавление нового фонда</h1>
<?php if ($success): ?><div class="success-message"><?= $success ?></div><?php endif; ?>
<?php if ($error): ?><div class="error-message"><?= $error ?></div><?php endif; ?>
<div class="contact-card">
    <form method="post">
        <div class="form-group"><label>Номер фонда</label><input type="text" name="fund_number" required></div>
        <div class="form-group"><label>Наименование фонда</label><input type="text" name="fund_name" required></div>
        <div class="form-group"><label>Крайние даты</label><input type="text" name="extreme_dates" required></div>
        <button type="submit" class="btn-primary">Добавить</button>
        <a href="funds.php" class="btn-secondary">Отмена</a>
    </form>
</div>
<?php require_once 'footer.php'; ?>