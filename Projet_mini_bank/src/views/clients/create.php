<?php require __DIR__ . '/../layout/header.php'; ?>
<section class="form-container">
    <h3>Ajouter un nouveau client</h3>
    <form action="/?page=create" method="POST" onsubmit="return validerFormulaireClient()">
        <div class="form-group">
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" required placeholder="Ex: Dupont">
        </div>
        
        <div class="form-group">
            <label for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="prenom" required placeholder="Ex: Jean">
        </div>

        <div class="form-group">
            <label for="email">Email :</label>
            <input type="email" id="email" name="email" required placeholder="jean.dupont@email.com">
        </div>

        <div class="form-group">
            <label for="ville">Ville :</label>
            <input type="text" id="ville" name="ville" placeholder="Ex: Paris">
        </div>

        <button type="submit" class="btn-save">Enregistrer le client</button>
    </form>
</section>
<?php require __DIR__ . '/../layout/footer.php'; ?>

