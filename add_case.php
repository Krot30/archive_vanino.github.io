<?php
$pageTitle = 'Добавление дела';
require_once 'header.php';
checkAuth();

$success = '';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fund_id = $_POST['fund_id'] ?? 0;
    $storage = trim($_POST['storage_number']);
    $shelf = trim($_POST['shelf_number']);
    $rack = trim($_POST['rack_number']);
    $inventory = trim($_POST['inventory_number']);
    $case_num = trim($_POST['case_number']);
    $pages = (int)($_POST['pages'] ?? 0);
    $title = trim($_POST['title']);
    if ($fund_id && $storage && $shelf && $rack && $inventory && $case_num && $pages >= 10 && $title) {
        $stmt = $pdo->prepare("INSERT INTO storage_units (fund_id, storage_number, shelf_number, rack_number, inventory_number, case_number, pages, title) VALUES (?,?,?,?,?,?,?,?)");
        $stmt->execute([$fund_id, $storage, $shelf, $rack, $inventory, $case_num, $pages, $title]);
        $success = "Дело успешно добавлено!";
    } else {
        $error = "Заполните все поля. Количество листов должно быть не менее 10.";
    }
}
$funds = $pdo->query("SELECT id, fund_number, fund_name FROM funds ORDER BY fund_number")->fetchAll();
?>
<h1>Добавить новое дело</h1>
<?php if ($success): ?><div class="success-message"><?= $success ?></div><?php endif; ?>
<?php if ($error): ?><div class="error-message"><?= $error ?></div><?php endif; ?>
<div class="contact-card">
    <form method="post">
        <div class="form-group">
            <label>Фонд</label>
            <select name="fund_id" required>
                <option value="">-- выберите фонд --</option>
                <?php foreach ($funds as $fund): ?>
                    <option value="<?= $fund['id'] ?>"><?= htmlspecialchars($fund['fund_number'] . ' - ' . $fund['fund_name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group"><label>Хранилище №</label><input type="number" name="storage_number" required></div>
        <div class="form-group"><label>Стеллаж №</label><input type="number" name="shelf_number" required></div>
        <div class="form-group"><label>Полка №</label><input type="number" name="rack_number" required></div>
        <div class="form-group"><label>Опись №</label><input type="number" name="inventory_number" required></div>
        <div class="form-group"><label>Дело №</label><input type="number" name="case_number" required></div>
        <div class="form-group"><label>Количество листов (ед.хр.)</label><input type="number" name="pages" min="10" required></div>
        <div class="form-group"><label>Заголовок дела</label><textarea name="title" rows="3" required></textarea></div>
        <button type="submit" class="btn-primary">Добавить</button>
    </form>
</div>
<?php require_once 'footer.php'; ?>