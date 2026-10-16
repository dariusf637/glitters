# Glitters — женский салон красоты

Thème WordPress du salon Glitters, ул. Правды, 16, Санкт-Петербург. Le site public est entièrement en russe. Ce fichier explique l’installation.

## Voir le rendu sans WordPress

Ouvrir `preview/index.html` dans un navigateur. C’est la même feuille de style et les vraies photos que le thème. L’installation WordPress reste le site à publier.

## Installer

1. Installer WordPress (PHP 7.4+, HTTPS).
2. Copier le dossier `wp-content/themes/glitters` dans le site, ou zipper ce dossier et l’envoyer via Apparence → Thèmes. Le zip doit contenir le dossier `glitters`, pas seulement les fichiers.
3. Activer le thème. À la première visite il crée la page d’accueil, les huit services, la politique de confidentialité et la page juridique, passe le site en russe si le paquet de langue peut être téléchargé, et règle le fuseau sur Moscou si aucun fuseau n’était choisi.
4. Apparence → Personnaliser n’est pas nécessaire pour le contenu. Tout est dans le menu **Glitters**.

## Photos et film

La photo d’ouverture et le film viennent du salon.

- `assets/images/salon-hero.jpg` — photo du présentoir et du poste de coiffage, en grand écran.
- `assets/images/salon-wash.jpg`, `salon-mirror.jpg`, `salon-attente.jpg` — images tirées de la vidéo, choisies parce qu’elles montrent les salles.
- `assets/video/salon-interieur.mp4` — extrait silencieux d’environ 6 secondes (la partie où l’on voit le hall). L’entrée de service et la zone technique de la vidéo d’origine ne sont pas publiées.

Pour remplacer les photos : Glitters → Интерьер, image à la une, puis publier. Ces photos remplacent les trois cadres. Le film reste tant que la case est cochée dans Glitters → Настройки. Un autre photo d’ouverture se choisit dans le même écran.

## Textes, prix, maîtres, avis

- Les textes de la page d’accueil sont dans Glitters → Настройки, bloc « Тексты главной ».
- Les huit services sont déjà rédigés. Le prix se saisit en nombre seul (`4500` devient « от 4 500 ₽ »). Tant que le champ est vide, la carte dit « Стоимость уточняется при записи ». Aucun prix n’a été inventé.
- Tant qu’aucun maître n’est publié, trois cartes de spécialité s’affichent, sans nom fictif. Ajouter un maître (nom, spécialisation, biographie, portrait) les remplace.
- Les avis ne sont pas préremplis. Publier seulement des avis réels. Le carrousel apparaît alors. Pas de note globale inventée dans la microdonnée.

## Réservation et mobile

- Яндекс : lien de réservation fourni, nouvel onglet.
- Dikidi : `https://dikidi.net/ru/2119020?p=0.pi-po`, nouvel onglet.
- Sous 860 px, une barre fixe propose « Позвонить » et « Записаться онлайн ».
- WhatsApp et Telegram apparaissent dans les contacts dès qu’une URL est enregistrée dans les réglages.

## SEO local

Sans plugin SEO, le thème pose déjà :

- Title : `Glitters — женский салон красоты в Санкт-Петербурге, ул. Правды, 16`
- Meta description : `Женский салон красоты и студия ухода за волосами Glitters в Санкт-Петербурге. Стрижки, окрашивание, укладки и уход за волосами. Онлайн-запись.`
- Un seul H1, les sections en H2, le tout en russe.
- JSON-LD `HairSalon` / `BeautySalon` : nom, adresse, téléphone, horaires 09:00–21:00, coordonnées 59.922305, 30.341084.

Si Rank Math, Yoast, AIOSEO ou SEOPress est actif, le thème retire ses balises pour éviter les doublons. Il faut alors recopier les mêmes informations dans le plugin. La case « Дублировать микроразметку » ne sert que si vous assumez deux graphes.

Chaque service a une URL `/uslugi/…`. Le plan de site natif de WordPress les inclut (`/wp-sitemap.xml`).

Dans Glitters → Настройки, coller les codes Яндекс.Вебмастер et Google Search Console. La fiche Яндекс Бизнес doit reprendre exactement le même nom, la même adresse et le même téléphone.

## Plugins recommandés

Ne pas installer Elementor : la page est déjà composée et plus légère ainsi. Le thème reste compatible Gutenberg (`theme.json`, `wp_head`, `wp_footer`).

- **Rank Math SEO** pour la fiche locale, si vous préférez gérer le SEO dans un plugin.
- **LiteSpeed Cache** si l’hébergeur est LiteSpeed, sinon **WP Super Cache**. Un seul plugin de cache.
- **Converter for Media** pour le WebP. Les photos livrées sont déjà légères.
- **Wordfence** ou Solid Security.
- **UpdraftPlus** pour les sauvegardes hors du serveur.
- **WP Mail SMTP** (boîte Yandex ou Mail.ru). Les demandes sont aussi dans Glitters → Заявки si le courrier n’arrive pas.

## Avant la mise en ligne

Compléter l’ИНН et la forme juridique dans les pages « Политика конфиденциальности » et « Правовая информация » : le texte le signale. Vérifier le téléphone, les deux liens de réservation, puis remplacer les cadres seulement si de nouvelles photos sont meilleures que celles déjà en place.
