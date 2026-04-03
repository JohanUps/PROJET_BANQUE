<?php
require_once __DIR__ . '/../models/Compte.php';

class CompteController {

    private $compte;

    public function __construct(){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();//Demarage d'une session pour envoyer des informations sur le déroulement des opérations
        }
        $db = (new Database())->getConnection();
        $this->compte = new Compte($db);
    }

    //CREATE avec pré
    public function create(){

    if(!isset($_GET['client_id'])){
        $_SESSION['error'] = "Client non indiqué";
        header("Location: page=liste");
        exit;
    }

    $client_id = (int) $_GET['client_id'];

    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        $this->compte->setClientId($client_id);
        $this->compte->setSolde($_POST['solde'] ?? 0);

        $id = $this->compte->create();

        if($id){
            $_SESSION['success'] = "Compte créé";
            header("Location: page=comptes&client_id=".$client_id);
            exit;
        } else {
            $_SESSION['error'] = "Erreur lors de la création du compte";
        }
    }

    require __DIR__ . '/../views/comptes/create.php';
}
    
    public function read(){
        if (!isset($_GET['client_id'])) {
            $_SESSION['error'] = "Client manquant";
            header("Location: page=liste");
            exit;
        }
        $page = $_GET['page'] ?? 'comptes';

        $client_id = (int) $_GET['client_id'];

        $comptes = $this->compte->readByClient($client_id);
        
        require __DIR__ . '/../views/comptes/list.php';

    }

    public function delete(){
        if (!isset($_GET['id']) || !isset($_GET['client_id'])) {
            $_SESSION['error'] = "Paramètres manquants";
            header("Location: page=liste");
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

        header("Location: page=comptes&client_id=".$client_id);
        exit;
    
    }
}