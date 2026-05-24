<?php
$pageTitle = 'Добавить источник';
require_once 'header.php';
checkAuth();

$error = '';
$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $index = trim($_POST['index_code']);
    $org_name = trim($_POST['org_name']);
    $ownership = $_POST['ownership_form'];
    $receipt = $_POST['receipt_form'];
    $notes = trim($_POST['notes']);
    if ($org_name) {
        $stmt = $pdo->prepare("INSERT INTO sources (index_code, org_name, ownership_form, receipt_form, notes) VALUES (?,?,?,?,?)");
        $stmt->execute([$index, $org_name, $ownership, $receipt, $notes]);
        $success = "Источник добавлен!";
    } else {
        $error = "Название организации обязательно.";
    }
}
?>
<h1>Добавление нового источника</h1>
<?php if ($success): ?><div class="success-message"><?= $success ?></div><?php endif; ?>
<?php if ($error): ?><div class="error-message"><?= $error ?></div><?php endif; ?>
<div class="contact-card">
    <form method="post">
        <div class="form-group"><label>Индекс организации</label><input type="text" name="index_code"></div>
        <div class="form-group"><label>Наименование организации</label><input type="text" name="org_name" required></div>
        <div class="form-group"><label>Форма собственности</label>
            <select name="ownership_form">
                <option value="государственная">государственная</option>
                <option value="муниципальная">муниципальная</option>
                <option value="частная">частная</option>
            </select>
        </div>
        <div class="form-group"><label>Форма приема документов</label>
            <select name="receipt_form">
                <option value="1">полная (1)</option>
                <option value="2.1">выборочная повидовая (2.1)</option>
                <option value="2.2">выборочная групповая (2.2)</option>
            </select>
        </div>
        <div class="form-group"><label>Примечания</label><textarea name="notes" rows="3"></textarea></div>
        <button type="submit" class="btn-primary">Добавить</button>
        <a href="sources.php" class="btn-secondary">Отмена</a>
    </form>
</div>
<?php require_once 'footer.php'; ?>