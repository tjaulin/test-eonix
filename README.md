# **API de Gestion des Personnes**

Une API permettant de gérer des entités "Personne" avec des fonctionnalités telles que la création, la modification, la suppression, et la recherche filtrée.

## **Pourquoi ces implémentations ?**

- **Laravel** : Choisi pour sa structure bien définie, sa facilité d'utilisation, et sa prise en charge native des fonctionnalités essentielles comme la validation, les migrations, et les tests.
- **Migrations** : Assurent la versioning et la reproductibilité des modifications de la base de données, facilitant le déploiement sur différents environnements.
- **Seeders** : Utilisés pour nourrir la base de données avec des données fictives en vue de tester ou de démontrer l'application.
- **Tests unitaires** : Garantissent que les fonctionnalités principales fonctionnent correctement et permettent de prévenir les régressions.
- **Factory** : Génère rapidement des données fictives réalistes pour les tests ou le peuplement de la base.

---

## **Installation du Projet**

### **1. Pré-requis**
- **PHP >= 8.0**
- **Composer**
- **SQLite**

### **2. Cloner le projet**
```bash
git clone https://github.com/tjaulin/test-eonix.git
cd test-eonix
```

### **3. Installer les dépendances**
```
composer install
```

### **4. Configurer l'environnement**
Copie le fichier ".env.example" et renomme le en ".env"
```
cp .env.example .env
```

### **5. Lancer les migrations**
```
php artisan migrate
```

### **6. Nourrir la base avec des données fictives**
```
php artisan db:seed --class=PeopleSeeder
```

### **7. Démarrer le serveur local**
```
php artisan serve
```

Le serveur sera accessible à l'adresse: "http://localhost:8000"

<big>**Vous pouvez maintenant tester l'API via des outils comme Postman, en envoyant des requêtes à l'adresse "http://localhost:8000/api/people".**</big>

### **8. Lancer les tests unitaires**
**ATTENTION !** : Si vous lancez les tests unitaires, cela effacera la base de données et il faudra relancer le seeder (`php artisan db:seed --class=PeopleSeeder`) pour la nourrir à nouveau.
```
php artisan test --filter PeopleControllerTest
```

---
## **Utilisation de l'API**

### **Endpoints principaux**

| Methode | Endpoint | Description |
| --- | --- | --- |
| GET | /api/people | Récupère la liste de toutes les personnes |
| GET | /api/people/{id} | Récupère une personne par son ID |
| GET | /api/people?last_name=valeur | Recherche par nom.
| POST | /api/people | Crée une personne |
| PUT | /api/people/{id} | Met à jour une personne par son ID |
| DELETE | /api/people/{id} | Supprime une personne par son ID |
