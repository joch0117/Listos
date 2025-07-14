# Listos – Application de gestion de tâches et de listes

Listos est une application web moderne de gestion de tableaux et de listes de tâches, pensée pour être simple, épurée et efficace.
Elle permet à chaque utilisateur de s’organiser au quotidien à travers des tableaux, des listes et des tâches, tout en offrant un espace administrateur pour la gestion des comptes.

---

## 🎯 Objectifs & fonctionnalités principales

* **Gestion de tableaux** (workspaces/boards)
* **Création de listes** dans chaque tableau
* **Ajout et suivi de tâches** (to-do) dans chaque liste
* **Inscription et connexion sécurisées**
* **Espace administrateur** minimaliste : gestion et suppression des utilisateurs
* **Interface épurée & responsive**, charte graphique sombre avec accents verts
* **Front-end** 100% JS natif, HTML, SCSS (Sass) – pas de framework pour l’instant
* **Back-end** Symfony 7 (API REST prévue)
* **Structure modulaire** (front/back séparés, prêt à déployer avec Docker)

---

## 📁 Structure du projet

```
projet-root/
│
├── front-end/ # Front statique (SPA)
│   ├── asset/
│   │   ├── style/ # SCSS modulaire
│   │   ├── js/    # JS (modules, routing, dropdown…)
│   │   └── image/ # Logos, icônes
│   ├── index.html
│   └── partials/
│
├── back-end/ # Back-end Symfony (API)
│   ├── (fichiers et dossiers Symfony)
│   └── Dockerfile
│
├── nginx/ # Config Nginx (front + reverse proxy)
│   ├── front.conf
│   └── reverse.conf
│
├── docker-compose.dev.yaml # Environnement Docker de développement
└── README.md
```

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
\|    |
\|    |
(front) (back/API)
Nginx   Symfony (8000)
SPA     MariaDB

---

## 🚀 Lancer le projet en local (dev)

Depuis la racine du projet :

```bash
docker-compose -f docker-compose.dev.yaml up --build
```

* Front dispo sur [http://localhost:8080](http://localhost:8080)
* Reverse proxy (entrée unique) sur [http://localhost](http://localhost)
* API Symfony sur /api/ via le reverse, ou [http://localhost:8000](http://localhost:8000) si le port est exposé dans le compose.

---

## 📚 À venir / TODO

* Sécurisation avancée de l’API (JWT, rôles)
* Ajout d’API Platform (documentation auto, filtres…)
* Améliorations UX/UI (drag & drop, menu contextuel…)
* Filtres dynamiques, recherche
* Tests unitaires/fonctionnels
* Déploiement cloud (Docker ready)

---

## ✍️ Auteur

Projet réalisé par \[jo chaigneau], 2025.

