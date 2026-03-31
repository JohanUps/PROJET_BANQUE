<section class="form-container">
    <h3>Modifier un client</h3>
    
    <form action="update_client.php" method="POST" onsubmit="return validerFormulaireClient()">

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
            <input type="text" id="ville" name="ville"  placeholder="Ex: Paris">
        </div>

        <button type="submit" class="btn-save">Enregistrer les modifications</button>
    </form>
</section>