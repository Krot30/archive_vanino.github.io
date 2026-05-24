<?php
$pageTitle = 'Результат поиска';
require_once 'header.php';
checkAuth();

$fund_id = $_GET['fund_id'] ?? 0;
$inventory = $_GET['inventory_number'] ?? '';
$case_num = $_GET['case_number'] ?? '';

$cases = [];
$titleInfo = '';

if ($fund_id) {
    $sql = "SELECT s.*, f.fund_name, f.fund_number FROM storage_units s JOIN funds f ON s.fund_id = f.id WHERE f.id = ?";
    $params = [$fund_id];
    if ($inventory !== '') {
        $sql .= " AND s.inventory_number = ?";
        $params[] = $inventory;
    }
    if ($case_num !== '') {
        $sql .= " AND s.case_number = ?";
        $params[] = $case_num;
    }
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $cases = $stmt->fetchAll();
    $titleInfo = "Дела выбранного фонда";
} else {
    header('Location: search.php');
    exit;
}

if (empty($cases)) {
    echo "<div class='error-message'>По вашему запросу ничего не найдено. <a href='search.php'>Вернуться к поиску</a></div>";
    require_once 'footer.php';
    exit;
}
?>

<h1><?= htmlspecialchars($titleInfo) ?></h1>
<div class="table-wrapper">
    <table class="data-table">
        <thead>
            <tr>
                <th>Название фонда</th>
                <th>Фонд №</th>
                <th>Хранилище</th>
                <th>Стеллаж</th>
                <th>Полка</th>
                <th>Опись №</th>
                <th>Дело №</th>
                <th>Ед.хр.</th>
                <th>Заголовок дела</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cases as $item): ?>
            <tr>
                <td><?= htmlspecialchars($item['fund_name']) ?></td>
                <td><?= htmlspecialchars($item['fund_number']) ?></td>
                <td><?= htmlspecialchars($item['storage_number']) ?></td>
                <td><?= htmlspecialchars($item['shelf_number']) ?></td>
                <td><?= htmlspecialchars($item['rack_number']) ?></td>
                <td><?= htmlspecialchars($item['inventory_number']) ?></td>
                <td><?= htmlspecialchars($item['case_number']) ?></td>
                <td><?= $item['pages'] ?></td>
                <td><?= htmlspecialchars($item['title']) ?></td>
                <td class="action-buttons">
                    <a href="edit_case.php?id=<?= $item['id'] ?>" class="btn-secondary btn-sm">Редактировать</a>
                    <a href="delete_case.php?id=<?= $item['id'] ?>" class="btn-danger btn-sm" onclick="return confirm('Удалить дело?')">Удалить</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div><a href="search.php" class="btn-secondary">Назад к поиску</a></div>
<?php require_once 'footer.php'; ?>