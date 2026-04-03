<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="page-header">
    <h2>Transactions du compte</h2>

</div>

<table class="bank-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Montant</th>
            <th>Type</th>
            <th>Date</th>
        </tr>
    </thead>

    <tbody>

        <?php if (!empty($transactions)): ?>
            <?php foreach ($transactions as $t): ?>
                <tr>
                    <td><?= $t['id'] ?></td>

                    <td class="<?= $t['type'] === 'depot' ? 'amount-positive' : 'amount-negative' ?>">
                        <?= number_format($t['montant'], 2) ?> €
                    </td>

                    <td>
                        <?= $t['type'] === 'depot' ? 'Dépôt' : 'Retrait' ?>
                    </td>

                    <td>
                        <?= $t['date'] ?? '-' ?>
                    </td>
                </tr>
            <?php endforeach; ?>

        <?php else: ?>
            <tr>
                <td colspan="4">Aucune transaction</td>
            </tr>
        <?php endif; ?>

    </tbody>
</table>

<?php require __DIR__ . '/../layout/footer.php'; ?>