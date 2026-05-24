<?php
$pageTitle = 'Поиск дел';
require_once 'header.php';
checkAuth();
$funds = $pdo->query("SELECT id, fund_number, fund_name FROM funds ORDER BY fund_number")->fetchAll();
?>
<h1>Поиск архивных дел</h1>
<div class="contact-card">
    <form action="search_results.php" method="get">
        <div class="form-group">
            <label>Фонд</label>
            <select name="fund_id" required>
                <option value="">-- выберите фонд --</option>
                <?php foreach ($funds as $fund): ?>
                    <option value="<?= $fund['id'] ?>"><?= htmlspecialchars($fund['fund_number'] . ' - ' . $fund['fund_name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Номер описи</label>
            <input type="number" name="inventory_number">
        </div>
        <div class="form-group">
            <label>Номер дела</label>
            <input type="number" name="case_number">
        </div>
        <button type="submit" class="btn-primary">Найти</button>
        <a href="search.php" class="btn-secondary">Сбросить</a>
    </form>
</div>
<?php require_once 'footer.php'; ?>