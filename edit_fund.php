<?php
$pageTitle = 'Редактировать фонд';
require_once 'header.php';
checkAuth();

$id = $_GET['id'] ?? 0;
if (!$id) {
    header('Location: funds.php');
    exit;
}
$stmt = $pdo->prepare("SELECT * FROM funds WHERE id = ?");
$stmt->execute([$id]);
$fund = $stmt->fetch();
if (!$fund) {
    header('Location: funds.php');
    exit;
}

$error = '';
$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fund_number = trim($_POST['fund_number']);
    $fund_name = trim($_POST['fund_name']);
    $extreme_dates = trim($_POST['extreme_dates']);
    if ($fund_number && $fund_name) {
        $upd = $pdo->prepare("UPDATE funds SET fund_number=?, fund_name=?, extreme_dates=? WHERE id=?");
        $upd->execute([$fund_number, $fund_name, $extreme_dates, $id]);
        $success = "Изменения сохранены.";
        $fund['fund_number'] = $fund_number;
        $fund['fund_name'] = $fund_name;
        $fund['extreme_dates'] = $extreme_dates;
    } else {
        $error = "Заполните номер и название фонда.";
    }
}
?>
<h1>Редактирование фонда</h1>
<?php if ($success): ?><div class="success-message"><?= $success ?></div><?php endif; ?>
<?php if ($error): ?><div class="error-message"><?= $error ?></div><?php endif; ?>
<div class="contact-card">
    <form method="post">
        <div class="form-group"><label>Номер фонда *</label><input type="text" name="fund_number" value="<?= htmlspecialchars($fund['fund_number']) ?>" required></div>
        <div class="form-group"><label>Наименование фонда *</label><input type="text" name="fund_name" value="<?= htmlspecialchars($fund['fund_name']) ?>" required></div>
        <div class="form-group"><label>Крайние даты</label><input type="text" name="extreme_dates" value="<?= htmlspecialchars($fund['extreme_dates']) ?>"></div>
        <button type="submit" class="btn-primary">Сохранить</button>
        <a href="funds.php" class="btn-secondary">Назад</a>
    </form>
</div>
<?php require_once 'footer.php'; ?>