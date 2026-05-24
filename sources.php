<?php
$pageTitle = 'Источники комплектования';
require_once 'header.php';
checkAuth();

$search = $_GET['search'] ?? '';
if ($search) {
    $stmt = $pdo->prepare("SELECT * FROM sources WHERE org_name LIKE ? ORDER BY id");
    $stmt->execute(["%$search%"]);
} else {
    $stmt = $pdo->query("SELECT * FROM sources ORDER BY id");
}
$sources = $stmt->fetchAll();
?>
<h1>Список источников комплектования</h1>
<div class="search-bar">
    <form method="get" style="display: flex; gap: 10px; width: 100%;">
        <input type="text" name="search" placeholder="Поиск по названию организации" value="<?= htmlspecialchars($search) ?>">
        <button type="submit" class="btn-primary">Найти</button>
        <a href="sources.php" class="btn-secondary">Сбросить</a>
        <a href="add_source.php" class="btn-primary" style="margin-left: auto;">Добавить источник</a>
    </form>
</div>
<div class="table-wrapper">
    <table class="data-table">
        <thead>
            <tr><th>№ п/п</th><th>Индекс</th><th>Наименование организации</th><th>Форма собственности</th><th>Форма приема</th><th>Примечания</th><th>Действия</th></tr>
        </thead>
        <tbody>
            <?php $counter = 1; foreach ($sources as $src): ?>
            <tr>
                <td><?= $counter++ ?></td>
                <td><?= htmlspecialchars($src['index_code']) ?></td>
                <td><?= htmlspecialchars($src['org_name']) ?></td>
                <td><?= htmlspecialchars($src['ownership_form']) ?></td>
                <td><?= htmlspecialchars($src['receipt_form']) ?></td>
                <td><?= htmlspecialchars($src['notes']) ?></td>
                <td class="action-buttons">
                    <a href="edit_source.php?id=<?= $src['id'] ?>" class="btn-secondary btn-sm">Редактировать</a>
                    <a href="delete_source.php?id=<?= $src['id'] ?>" class="btn-danger btn-sm" onclick="return confirm('Удалить источник?')">Удалить</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php require_once 'footer.php'; ?>