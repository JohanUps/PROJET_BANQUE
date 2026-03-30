<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $compte_id = $_POST['compte_id'];
    $type = $_POST['type'];
    $montant = (float)$_POST['montant'];

    try {
        $pdo->beginTransaction();

        // 1. Récupérer le solde actuel
        $stmt = $pdo->prepare("SELECT solde FROM comptes WHERE id = ? FOR UPDATE");
        $stmt->execute([$compte_id]);
        $compte = $stmt->fetch();

        if ($type === 'retrait' && $compte['solde'] < $montant) {
            // Règle métier : retrait impossible si solde insuffisant 
            throw new Exception("Solde insuffisant pour effectuer ce retrait !");
        }

        // 2. Calculer le nouveau solde
        $nouveauSolde = ($type === 'depot') ? $compte['solde'] + $montant : $compte['solde'] - $montant;

        // 3. Mettre à jour le solde du compte [cite: 98, 101]
        $update = $pdo->prepare("UPDATE comptes SET solde = ? WHERE id = ?");
        $update->execute([$nouveauSolde, $compte_id]);

        // 4. Enregistrer la transaction dans l'historique
        $insert = $pdo->prepare("INSERT INTO transactions (type, montant, compte_id) VALUES (?, ?, ?)");
        $insert->execute([$type, $montant, $compte_id]);

        $pdo->commit();
        echo "<p style='color:green;'>Transaction réussie !</p>";
    } catch (Exception $e) {
        $pdo->rollBack();
        echo "<p style='color:red;'>Erreur : " . $e->getMessage() . "</p>";
    }
}

// Récupérer la liste des comptes pour le formulaire (avec JOIN pour le nom du titulaire [cite: 91])
$comptes = $pdo->query("SELECT comptes.id, numero_compte, nom FROM comptes JOIN clients ON comptes.client_id = clients.id")->fetchAll();
?>

<h2>Nouvelle Transaction</h2>
<form method="POST">
    <label>Choisir un compte :</label>
    <select name="compte_id" required>
        <?php foreach ($comptes as $c): ?>
            <option value="<?= $c['id'] ?>"><?= $c['numero_compte'] ?> (<?= $c['nom'] ?>)</option>
        <?php endforeach; ?>
    </select><br><br>

    <label>Type d'opération :</label>
    <select name="type">
        <option value="depot">Dépôt</option>
        <option value="retrait">Retrait</option>
    </select><br><br>

    <label>Montant :</label>
    <input type="number" step="0.01" name="montant" min="0.01" required><br><br>

    <button type="submit">Valider l'opération</button>
</form>
<a href="index.php">Retour à l'accueil</a>