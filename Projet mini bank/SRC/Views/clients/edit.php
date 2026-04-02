<section class="form-container">
    <h3>Modifier le profil client</h3>
    <form action="index.php?action=updateClient" method="POST">
        <input type="hidden" name="id" value="<?= $client['id'] ?>">

        <div class="form-group">
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($client['nom']) ?>" required>
        </div>
        <div class="form-group">
            <label for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="prenom" value="<?= htmlspecialchars($client['prenom']) ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email :</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($client['email']) ?>" required>
        </div>
        <div class="form-group">
            <label for="ville">Ville :</label>
            <input type="text" id="ville" name="ville" value="<?= htmlspecialchars($client['ville']) ?>" required>
        </div>
        <button type="submit" class="btn-save">Mettre à jour le client</button>
    </form>
</section>