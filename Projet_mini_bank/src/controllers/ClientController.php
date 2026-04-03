<?php
require_once __DIR__ . '/../models/Client.php';

class ClientController {
    private $client;
    //Connexion a la BD au moment de la création
    public function __construct(){
        if (session_status() === PHP_SESSION_NONE) {
            session_start(); //Utile pour récupérer des messages
        }
        $db = (new Database())->getConnection();
        $this->client = new Client($db);
    }

    //Ajoute un client à la BD
    public function create(){
        //Hydratation
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $this->client->setNom($_POST['nom']);
            $this->client->setPrenom($_POST['prenom']);
            $this->client->setEmail($_POST['email']);
            $this->client->setVille($_POST['ville']);
            
            $id = $this->client->create();

            if($id){
                $_SESSION['success'] = "Client créé avec succès";
                header("Location: routeur.php?page=liste");
                exit;
            } else {
                $_SESSION['error'] = "Erreur lors de la création d'un client";
            }
        }
        require __DIR__ . '/../views/clients/create.php';
    }


    //Affiche la liste de client (avec pagination)
    public function read(){
        $page = $_GET['page'] ?? 1;
        $page = (int)$page;

        //Evite un offset négatif si $page = 0
        if($page<1){
            $page = 1;
        }

        $offset = ($page - 1) * 5;

        //Variable utiliser dans la view
        $clients = $this->client->readPagination(5,$offset);
        $total = $this->client->count();
        $totalPages = ceil($total / 5);

        require __DIR__ . '/../views/clients/list.php';
    }

    public function edit(){

        //Modicfication du client
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Vérification de l'ID
            if (!isset($_POST['id'])) {
                $_SESSION['error'] = "ID manquant";
                header("Location: page=liste");
                exit;
            }

            // Hydratation de l'objet
            $this->client->setId($_POST['id'] ?? '');
            $this->client->setNom($_POST['nom'] ?? '');
            $this->client->setPrenom($_POST['prenom'] ?? '');
            $this->client->setEmail($_POST['email'] ?? '');
            $this->client->setVille($_POST['ville'] ?? '');

            // Mise à jour
            if ($this->client->update()) {
                $_SESSION['success'] = "Client modifié avec succès";
                header("Location: page=liste");
                exit;
            } else {
                $_SESSION['error'] = "Erreur lors de la modification";
            }
        }

        //Pré-remplissage du formulaire

        //Vérification de l'ID
        if (!isset($_GET['id'])) {
            $_SESSION['error'] = "ID manquant";
            header("Location: page=liste");
            exit;
        }

        //Chargement des données
        $this->client->setId($_GET['id']);
        $data = $this->client->read();

        //Vérifie si le client existe
        if (!$data) {
            $_SESSION['error'] = "Client introuvable";
            header("Location: page=liste");
            exit;
        }

        // Affichage de la vue
        require __DIR__ . '/../views/clients/edit.php';
    }
    
    public function delete(){

        if (!isset($_GET['id'])) {
            $_SESSION['error'] = "ID manquant";
            header("Location: page=liste");
            exit;
        }

        $this->client->setId($_GET['id']);
        $this->client->delete();
        header("Location: page=liste");
        exit;
    }
}