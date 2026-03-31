<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>MiniBank - Tableau de Bord</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar">
        <h1>MiniBank 🏦</h1>
        <div class="nav-links">
            <a href="index.php?page=liste">Clients</a>
            <a href="index.php?page=ajouter">Nouveau Client</a>
            <a href="index.php?page=transaction">Opération</a>
        </div>
    </nav>

    <main class="container">
        <?php
        
        $page = isset($_GET['page']) ? $_GET['page'] : 'liste';

        if ($page == 'ajouter') {
            // Appelle du formulaire d'ajout
            echo "<h2>Enregistrer un nouveau client</h2>";
            include 'FORMULAIRES/add_client.php';
        } 
        elseif ($page == 'transaction') {
            // Appelle du formulaire de transaction
            echo "<h2>Effectuer un dépôt ou retrait</h2>";
            include 'FORMULAIRES/transaction.php';
        } 
        elseif($page=='modifier'){
            //Appelle du formulaire de modification
            echo "<h2>enregistrer les modification</h2>";
            include 'FORMULAIRES/edit_client.php';
        }
        elseif ($page == 'nouveau_compte') {
            //appel du formulaire compte
            echo "<h2>Ouverture de compte</h2>";
            include 'FORMULAIRES/add_compte.php';
        }
        else {
            // Affichage par défaut : La liste des clients
            ?>
            <header class="page-header">
                <h2>Liste des Clients</h2>
                <input type="text" id="searchBar" placeholder="Rechercher un client...">
            </header>
            
            <table class="bank-table">
                <thead>
                    <tr>
                        <th>ID</th><th>Nom</th><th>Email</th><th>Ville</th><th>Actions</th>
                    </tr>
                </thead>
                <tbody id="clientTable">
                    <tr>
                        <td>1</td><td>Exemple Nom</td><td>exemple@mail.com</td><td>Ville</td>
                        <td><button class="btn-delete" onclick="confirmerSuppression(1)">Supprimer</button></td>
                    </tr>
                </tbody>
            </table>
            <?php
        }
        ?>
    </main>

    <script src="script.js"></script>
</body>
</html>