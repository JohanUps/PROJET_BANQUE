<?php require __DIR__ . '/../layout/header.php'; ?>

<section class="form-container">
    <h3>Effectuer une transaction</h3>

    <form action="?page=create_transaction&compte_id=<?= $_GET['compte_id'] ?>&client_id=<?= $_GET['client_id'] ?>" method="POST">

        <!-- Contexte -->
        <input type="hidden" name="compte_id" value="<?= $_GET['compte_id'] ?>">
        <input type="hidden" name="client_id" value="<?= $_GET['client_id'] ?>">

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

<?php require __DIR__ . '/../layout/footer.php'; ?>