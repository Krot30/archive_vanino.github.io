<?php
$pageTitle = 'Редактировать дело';
require_once 'header.php';
checkAuth();

$id = $_GET['id'] ?? 0;
if (!$id) {
    header('Location: funds.php');
    exit;
}
$stmt = $pdo->prepare("SELECT * FROM storage_units WHERE id = ?");
$stmt->execute([$id]);
$case = $stmt->fetch();
if (!$case) {
    header('Location: funds.php');
    exit;
}
$funds = $pdo->query("SELECT id, fund_number, fund_name FROM funds ORDER BY fund_number")->fetchAll();

$error = '';
$success = '';
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
        $upd = $pdo->prepare("UPDATE storage_units SET fund_id=?, storage_number=?, shelf_number=?, rack_number=?, inventory_number=?, case_number=?, pages=?, title=? WHERE id=?");
        $upd->execute([$fund_id, $storage, $shelf, $rack, $inventory, $case_num, $pages, $title, $id]);
        $success = "Изменения сохранены.";
        $case['fund_id'] = $fund_id;
        $case['storage_number'] = $storage;
        $case['shelf_number'] = $shelf;
        $case['rack_number'] = $rack;
        $case['inventory_number'] = $inventory;
        $case['case_number'] = $case_num;
        $case['pages'] = $pages;
        $case['title'] = $title;
    } else {
        $error = "Заполните все поля. Количество листов должно быть не менее 10.";
    }
}
?>
<h1>Редактирование дела</h1>
<?php if ($success): ?><div class="success-message"><?= $success ?></div><?php endif; ?>
<?php if ($error): ?><div class="error-message"><?= $error ?></div><?php endif; ?>
<div class="contact-card">
    <form method="post">
        <div class="form-group">
            <label>Фонд</label>
            <select name="fund_id" required>
                <?php foreach ($funds as $fund): ?>
                    <option value="<?= $fund['id'] ?>" <?= $fund['id'] == $case['fund_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($fund['fund_number'] . ' - ' . $fund['fund_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group"><label>Хранилище №</label><input type="number" name="storage_number" value="<?= htmlspecialchars($case['storage_number']) ?>" required></div>
        <div class="form-group"><label>Стеллаж №</label><input type="number" name="shelf_number" value="<?= htmlspecialchars($case['shelf_number']) ?>" required></div>
        <div class="form-group"><label>Полка №</label><input type="number" name="rack_number" value="<?= htmlspecialchars($case['rack_number']) ?>" required></div>
        <div class="form-group"><label>Опись №</label><input type="number" name="inventory_number" value="<?= htmlspecialchars($case['inventory_number']) ?>" required></div>
        <div class="form-group"><label>Дело №</label><input type="number" name="case_number" value="<?= htmlspecialchars($case['case_number']) ?>" required></div>
        <div class="form-group"><label>Количество листов (ед.хр.)</label><input type="number" name="pages" min="10" value="<?= $case['pages'] ?>" required></div>
        <div class="form-group"><label>Заголовок дела</label><textarea name="title" rows="3" required><?= htmlspecialchars($case['title']) ?></textarea></div>
        <button type="submit" class="btn-primary">Сохранить</button>
        <a href="search_results.php?fund_id=<?= $case['fund_id'] ?>" class="btn-secondary">Назад</a>
    </form>
</div>
<?php require_once 'footer.php'; ?>