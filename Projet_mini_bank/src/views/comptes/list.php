<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="page-header">
    <h2>Comptes du client</h2>
</div>

<table class="bank-table">
    <thead>
        <tr>
            <th>Numéro de compte</th> 
            <th>Solde</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>

        <?php if (!empty($comptes)): ?>
            <?php foreach ($comptes as $compte): ?>
                <tr>
                    <td><?= htmlspecialchars($compte['numero_compte']) ?></td>
                    <td><?= number_format($compte['solde'], 2) ?> €</td>

                   <td>
                        <!-- Voir transactions -->
                        <a href="?page=transactions&compte_id=<?= $compte['id'] ?>&client_id=<?= $_GET['client_id'] ?>">
                            Transactions
                        </a>

                        <!-- Supprimer -->
                        <a class="btn-delete"
                        href="?page=delete_compte&id=<?= $compte['id'] ?>&client_id=<?= $_GET['client_id'] ?>"
                        onclick="return confirm('Supprimer ce compte ?')">
                            Supprimer
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>

        <?php else: ?>
            <tr>
                <td colspan="3">Aucun compte trouvé</td>
            </tr>
        <?php endif; ?>

    </tbody>
</table>

<?php require __DIR__ . '/../layout/footer.php'; ?>