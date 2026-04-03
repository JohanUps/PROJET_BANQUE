<?php
require_once __DIR__ . '/../config/Database.php'; //Connexion à la BD

class Client{
    //
    private $pdo;
    private $table_name = "clients";
    private $id;
    private $nom;
    private $prenom;
    private $email;
    private $ville;

    public function __construct($db)
    {
        if (!$db) {
            die("DB non initialisée dans Client");
        }
        $this->pdo = $db;
    }
    //Fonction de nettoyage des attributs
    private function clean() {
    $this->nom = trim($this->nom);
    $this->prenom = trim($this->prenom);
    $this->email = trim($this->email);
    $this->ville = trim($this->ville);
    }

    //Parametre optionnel avec valeur par defaut (on doit vérifier l'id dans update mais pas dans create)
    private function validate($checkId = false) {

        if (empty($this->nom) || empty($this->prenom) || empty($this->email) || empty($this->ville)) {
            return false;
        }

        if ($checkId && empty($this->id)) {
            return false;
        }

        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        return true;
    }

    private function castId(){
        $this->id = (int) $this->id;
    }

    private function hydrate($data){
        $this->id = (int) $data['id'];
        $this->nom = $data['nom'];
        $this->prenom = $data['prenom'];
        $this->email = $data['email'];
        $this->ville = $data['ville'];
    }

    //CRUD : CREATE
    public function create(){
        //Nettoyage des variables(Peut également être placé dans le controller)
        $this->clean();

        if(!$this->validate()) {
            return false;
        }

        //Ajout du client dans la BD
        $query = "INSERT INTO " . $this->table_name . " (nom, prenom, email, ville)
        VALUES (:nom, :prenom, :email, :ville)";

        $stmt = $this->pdo->prepare($query);

        $success = $stmt->execute([":nom" => $this->nom, ":prenom" => $this->prenom,":email" => $this->email,":ville" => $this->ville]);
        
        //Important récupérer l'id juste après l'insertion pour ne pas avoir à le chercher plus tard et l'envoyer au controller
        if($success){
            $this->id = (int) $this->pdo->lastInsertId();
            return $this->id;
        }

        return false;
    }

    //CRUD : READ
    public function read(){

        if (empty($this->id)) {
            return false;
        }

        $this->castId();

        $query = "SELECT * FROM " . $this->table_name . 
        " WHERE id = :id";

        $stmt = $this->pdo->prepare($query);

        $stmt->execute([":id" => $this->id]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        //Hydratation
        if ($data) {
            $this->hydrate($data);
        }

        return $data;
        
    }

    //readAll et count : Fonctions pour la pagination
    public function readPagination($limit, $offset){

        $query = "SELECT * FROM " . $this->table_name . "
                ORDER BY id DESC
                LIMIT :limit OFFSET :offset";

        $stmt = $this->pdo->prepare($query);

        $stmt->bindValue(":limit", (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(":offset", (int)$offset, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function count(){

        $query = "SELECT COUNT(*) as total FROM " . $this->table_name;

        $stmt = $this->pdo->prepare($query);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return (int)$result['total'];
    }

    
    //CRUD : UPDATE
    public function update(){
        $this->clean();
        
        if(!$this->validate(true)) {
            return false;
        }

        $this->castId();
            
        //Update du client dans la BD
        $query = "UPDATE " . $this->table_name .
        " SET nom = :nom, prenom = :prenom, email = :email, ville = :ville
        WHERE id = :id";
        
        $stmt = $this->pdo->prepare($query);
        
        $success = $stmt->execute([":nom" => $this->nom, ":prenom" => $this->prenom,":email" => $this->email,":ville" => $this->ville,":id"=>$this->id]);
        
        return $success;
        
    }
            
    //CRUD : DELETE
    public function delete(){

        if (empty($this->id)) {
            return false;
        }

        $this->castId();

        $query = "DELETE FROM " . $this->table_name .
                " WHERE id = :id";

        $stmt = $this->pdo->prepare($query);
        $success = $stmt->execute([":id"=>$this->id]);

        return $success;
    }

    //SETTERS
    public function setId($id){ $this->id = $id; }
    public function setNom($nom){ $this->nom = $nom; }
    public function setPrenom($prenom){ $this->prenom = $prenom; }
    public function setEmail($email){ $this->email = $email; }
    public function setVille($ville){ $this->ville = $ville; }
}


    