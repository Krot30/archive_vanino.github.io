<?php
$pageTitle = 'Редактировать источник';
require_once 'header.php';
checkAuth();

$id = $_GET['id'] ?? 0;
if (!$id) {
    header('Location: sources.php');
    exit;
}
$stmt = $pdo->prepare("SELECT * FROM sources WHERE id = ?");
$stmt->execute([$id]);
$source = $stmt->fetch();
if (!$source) {
    header('Location: sources.php');
    exit;
}

$error = '';
$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $index = trim($_POST['index_code']);
    $org_name = trim($_POST['org_name']);
    $ownership = $_POST['ownership_form'];
    $receipt = $_POST['receipt_form'];
    $notes = trim($_POST['notes']);
    if ($org_name) {
        $upd = $pdo->prepare("UPDATE sources SET index_code=?, org_name=?, ownership_form=?, receipt_form=?, notes=? WHERE id=?");
        $upd->execute([$index, $org_name, $ownership, $receipt, $notes, $id]);
        $success = "Изменения сохранены.";
        // обновим $source
        $source['index_code'] = $index;
        $source['org_name'] = $org_name;
        $source['ownership_form'] = $ownership;
        $source['receipt_form'] = $receipt;
        $source['notes'] = $notes;
    } else {
        $error = "Название организации обязательно.";
    }
}
?>
<h1>Редактирование источника</h1>
<?php if ($success): ?><div class="success-message"><?= $success ?></div><?php endif; ?>
<?php if ($error): ?><div class="error-message"><?= $error ?></div><?php endif; ?>
<div class="contact-card">
    <form method="post">
        <div class="form-group"><label>Индекс организации</label><input type="text" name="index_code" value="<?= htmlspecialchars($source['index_code']) ?>"></div>
        <div class="form-group"><label>Наименование организации *</label><input type="text" name="org_name" value="<?= htmlspecialchars($source['org_name']) ?>" required></div>
        <div class="form-group"><label>Форма собственности</label>
            <select name="ownership_form">
                <option value="государственная" <?= $source['ownership_form'] == 'государственная' ? 'selected' : '' ?>>государственная</option>
                <option value="муниципальная" <?= $source['ownership_form'] == 'муниципальная' ? 'selected' : '' ?>>муниципальная</option>
                <option value="частная" <?= $source['ownership_form'] == 'частная' ? 'selected' : '' ?>>частная</option>
            </select>
        </div>
        <div class="form-group"><label>Форма приема документов</label>
            <select name="receipt_form">
                <option value="1" <?= $source['receipt_form'] == '1' ? 'selected' : '' ?>>полная (1)</option>
                <option value="2.1" <?= $source['receipt_form'] == '2.1' ? 'selected' : '' ?>>выборочная повидовая (2.1)</option>
                <option value="2.2" <?= $source['receipt_form'] == '2.2' ? 'selected' : '' ?>>выборочная групповая (2.2)</option>
            </select>
        </div>
        <div class="form-group"><label>Примечания</label><textarea name="notes" rows="3"><?= htmlspecialchars($source['notes']) ?></textarea></div>
        <button type="submit" class="btn-primary">Сохранить</button>
        <a href="sources.php" class="btn-secondary">Назад</a>
    </form>
</div>
<?php require_once 'footer.php'; ?>