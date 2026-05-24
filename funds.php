<?php
$pageTitle = 'Фонды';
require_once 'header.php';
checkAuth();

$search = $_GET['search'] ?? '';
if ($search) {
    $stmt = $pdo->prepare("SELECT * FROM funds WHERE fund_number LIKE ? OR fund_name LIKE ? ORDER BY fund_number");
    $stmt->execute(["%$search%", "%$search%"]);
} else {
    $stmt = $pdo->query("SELECT * FROM funds ORDER BY fund_number");
}
$funds = $stmt->fetchAll();
?>
<h1>Каталог фондов</h1>
<div class="search-bar">
    <form method="get" style="display: flex; gap: 10px; width: 100%;">
        <input type="text" name="search" placeholder="Поиск по номеру или названию" value="<?= htmlspecialchars($search) ?>">
        <button type="submit" class="btn-primary">Найти</button>
        <a href="funds.php" class="btn-secondary">Сбросить</a>
        <a href="add_fund.php" class="btn-primary" style="margin-left: auto;">Добавить фонд</a>
    </form>
</div>
<div class="table-wrapper">
    <table class="data-table">
        <thead>
            <tr><th>№ фонда</th><th>Наименование фонда</th><th>Крайние даты</th><th>Действия</th></tr>
        </thead>
        <tbody>
            <?php foreach ($funds as $fund): ?>
            <tr>
                <td><?= htmlspecialchars($fund['fund_number']) ?></td>
                <td><?= htmlspecialchars($fund['fund_name']) ?></td>
                <td><?= htmlspecialchars($fund['extreme_dates']) ?></td>
                <td class="action-buttons">
                    <a href="edit_fund.php?id=<?= $fund['id'] ?>" class="btn-secondary btn-sm">Редактировать</a>
                    <a href="search_results.php?fund_id=<?= $fund['id'] ?>" class="btn-secondary btn-sm">Дела</a>
                    <a href="delete_fund.php?id=<?= $fund['id'] ?>" class="btn-danger btn-sm" onclick="return confirm('Удалить фонд со всеми делами?')">Удалить</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php require_once 'footer.php'; ?>