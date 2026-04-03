import random
from datetime import datetime, timedelta

# Configuration : adapter les IDs aux comptes créés dans data.sql
# Exemple : Compte ID 1 (Jean) et Compte ID 2 (Alice)
comptes = [
    {"id": 1, "solde": 1500.00},
    {"id": 2, "solde": 250.50}
]

transactions_sql = []
date_actuelle = datetime.now() - timedelta(days=30) # On commence il y a 30 jours

for i in range(50):
    # Sélection d'un compte au hasard
    compte = random.choice(comptes)
    
    # Choix aléatoire du type : dépôt ou retrait
    type_trans = random.choice(['depot', 'retrait'])
    
    # Montant aléatoire entre 10 et 100
    montant = round(random.uniform(10.0, 100.0), 2)
    
    # Vérification de la règle métier : pas de solde négatif
    if type_trans == 'retrait' and compte['solde'] < montant:
        type_trans = 'depot' # On force un dépôt si le retrait est impossible
    
    # Mise à jour du solde fictif pour la prochaine itération du script
    if type_trans == 'depot':
        compte['solde'] += montant
    else:
        compte['solde'] -= montant

    # Avancement de la date (entre 1 et 12 heures après la précédente)
    date_actuelle += timedelta(hours=random.randint(1, 12))
    date_str = date_actuelle.strftime('%Y-%m-%d %H:%M:%S')

    # Génération de la ligne SQL
    sql = f"INSERT INTO transactions (type, montant, date, compte_id) VALUES ('{type_trans}', {montant}, '{date_str}', {compte['id']});"
    transactions_sql.append(sql)

# Écriture dans le fichier SQL de sortie
with open('sql/transactions_generated.sql', 'w', encoding='utf-8') as f:
    f.write("-- Fichier généré automatiquement par le script Python\n")
    for ligne in transactions_sql:
        f.write(ligne + "\n")

print(f"Succès : 50 transactions générées dans sql/transactions_generated.sql")