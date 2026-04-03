-- Insertion des clients initiaux
INSERT INTO clients (nom, prenom, email, ville) VALUES
('Dupont', 'Jean', 'jean.dupont@email.com', 'Paris'),
('Martin', 'Alice', 'alice.martin@email.com', 'Lyon'),
('Bernard', 'Paul', 'paul.bernard@email.com', 'Marseille');

-- Insertion des comptes bancaires (liés aux IDs des clients ci-dessus)
-- On suppose que Jean a l'ID 1 et Alice l'ID 2
INSERT INTO comptes (numero_compte, solde, client_id) VALUES
('FR76123456789', 1500.00, 1),
('FR76987654321', 250.50, 2);  