<?php
$pageTitle = 'Отчеты';
require_once 'header.php';
checkAuth();

// Отчёт: состав и объём архивных фондов
$stmt = $pdo->query("
    SELECT f.id, f.fund_number, f.fund_name, 
           COUNT(s.id) AS total_cases, 
           COALESCE(SUM(s.pages), 0) AS total_pages
    FROM funds f
    LEFT JOIN storage_units s ON f.id = s.fund_id
    GROUP BY f.id
    ORDER BY f.fund_number
");
$report = $stmt->fetchAll();
?>

<h1>Отчёт о составе и объёме архивных фондов</h1>
<div class="table-wrapper">
    <table class="data-table">
        <thead>
            <tr>
                <th>№ фонда</th>
                <th>Наименование фонда</th>
                <th>Количество дел</th>
                <th>Всего листов (ед.хр.)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($report as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['fund_number']) ?></td>
                <td><?= htmlspecialchars($row['fund_name']) ?></td>
                <td><?= $row['total_cases'] ?></td>
                <td><?= $row['total_pages'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php require_once 'footer.php'; ?>