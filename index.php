<?php
$pageTitle = 'Главная';
require_once 'header.php';
checkAuth();
?>
<h1>"Архив"</h1>
<div class="hero-text">
    <p>Добро пожаловать!</p>
    <p>Используйте быстрые действия для навигации по системе.</p>
</div>
<div class="quick-actions">
    <a href="funds.php" class="quick-btn">Перейти к фондам</a>
    <a href="search.php" class="quick-btn">Найти дело</a>
    <a href="add_case.php" class="quick-btn">Добавить дело</a>
    <a href="sources.php" class="quick-btn">Перейти к источникам</a>
    <a href="reports.php" class="quick-btn">Отчеты</a>
</div>
<?php require_once 'footer.php'; ?>