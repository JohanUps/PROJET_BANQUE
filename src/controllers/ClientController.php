<?php
require_once "config/Database.php";
require_once "models/Client.php";


class ClientController {
    private $client;
    //Connexion a la BD au moment de la création
    public function __construct(){
        session_start(); //Utile pour récupérer des messages
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
                header("Location: index.php?controller=client&action=list");
                exit;
            } else {
                $_SESSION['error'] = "Erreur lors de la création d'un client";
            }
        }
        require "views/clients/create.php";
    }


    //Affiche la liste de client (avec pagination)
    public function read(){
        $page = $_GET['page'] ?? 1;
        $page = (int)$page;

        $offset = ($page - 1) * 5;

        //Variable utiliser dans la view
        $clients = $this->client->readPagination(5,$offset);
        $total = $this->client->count();
        $totalPages = ceil($total / 5);

        require "views/clients/list.php";
    }

    public function edit(){

        //Modicfication du client
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Vérification de l'ID
            if (!isset($_POST['id'])) {
                $_SESSION['error'] = "ID manquant";
                header("Location: index.php?controller=client&action=list");
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
                header("Location: index.php?controller=client&action=list");
                exit;
            } else {
                $_SESSION['error'] = "Erreur lors de la modification";
            }
        }

        //Pré-remplissage du formulaire

        //Vérification de l'ID
        if (!isset($_GET['id'])) {
            $_SESSION['error'] = "ID manquant";
            header("Location: index.php?controller=client&action=list");
            exit;
        }

        //Chargement des données
        $this->client->setId($_GET['id']);
        $data = $this->client->read();

        //Vérifie si le client existe
        if (!$data) {
            $_SESSION['error'] = "Client introuvable";
            header("Location: index.php?controller=client&action=list");
            exit;
        }

        // Affichage de la vue
        require "views/clients/edit.php";
    }
    
    public function delete(){

        if (!isset($_GET['id'])) {
            $_SESSION['error'] = "ID manquant";
            header("Location: index.php?controller=client&action=list");
            exit;
        }

        $this->client->setId($_GET['id']);
        $this->client->delete();
        header("Location: index.php?controller=client&action=list");
        exit;
    }


}