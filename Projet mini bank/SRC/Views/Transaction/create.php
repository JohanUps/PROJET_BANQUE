<section class="form-container">
    <h3>Effectuer une transaction</h3>
    <form action="index.php?action=saveTransaction" method="POST">
        <div class="form-group">
            <label for="id_compte">Compte :</label>
            <select name="id_compte" id="id_compte" required>
                <?php foreach ($comptes as $compte): ?>
                    <option value="<?= $compte['id'] ?>">
                        Compte n°<?= $compte['id'] ?> (<?= htmlspecialchars($compte['nom_client']) ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="type">Opération :</label>
            <select name="type" id="type">
                <option value="depot">Dépôt (+)</option>
                <option value="retrait">Retrait (-)</option>
            </select>
        </div>
        <div class="form-group">
            <label for="montant">Montant (€) :</label>
            <input type="number" id="montant" name="montant" step="0.01" min="0.01" required>
        </div>
        <button type="submit" class="btn-save">Valider la transaction</button>
    </form>
</section>