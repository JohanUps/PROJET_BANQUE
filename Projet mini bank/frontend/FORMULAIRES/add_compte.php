<section class="form-container">
    <h3>Creer un compte bancaire</h3>
    
    <form action="save_compte.php" method="POST">
        <div class="form-group">
            <label for="client">Choisir le client :</label>
            <select name="id_client" id="client" required>
                <option value="">-- Sélectionner un client --</option>
                <option value="1">Exemple : Jean Dupont</option>
            </select>
        </div>

        <div class="form-group">
            <label for="solde">Solde initial (€) :</label>
            <input type="number" id="solde" name="solde_initial" step="0.01" min="0" required placeholder="0.00">
        </div>

        <button type="submit" class="btn-save">Créer le compte</button>
    </form>
</section>