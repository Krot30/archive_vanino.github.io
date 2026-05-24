<?php if (!isset($noAuth)) require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>АИС "Архив" - <?= $pageTitle ?? 'Главная' ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header class="site-header">
    <div class="container header-container">
        <div class="logo-area">
            <img src="logo.png" alt="Логотип архивного отдела" class="logo-img">
        </div>
        <nav class="main-nav">
            <ul class="nav-menu">
                <li><a href="index.php"><img src="Group 1.png" alt="иконка" class="nav-icon"> Главная</a></li>
                <li><a href="funds.php"><img src="Group 2.png" alt="иконка" class="nav-icon"> Фонды</a></li>
                <li><a href="search.php"><img src="Group 3.png" alt="иконка" class="nav-icon"> Поиск дел</a></li>
                <li><a href="add_case.php"><img src="Group 4.png" alt="иконка" class="nav-icon"> Добавление дел</a></li>
                <li><a href="sources.php"><img src="Group 5.png" alt="иконка" class="nav-icon"> Источники</a></li>
                <li><a href="reports.php"><img src="Group 6.png" alt="иконка" class="nav-icon"> Отчеты</a></li>
                <li><a href="logout.php"><img src="Group 7.png" alt="иконка" class="nav-icon"> Выйти</a></li>
            </ul>
        </nav>
    </div>
</header>
<main class="site-main">
    <div class="container">