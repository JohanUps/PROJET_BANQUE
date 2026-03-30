<?php
require 'db.php';
$transactions = $pdo->query("SELECT t.*, c.numero_compte FROM transactions t JOIN comptes c ON t.compte_id = c.id ORDER BY t.date DESC")->fetchAll();
?>
<h2>Historique Global</h2>
<table border="1">
    <tr><th>Date</th><th>Compte</th><th>Type</th><th>Montant</th></tr>
    <?php foreach ($transactions as $t): ?>
    <tr>
        <td><?= $t['date'] ?></td>
        <td><?= $t['numero_compte'] ?></td>
        <td style="color: <?= $t['type'] == 'depot' ? 'green' : 'red' ?>"><?= ucfirst($t['type']) ?></td>
        <td><?= number_format($t['montant'], 2) ?> €</td>
    </tr>
    <?php endforeach; ?>
</table>