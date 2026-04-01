<?php

class Compte{

    private $pdo;
    private $table_name = "comptes";

    private $id;
    private $client_id;
    private $solde;
    private $date_creation;

    public function __construct($db)
    {
        $this->pdo = $db;
    }

    //Fonction de nettoyage des attributs
    private function clean() {
        $this->client_id = (int) $this->client_id;
        $this->solde = (float) $this->solde;
    }

    //Parametre optionnel avec valeur par defaut (on doit vérifier l'id dans update mais pas dans create)
    private function validate($checkId = false) {
    
        if ($checkId && empty($this->id)) {
            return false;
        }
        
        if(empty($this->client_id)){
            return false;
        }

        if($this->solde < 0){
            return false;
        }

        return true;
    }

    private function castId(){
        $this->id = (int) $this->id;
    }

    private function hydrate($data){
        $this->id = (int) $data['id'];
        $this->client_id = (int) $data['client_id'];
        $this->solde = (float) $data['solde'];
        $this->date_creation = $data['date_creation'];
    }

    //CRUD : CREATE
    public function create(){
        //Nettoyage des données
        $this->clean();

        if(!$this->validate()){
            return false;
        }

        //Vérification l'existence du client
        $query = "SELECT id FROM clients WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([":id" => $this->client_id]); 

        if(!$stmt->fetch()){
            return false;
        }

        //Ajout du compte a la BD
        $query = "INSERT INTO {$this->table_name} (client_id, solde) VALUES (:client_id, :solde)";
        $stmt = $this->pdo->prepare($query);
        $success = $stmt->execute([":client_id" => $this->client_id, ":solde"=>$this->solde]); 
        
        if($success){
            $this->id = (int) $this->pdo->lastInsertId();
            return $this->id;
        }
        return false;
    }

    //CRUD : READ 
    public function read(){
        //On vérifie qu'on a bien un id de compte
        if(empty($this->id)){
            return false;
        }

        //On s'assure que l'id est bien lu comme un int
        $this->castId();

        //Récupération des informations du compte
        $query = "SELECT * FROM " . $this->table_name . " 
        WHERE id = :id";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute([":id"=>$this->id]);
        //Récupération des données sous forme de tableau indexé
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if($data){
            $this->hydrate($data);
            return $data;
        }
        return false;
    }

    //Renvoie tout les comptes d'un client a partir de son id
    public function readByClient($client_id){

        $query = "SELECT * FROM {$this->table_name} WHERE client_id = :client_id ORDER BY id DESC";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute([":client_id" => (int) $client_id]); //Pas de verification un client peut ne pas avoir de compte

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //CRUD : UPDATE 
    public function update(){
        //Verifications
        $this->clean();
        if(!$this->validate(true)) {
            return false;
        }
        $this->castId();
            
        //Update du client dans la BD
        $query = "UPDATE " . $this->table_name .
        " SET solde = :solde WHERE id = :id";
        
        $stmt = $this->pdo->prepare($query);
        
        $success = $stmt->execute([":solde"=>$this->solde,":id"=>$this->id]);

        return $success;
    }


    //CRUD : DELETE
    public function delete(){

        if (empty($this->id)) {
            return false;
        }
        $this->castId();

        //DELETE non valide si il y a des transaction en cours
        $query = "SELECT COUNT(*) as total FROM transactions WHERE compte_id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([":id"=>$this->id]);

        if ($stmt->fetch(PDO::FETCH_ASSOC)['total'] > 0) {
            return false;
        }

        //DELETE
        $query = "DELETE FROM " . $this->table_name .
                " WHERE id = :id";

        $stmt = $this->pdo->prepare($query);
        $success = $stmt->execute([":id"=>$this->id]);

        return $success;
    }

    //SETTERS
    public function setId($id){ $this->id = $id; }
    public function setClientId($client_id){ $this->client_id = $client_id; }
    public function setSolde($solde){ $this->solde = $solde; }




}