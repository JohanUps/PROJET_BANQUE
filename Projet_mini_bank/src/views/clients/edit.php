<?php require __DIR__ . '/../layout/header.php'; ?>

<section class="form-container">
    <h3>Modifier le profil client</h3>

    <form action="/?page=edit" method="POST">
        <input type="hidden" name="id" value="<?= $data['id'] ?>">

        <div class="form-group">
            <label>Nom :</label>
            <input type="text" name="nom" value="<?= htmlspecialchars($data['nom']) ?>" required>
        </div>

        <div class="form-group">
            <label>Prénom :</label>
            <input type="text" name="prenom" value="<?= htmlspecialchars($data['prenom']) ?>" required>
        </div>

        <div class="form-group">
            <label>Email :</label>
            <input type="email" name="email" value="<?= htmlspecialchars($data['email']) ?>" required>
        </div>

        <div class="form-group">
            <label>Ville :</label>
            <input type="text" name="ville" value="<?= htmlspecialchars($data['ville']) ?>" required>
        </div>

        <button type="submit" class="btn-save">Mettre à jour le client</button>
    </form>
</section>

<?php require __DIR__ . '/../layout/footer.php'; ?>