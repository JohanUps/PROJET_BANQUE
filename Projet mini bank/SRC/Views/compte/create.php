<section class="form-container">
    <h3>Ouvrir un nouveau compte</h3>
    <form action="index.php?action=saveCompte" method="POST">
        <div class="form-group">
            <label for="id_client">Propriétaire :</label>
            <select name="id_client" id="id_client" required>
                <option value="">-- Sélectionner le client --</option>
                <?php foreach ($clients as $c): ?>
                    <option value="<?= $c['id'] ?>">
                        <?= htmlspecialchars($c['nom']) ?> <?= htmlspecialchars($c['prenom']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="solde">Solde initial (€) :</label>
            <input type="number" id="solde" name="solde" step="0.01" min="0" required>
        </div>
        <button type="submit" class="btn-save">Créer le compte</button>
    </form>
</section>