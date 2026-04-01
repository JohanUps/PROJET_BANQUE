<?php
require_once "config/Database.php";
require_once "models/Transaction.php";

class TransactionController {

    private $transaction;

    public function __construct(){
        session_start();
        $db = (new Database())->getConnection();
        $this->transaction = new Transaction($db);
    }

    //CRUD : CREATE
    public function create(){

        if (!isset($_GET['compte_id'])) {
            $_SESSION['error'] = "Compte manquant";
            header("Location: index.php");
            exit;
        }

        $compte_id = (int) $_GET['compte_id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $this->transaction->setCompteId($compte_id);
            $this->transaction->setMontant($_POST['montant'] ?? 0);
            $this->transaction->setType($_POST['type'] ?? '');

            $id = $this->transaction->create();

            if ($id) {
                $_SESSION['success'] = "Transaction effectuée avec succès";
                header("Location: index.php?controller=transaction&action=list&compte_id=".$compte_id);
                exit;
            } else {
                $_SESSION['error'] = "Erreur (solde insuffisant ou données non valides)";
            }
        }

        require "views/transactions/create.php";
    }

    public function list(){

        if (!isset($_GET['compte_id'])) {
            $_SESSION['error'] = "Compte manquant";
            header("Location: index.php");
            exit;
        }

        $compte_id = (int) $_GET['compte_id'];

        $transactions = $this->transaction->readByCompte($compte_id);

        require "views/transactions/list.php";
    }
}