# CARNET — Glitters (thème WordPress, v1)

> Carnet de bord partagé entre Grok Bot et DeepSeek Harness. Avant de travailler : lire ce carnet. Après : le mettre à jour (section Journal + Prochaines étapes). Un seul capitaine à la fois : noter dans « Qui tient la barre » qui travaille.

## 1. Objectif du projet

Site du salon de beauté féminin **Glitters** (Санкт-Петербург, ул. Правды, 16), entièrement en russe, sous forme de thème WordPress. Détails d'installation, SEO local, réservation et plugins : `README.md`.

## 2. Stack et commandes utiles

- Thème WordPress classique (PHP 7.4+) : `wp-content/themes/glitters`. Pas d'Elementor (choix du README).
- Aperçu sans WordPress : ouvrir `preview/index.html` dans un navigateur.
- Installation : copier `wp-content/themes/glitters` dans le site WordPress, ou zipper le dossier `glitters` et l'envoyer via Apparence → Thèmes.
- Pas de build ni de tests automatiques trouvés.
- Dépôt distant : https://github.com/dariusf637/glitters (branche `cursor/glitters-salon-theme`).

## 3. État actuel (au 2026-10-24)

- 2 commits (16/10/2026) : thème avec les vraies photos et la vidéo du salon, puis « prepare the salon site for a real launch » (accueil éditable dans WordPress, mode jour / nuit, menu mobile, durcissement sécurité).
- Non suivis par Git : `.cursor/` et `wp-content/themes/glitters.zip`.
- Ce dépôt semble être la première version du site Glitters ; les versions suivantes sont dans `Glitters2` (thème qui reprend le site Astro) et `Glitters_Astro`. Laquelle est la version active : à confirmer par Darius.

## 4. Décisions importantes

(Trouvées dans le README.)

- Pas d'Elementor : la page est déjà composée et plus légère.
- Aucun prix, nom de maître ou avis inventé : prix « уточняется при записи » tant que vide, avis réels seulement.
- Réservation : Яндекс et Dikidi (`https://dikidi.net/ru/2119020?p=0.pi-po`), nouvel onglet.
- SEO local sans plugin (title, description, JSON-LD `HairSalon`), retiré automatiquement si un plugin SEO est actif.

## 5. Règles à respecter

- Ne changer que ce que Darius demande ; garder le design existant.
- Avant une modification importante : `git tag -f avant-<mission>` pour pouvoir revenir en arrière.
- Ne jamais lire ni modifier les secrets (`.env`), ni en mettre dans le code ou le chat.
- Vérifier le rendu avant de dire « fini ».
- Réponses à Darius en français, courtes.
- Ne rien inventer (prix, maîtres, avis, ИНН).

## 6. Qui tient la barre

**Personne (libre)** — 2026-10-24

(Avant de commencer : écrire ici « Grok Bot » ou « DeepSeek Harness » + date et mission. À la fin : remettre « Personne (libre) ».)

## 7. Prochaines étapes

- Avant mise en ligne (README) : compléter l'ИНН et la forme juridique dans « Политика конфиденциальности » et « Правовая информация », vérifier le téléphone et les deux liens de réservation.
- Projet encore actif ou remplacé par `Glitters_Astro` / `Glitters2` : à confirmer par Darius.

## 8. Journal

- 2026-10-24 — Grok Bot : création du carnet.
