
## Demo

lien de l'application déployé => https://listmateriel.menardyoan.com/


## Techologies

**Front:** Twigg, CSS, JavaScript, plug-in jQuery datatable

**Back:** Symfony

**Bundle:** domPDF => https://github.com/dompdf/dompdf

**SGBD:** mariaDB

**Mailer:** mailpit

J'ai utilisé un devContainer pour mettre en place mon environnement de travail.


## Installation

Cloner le projet

```bash
  git clone https://github.com/YoanMen/MaterialsList.git
```
  
Lancement du devContainer et installation des dépendances

```bash
  composer install
```

Initialisation de la base de données

```bash
  php bin/console doctrine:database:create
  php bin/console doctrine:migration:migrate
```

Mise en place d'un jeu de données

```bash
  php bin/console doctrine:fixture:load
```

Lancement du serveur 

```bash
symfony server:start
```
