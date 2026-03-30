-- Suppression des tables si elles existent pour pouvoir réimporter proprement
DROP TABLE IF EXISTS transactions;
DROP TABLE IF EXISTS comptes;
DROP TABLE IF EXISTS clients;

-- 1. Table des clients
CREATE TABLE clients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    ville VARCHAR(100),
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. Table des comptes bancaires
CREATE TABLE comptes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    numero_compte VARCHAR(20) UNIQUE NOT NULL,
    solde DECIMAL(10,2) DEFAULT 0.00,
    client_id INT NOT NULL,
    CONSTRAINT fk_client FOREIGN KEY (client_id) REFERENCES clients(id) ON DELETE CASCADE
);

-- 3. Table des transactions
CREATE TABLE transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    type ENUM('depot', 'retrait') NOT NULL,
    montant DECIMAL(10,2) NOT NULL,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    compte_id INT NOT NULL,
    CONSTRAINT fk_compte FOREIGN KEY (compte_id) REFERENCES comptes(id) ON DELETE CASCADE
);