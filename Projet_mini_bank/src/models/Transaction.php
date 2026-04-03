<?php
require_once __DIR__ . "/../config/Database.php";

class Transaction{
    private $pdo;
    private $table_name = "transactions";

    private $id;
    private $compte_id;
    private $montant;
    private $type;
    private $date;


    public function __construct($db){
        $this->pdo = $db;
    }

    private function clean(){
        $this->compte_id = (int) $this->compte_id;
        $this->montant = (float) $this->montant;
        $this->type = trim($this->type);
    }

    private function validate(){

        if (empty($this->compte_id)) {
            return false;
        }

        if ($this->montant <= 0) {
            return false;
        }

        if (!in_array($this->type, ['depot', 'retrait'])) {
            return false;
        }

        return true;
    }

    //Fonctions pratique manipuler les données du compte lié
    private function getSolde(){

        $stmt = $this->pdo->prepare("SELECT solde FROM comptes WHERE id = :id");
        $stmt->execute([":id" => $this->compte_id]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data ? (float)$data['solde'] : false;
    }

    private function updateSolde($nouveauSolde){

        $stmt = $this->pdo->prepare("UPDATE comptes SET solde = :solde WHERE id = :id");

        return $stmt->execute([":solde" => $nouveauSolde, ":id" => $this->compte_id]);
    }

    //CRUD : CREATE
    public function create(){

        $this->clean();
        if(!$this->validate(true)){
            return false;
        }

        try{
            $this->pdo->beginTransaction();

            $soldeActuel = $this->getSolde();

            if($soldeActuel === false){ //Pas !soldeActuel car 0 serait considéré comme faux
                $this->pdo->rollBack();
                return false;
            }

            //Gestion des retrait
            if($this->type === 'retrait'){
                //Cas ou le retrait est supérieur au solde(erreur)
                if($soldeActuel < $this->montant){
                    $this->pdo->rollBack();
                    return false;
                }
                $nouveauSolde = $soldeActuel - $this->montant;
            //Gestion depot
            } else {
                $nouveauSolde = $soldeActuel + $this->montant;
            }

            //Insertion dans la BD
            $query = "INSERT INTO {$this->table_name} (compte_id, montant, type)
                      VALUES (:compte_id, :montant, :type)";
            $stmt = $this->pdo->prepare($query);

            $success = $stmt->execute([":compte_id"=>$this->compte_id, ":montant"=>$this->montant, ":type"=>$this->type]);

            if (!$success) {
                $this->pdo->rollBack();
                return false;
            }

            if (!$this->updateSolde($nouveauSolde)) {
                $this->pdo->rollBack();
                return false;
            }

            $this->pdo->commit();

            $this->id = (int) $this->pdo->lastInsertId();

            return $this->id;

        } catch (Exception $e) {
            $this->pdo->rollBack();
            return false;
        }
    }

    //
    public function readByCompte($compte_id){

        $query = "SELECT * FROM {$this->table_name} WHERE compte_id = :compte_id ORDER BY date DESC";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute([":compte_id" => (int)$compte_id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 🔧 SETTERS
    public function setCompteId($id){ $this->compte_id = $id; }
    public function setMontant($montant){ $this->montant = $montant; }
    public function setType($type){ $this->type = $type; }
}