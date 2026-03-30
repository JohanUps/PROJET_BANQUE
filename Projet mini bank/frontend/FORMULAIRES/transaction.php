<section class="form-container">
    <h3>Effectuer une opération</h3>
    <form action="process_transaction.php" method="POST" onsubmit="return validerFormulaireTransaction()">
        <div class="form-group">
            <label for="compte_id">Compte concerné :</label>
            <select name="compte_id" id="compte_id" required>
                <option value="1">Compte FR76... (Jean Dupont)</option>
            </select>
        </div>

        <div class="form-group">
            <label for="type_transaction">Type d'opération :</label>
            <select name="type" id="type_transaction" required>
                <option value="depot">Dépôt</option>
                <option value="retrait">Retrait</option>
            </select>
        </div>

        <div class="form-group">
            <label for="montant">Montant (€) :</label>
            <input type="number" step="0.01" id="montant" name="montant" required min="0.01">
        </div>

        <button type="submit" class="btn-transaction">Confirmer l'opération</button>
    </form>
</section>