<?php 

require '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try{

        //Récupération de la liste des clients dans la BD
        $stmt = $pdo->query("SELECT * FROM clients"); //preparation de la requete
        $clients = $stmt->fetchAll(); //Mise sous forme de tableau

    } catch(PDOException $e){

        die("Erreur SQL (get_clients): " . $e->getMessage());
    }
}