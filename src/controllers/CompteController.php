<?php
require_once "config/Database.php";
require_once "models/Compte.php";

class CompteController {

    private $compte;

    public function __construct(){
        session_start();//Demarage d'une session pour envoyer des informations sur le déroulement des opérations
        $db = (new Database())->getConnection();
        $this->compte = new Compte($db);
    }

    //CREATE avec pré
    public function create(){
        //Vérification : la page indique sur le compte de quel client on travaille
        if(!isset($_GET['client_id'])){
            $_SESSION['error'] = "Client non indiqué";
            header("Location: index.php?controller=client&action=list"); //renvoie a la liste des clients
            exit;
        }

        $client_id = (int) $_GET['client_id'];

        //CREATION DU COMPTE
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $this->compte->setClientId($client_id);
            $this->compte->setSolde($_POST['solde'] ?? 0); //Sauf de 0 par defaut
        }

        $id = $this->compte->create();

        //Cas ou le compte est créé
        if($id){
            $_SESSION['success'] = "Compte créé";
            header("Location: index.php?controller=compte&action=list&client_id=".$client_id);
            exit;
        } else {
            $_SESSION['error'] = "Erreur lors de la création du compte";
        }
        require "views/comptes/create.php";
    }
    
    public function readAll(){
        if (!isset($_GET['client_id'])) {
            $_SESSION['error'] = "Client manquant";
            header("Location: index.php?controller=client&action=list");
            exit;
        }

        $client_id = (int) $_GET['client_id'];

        $comptes = $this->compte->readByClient($client_id);
        
        require "views/comptes/list.php";

    }

    public function delete(){
        if (!isset($_GET['id']) || !isset($_GET['client_id'])) {
            $_SESSION['error'] = "Paramètres manquants";
            header("Location: index.php?controller=client&action=list");
            exit;
        }

        $id = (int) $_GET['id'];
        $client_id = (int) $_GET['client_id'];

        $this->compte->setId($id);
        //DELETE peut echouer si des transactions existe
        if ($this->compte->delete()) {
            $_SESSION['success'] = "Compte supprimé";
        } else {
            $_SESSION['error'] = "Impossible de supprimer ce compte (transactions existantes)";
        }

        header("Location: index.php?controller=compte&action=list&client_id=".$client_id);
        exit;
    
    }
}