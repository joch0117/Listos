# Listos – Application de gestion de tâches et de listes

Listos est une application web moderne de gestion de tableaux et de listes de tâches, pensée pour être simple, épurée et efficace.  
Elle permet à chaque utilisateur de s’organiser au quotidien à travers des tableaux, des listes et des tâches, tout en offrant un espace administrateur pour la gestion des comptes.

---

## 🎯 Objectifs & fonctionnalités principales

- **Gestion de tableaux** (workspaces/boards)
- **Création de listes** dans chaque tableau
- **Ajout et suivi de tâches** (to-do) dans chaque liste
- **Inscription et connexion sécurisées**
- **Espace administrateur** minimaliste : gestion et suppression des utilisateurs
- **Interface épurée & responsive**, charte graphique sombre avec accents verts
- **Front-end** 100% JS natif, HTML, SCSS (Sass) – pas de framework pour l’instant
- **Back-end** Symfony 6/7 (API REST prévue)
- **Structure modulaire** (front/back séparés, prêt à déployer avec Docker)

---

## 📁 Structure du projet

projet-root/
│
├── front-end/
│ ├── asset/
│ │ ├── style/ # SCSS modulaire
│ │ ├── js/ # Modules JS (dropdown, CRUD, etc.)
│ │ └── image/ # Logos, icônes
│ ├── index.html
│ ├── dashboard.html
│ ├── register.html
│ └── ...
│
├── back/ # Symfony (API, entités, logique métier)
│
├── nginx/ # Config Nginx (front ou reverse proxy)
│ └── default.conf
│
├── docker-compose.dev.yml # Environnement Docker de développement
└── README.md


