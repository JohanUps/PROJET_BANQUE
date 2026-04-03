<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>MiniBank</title>
    <link rel="stylesheet" href="/style.css">
</head>
<body>

<nav class="navbar">
    <h1>MiniBank 🏦</h1>

    <div class="nav-links">

        <?php $currentPage = $_GET['page'] ?? 'liste'; ?>

        <!-- Toujours visible -->
        <a href="/?page=liste">Clients</a>

        <!-- CLIENTS -->
        <?php if ($currentPage === 'liste'): ?>
            <a href="/?page=create">Ajouter client</a>
        <?php endif; ?>

        <!-- COMPTES -->
        <?php if ($currentPage === 'comptes' || $currentPage === 'create_compte'): ?>
            <a href="/?page=comptes&client_id=<?= $_GET['client_id'] ?? '' ?>">Comptes</a>
            <a href="/?page=create_compte&client_id=<?= $_GET['client_id'] ?? '' ?>">Ajouter compte</a>
        <?php endif; ?>

        <!-- TRANSACTIONS -->
        <?php if ($currentPage === 'transactions' || $currentPage === 'create_transaction'): ?>


            <a href="/?page=create_transaction&compte_id=<?= $_GET['compte_id'] ?? '' ?>&client_id=<?= $_GET['client_id'] ?? '' ?>">
                Ajouter transaction
            </a>

        <?php endif; ?>

    </div>
</nav>

<main class="container">