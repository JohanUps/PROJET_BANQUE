/**
 * PARTIE 1 : FILTRE DYNAMIQUE (Recherche)
 * Objectif : Filtrer la liste des clients sans rechargement de page.
 */
const searchBar = document.getElementById('searchBar');
if (searchBar) {
    searchBar.addEventListener('keyup', function() {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll('#clientTable tr');

        rows.forEach(row => {
            // On récupère le texte de toute la ligne pour une recherche globale
            const text = row.textContent.toLowerCase();
            // Si le texte contient la recherche, on affiche, sinon on cache
            row.style.display = text.includes(filter) ? '' : 'none';
        });
    });
}


/**
 * PARTIE 2 : CONFIRMATION DE SUPPRESSION
 * Objectif : Afficher une boîte confirm() native avant toute suppression.
 * @param {number} id - L'ID du client ou du compte à supprimer
 */
 
function confirmerSuppression(id) {
    const message = "Êtes-vous sûr de vouloir supprimer cet élément ?\nCette action est irréversible.";
    
    if (confirm(message)) {
        // Si l'utilisateur clique sur OK, on redirige vers le script PHP de suppression
        // Note : Membre 2 devra créer ce fichier 'delete.php'
        window.location.href = "delete_client.php?id=" + id;
    }
}

 
 //PARTIE 3 : VALIDATION DE FORMULAIRE
 // Objectif : Vérifier les champs obligatoires (email, montant > 0) côté client
 
function validerFormulaireTransaction() {
    const montant = document.getElementById('montant').value;
    const type = document.getElementById('type_transaction').value;

    // Règle 1 : Le montant doit être un nombre positif 
    if (montant <= 0) {
        alert("Erreur : Le montant doit être supérieur à 0.");
        return false; // Bloque l'envoi du formulaire
    }

    // Règle 2 : Message de sécurité pour les gros retraits
    if (type === 'retrait' && montant > 1000) {
        return confirm("Vous allez effectuer un retrait important. Confirmer ?");
    }

    return true; // Autorise l'envoi au PHP
}