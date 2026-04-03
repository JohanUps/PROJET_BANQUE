<?php
require_once __DIR__ . "/../config/Database.php";
require_once __DIR__ . "/../models/Transaction.php";

class TransactionController {

    private $transaction;

    public function __construct(){
        session_start();
        $db = (new Database())->getConnection();
        $this->transaction = new Transaction($db);
    }

    // ======================
    // CREATE
    // ======================
    public function create(){

        if (!isset($_GET['compte_id'])) {
            $_SESSION['error'] = "Compte manquant";
            header("Location: page=liste");
            exit;
        }

        $compte_id = (int) $_GET['compte_id'];
        $client_id = $_GET['client_id'] ?? '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $this->transaction->setCompteId($compte_id);
            $this->transaction->setMontant($_POST['montant'] ?? 0);
            $this->transaction->setType($_POST['type'] ?? '');

            $id = $this->transaction->create();

            if ($id) {
                $_SESSION['success'] = "Transaction effectuée avec succès";

                //header("Location: page=transactions&compte_id=".$compte_id."&client_id=".$client_id);
                //exit;
                die("REDIRECTION ICI");
            } else {
                $_SESSION['error'] = "Erreur (solde insuffisant ou données non valides)";
            }
        }

        require __DIR__ . "/../views/transactions/create.php";
    }

    // ======================
    // LIST
    // ======================
    public function list(){

        if (!isset($_GET['compte_id'])) {
            $_SESSION['error'] = "Compte manquant";
            header("Location: page=liste");
            exit;
        }

        $compte_id = (int) $_GET['compte_id'];

        $transactions = $this->transaction->readByCompte($compte_id);

        require __DIR__ . "/../views/transactions/list.php";
    }
}