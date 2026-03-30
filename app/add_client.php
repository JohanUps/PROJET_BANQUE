<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $ville = $_POST['ville'];

    $sql = "INSERT INTO clients (nom, prenom, email, ville) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    
    try {
        $stmt->execute([$nom, $prenom, $email, $ville]);
        header("Location: index.php"); // Redirige vers la liste après l'ajout
        exit();
    } catch (PDOException $e) {
        echo "Erreur lors de l'ajout : " . $e->getMessage();
    }
}
?>

<h2>Ajouter un nouveau client</h2>
<form method="POST">
    <input type="text" name="nom" placeholder="Nom" required><br>
    <input type="text" name="prenom" placeholder="Prénom" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="text" name="ville" placeholder="Ville"><br>
    <button type="submit">Enregistrer</button>
</form>
<a href="index.php">Retour à la liste</a>

<script>
document.querySelector('form').addEventListener('submit', function(e) {
    const email = document.querySelector('input[name="email"]').value;
    if (!email.includes('@')) {
        alert("Veuillez entrer une adresse email valide.");
        e.preventDefault(); // Bloque l'envoi du formulaire
    }
});
</script>