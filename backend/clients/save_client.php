<?php

require '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //Récupération des données sans espaces inutiles
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $email = trim($_POST['email']);
    $ville = trim($_POST['ville']);

    //Vérification : aucun champs n'est vide
    if (empty($nom) || empty($prenom) || empty($email)) {
        die("Erreur : champs obligatoires manquants");
    }
    //Vérification adresse mail valide : https://www.php.net/manual/fr/filter.examples.validation.php
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Email invalide");
    }

    try {
        //Requete sécurisé(SQL INJECTION)
        $stmt = $pdo->prepare("
            INSERT INTO clients (nom, prenom, email, ville)
            VALUES (?, ?, ?, ?)
        ");

        $stmt->execute([$nom, $prenom, $email, $ville]);

        //Redirection
        header("Location: ../../frontend/index.php?page=liste");
        exit;

    } catch (PDOException $e) {

        die("Erreur SQL (save_client) : " . $e->getMessage());
    }
}