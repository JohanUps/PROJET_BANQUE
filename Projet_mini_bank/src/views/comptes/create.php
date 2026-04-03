<?php require __DIR__ . '/../layout/header.php'; ?>

<section class="form-container">
    <h3>Ouvrir un nouveau compte</h3>

    <form action="/?page=create_compte&client_id=<?= $_GET['client_id'] ?>" method="POST">

        <input type="hidden" name="id_client" value="<?= $_GET['client_id'] ?>">

        <div class="form-group">
            <label for="solde">Solde initial (€) :</label>
            <input type="number" id="solde" name="solde" step="0.01" min="0" required>
        </div>

        <button type="submit" class="btn-save">Créer le compte</button>
    </form>
</section>

<?php require __DIR__ . '/../layout/footer.php'; ?>