<section class="container">
    <h3>Liste des Clients</h3>
    <table class="table-bank">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Ville</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clients as $client): ?>
            <tr>
                <td><?= htmlspecialchars($client['nom']) ?></td>
                <td><?= htmlspecialchars($client['prenom']) ?></td>
                <td><?= htmlspecialchars($client['email']) ?></td>
                <td><?= htmlspecialchars($client['ville']) ?></td>
                <td>
                    <a href="index.php?action=editClient&id=<?= $client['id'] ?>" class="btn-edit">Modifier</a>
                    <a href="index.php?action=deleteClient&id=<?= $client['id'] ?>" class="btn-delete" onclick="return confirm('Supprimer ce client ?')">Supprimer</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>