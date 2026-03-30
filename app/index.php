<?php
require 'db.php';

$stmt = $pdo->query("SELECT * FROM clients");
$clients = $stmt->fetchAll();
?>

<h1>Liste des Clients</h1>
<table border="1">
    <tr>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Email</th>
        <th>Ville</th>
    </tr>
    <?php foreach ($clients as $client): ?>
    <tr>
        <td><?= htmlspecialchars($client['nom']) ?></td>
        <td><?= htmlspecialchars($client['prenom']) ?></td>
        <td><?= htmlspecialchars($client['email']) ?></td>
        <td><?= htmlspecialchars($client['ville']) ?></td>
    </tr>
    <?php endforeach; ?>
</table>
<th>Actions</th>

<td>
    <a href="edit_client.php?id=<?= $client['id'] ?>">Modifier</a> | 
    <a href="delete_client.php?id=<?= $client['id'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce client ?')">Supprimer</a>
    <a href="add_client.php" style="padding: 10px; background: blue; color: white; text-decoration: none;">+ Ajouter un client</a>
</td>


<script>
document.querySelector('form').addEventListener('submit', function(e) {
    const email = document.querySelector('input[name="email"]').value;
    if (!email.includes('@')) {
        alert("Veuillez entrer une adresse email valide.");
        e.preventDefault(); // Bloque l'envoi du formulaire
    }
});
</script>