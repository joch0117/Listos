# Listos – Application de gestion de tâches et de listes

Listos est une application web moderne de gestion de tableaux et de listes de tâches, pensée pour être simple, épurée et efficace.
Elle permet à chaque utilisateur de s’organiser au quotidien à travers des tableaux, des listes et des tâches, tout en offrant un espace administrateur pour la gestion des comptes.

---

## 🎯 Objectifs & fonctionnalités principales

* **Gestion de tableaux** (workspaces/boards)
* **Création de listes** dans chaque tableau
* **Ajout et suivi de tâches** (to-do) dans chaque liste
* **Inscription et connexion sécurisées** (JWT, hashing, validation forte)
* **Authentification et autorisation API** : seules les ressources de l’utilisateur sont accessibles
* **Espace administrateur** minimaliste : gestion et suppression des utilisateurs
* **Interface épurée & responsive**, charte graphique sombre avec accents verts
* **Front-end** 100% JS natif, HTML, SCSS (Sass) – pas de framework pour l’instant
* **Back-end** Symfony 7 + API Platform (CRUD auto, doc Swagger intégrée)
* **Structure modulaire** (front/back séparés, prêt à déployer avec Docker)
* **API sécurisée** (routes `/api/register` et `/api/login` publiques, tout le reste protégé)
* **Validation serveur stricte** (mot de passe fort, email unique…)

---

## ⚙️ Stack technique

- **Frontend** : SPA JS natif, HTML5, SCSS (architecture modulaire, routing hash)
- **Backend** : Symfony 7 (API Platform), LexikJWTAuthenticationBundle pour JWT, NelmioCorsBundle pour CORS
- **Database** : MariaDB (structure évolutive : User, Dashboard, TaskList, Map…)
- **Reverse proxy** : Nginx multi-conteneurs (front statique + reverse API)
- **Docker** : 4 services orchestrés (front, back, DB, reverse), prêt pour le déploiement cloud

---

## 📁 Structure du projet

projet-root/
│
├── front-end/ # Front statique (SPA)
│ ├── asset/
│ │ ├── style/ # SCSS modulaire
│ │ ├── js/ # JS (modules, routing, dropdown…)
│ │ └── image/ # Logos, icônes
│ ├── index.html
│ └── partials/
│
├── back-end/ # Back-end Symfony (API)
│ ├── (fichiers et dossiers Symfony)
│ └── Dockerfile
│
├── nginx/ # Config Nginx (front + reverse proxy)
│ ├── front.conf
│ └── reverse.conf
│
├── docker-compose.dev.yaml # Environnement Docker de développement
└── README.md

yaml
Copier
Modifier

---

## 🏗️ Architecture & Docker

L’application fonctionne avec **4 conteneurs Docker** :

* **front** : Nginx servant les fichiers statiques du front-end (port 8080, pour debug direct)
* **back** : Symfony API (PHP 8.3), connecté à la base de données MariaDB
* **db** : MariaDB
* **reverse** : Nginx reverse proxy qui sert d’entrée unique pour le front et l’API (port 80)

**Schéma de routing** :

Navigateur
|
V
\[Nginx Reverse Proxy (port 80)]
|    |
|    |
(front) (back/API)
Nginx   Symfony (8000)
SPA     MariaDB

---

## 🚀 Lancer le projet en local (dev)

Depuis la racine du projet :

```bash
docker-compose -f docker-compose.dev.yaml up --build
Front dispo sur http://localhost:8080
```
Reverse proxy (entrée unique) sur http://localhost

API Symfony sur /api/ via le reverse, ou http://localhost:8000 si le port est exposé dans le compose.

## Ce qui est déjà en place
**Authentification API sécurisée** (inscription, connexion via JWT, stockage du token côté front, validation forte)

**Sécurité API** (rôles, accès par utilisateur, CORS avec Nelmio)

**CRUD auto** sur Dashboard, TaskList, Map via API Platform, doc interactive via Swagger

**Base de données relationnelle complète** (User, Dashboard, TaskList, Map) — validation et unicité assurées

**SPA front JS natif** : routing, partials HTML, menus dynamiques, inscription & connexion fonctionnelles, gestion du token (stockage/localStorage)

**Menu responsive, structure JS modulaire**

**Scripts front prêts pour CRUD et gestion dynamique**

**Connexion BDD testée et opérationnelle** (accès via DBeaver pour vérif)

## Prochaines étapes
**Modules CRUD front** (création, édition, suppression des boards, listes, tâches)

**Améliorer l’UX** (messages globaux, gestion des erreurs, spinners, feedback)

**Gestion dynamique du menu selon état utilisateur** (connecté/non connecté, déconnexion, “Bonjour Prénom”, etc.)

**Composant message global** (success/error/info partout dans l’app)

**Finalisation du responsive, design et animations**

**Tests avancés et validation complète de la sécurité**

**Préparation au déploiement** (prod Docker ready)

## À venir / TODO
Sécurisation avancée de l’API (JWT, rôles, CORS, etc.)

Ajout d’API Platform (documentation auto, filtres…)

Modules CRUD front (Dashboard, TaskList, Map)

Améliorations UX/UI (drag & drop, menu contextuel…)

Filtres dynamiques, recherche, personnalisation

Tests unitaires/fonctionnels et validation sécurité

Déploiement cloud (Docker ready)

✍️ Auteur
Projet réalisé par [jo chaigneau], 2025.

