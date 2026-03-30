<?php
require 'db.php';

// Requête avec JOIN pour lier les comptes aux noms des clients
$sql = "SELECT comptes.*, clients.nom, clients.prenom 
        FROM comptes 
        JOIN clients ON comptes.client_id = clients.id";

$stmt = $pdo->query($sql);
$comptes = $stmt->fetchAll();
?>

<h1>Liste des Comptes Bancaires</h1>
<table border="1">
    <tr>
        <th>Numéro de Compte</th>
        <th>Solde</th>
        <th>Titulaire</th>
    </tr>
    <?php foreach ($comptes as $compte): ?>
    <tr>
        <td><?= htmlspecialchars($compte['numero_compte']) ?></td>
        <td><?= htmlspecialchars($compte['solde']) ?> €</td>
        <td><?= htmlspecialchars($compte['prenom'] . ' ' . $compte['nom']) ?></td>
    </tr>
    <?php endforeach; ?>
</table>
<br>
<a href="index.php">Voir la liste des clients</a>