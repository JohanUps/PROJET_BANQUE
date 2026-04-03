<?php require __DIR__ . '/../layout/header.php'; ?>

        <header class="page-header">
            <h2>Liste des Clients</h2>
        </header>

        <table class="bank-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Ville</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody id="clientTable">

                <?php if (!empty($clients)): ?>
                    <?php foreach ($clients as $client): ?>
                        <tr>
                            <td><?= $client['id'] ?></td>
                            <td><?= $client['nom'] ?></td>
                            <td><?= $client['prenom'] ?></td>
                            <td><?= $client['email'] ?></td>
                            <td><?= $client['ville'] ?></td>
                            <td>
                                <a class="btn-edit" href="/?page=edit&id=<?= $client['id'] ?>">
                                    Modifier
                                </a>

                                <a class="btn-delete" 
                                href="/?page=delete&id=<?= $client['id'] ?>" 
                                onclick="return confirm('Supprimer ce client ?')">
                                    Supprimer
                                </a>

                                <a class="btn-compte" href="/?page=comptes&client_id=<?= $client['id'] ?>">
                                    Comptes
                                </a>
                                
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">Aucun client trouvé</td>
                    </tr>
                <?php endif; ?>

            </tbody>
        </table>

    </main>

</body>
</html>