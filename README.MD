# Projet SP TODOLIST

LPDWCA - 2026 Léo Merkel

## Schema BDD

![Schéma de la bdd](https://github.com/Orabis/TodoList-PHP/raw/0c6057aa77462152179de66e5c3e5e19bb054010/bdd.png)

## Script SQL

```sql

CREATE DATABASE todolist;
USE todolist;
CREATE TABLE priorites
(
    id_priorite INT AUTO_INCREMENT PRIMARY KEY,
    nom         VARCHAR(50) NOT NULL
);
CREATE TABLE contexte
(
    id_contexte  INT AUTO_INCREMENT PRIMARY KEY,
    nom_contexte VARCHAR(50) NOT NULL
);
CREATE TABLE type_tache
(
    id_type  INT AUTO_INCREMENT PRIMARY KEY,
    nom_type VARCHAR(50) NOT NULL
);
CREATE TABLE statuts
(
    id_statut INT AUTO_INCREMENT PRIMARY KEY,
    libelle   VARCHAR(50) NOT NULL
);
CREATE TABLE tache
(
    id_tache    INT AUTO_INCREMENT PRIMARY KEY,
    titre       VARCHAR(255) NOT NULL,
    description TEXT,
    date_crea   DATE,
    id_priorite INT,
    id_contexte INT,
    id_type     INT,
    id_statut   INT,
    FOREIGN KEY (id_priorite) REFERENCES priorites (id_priorite),
    FOREIGN KEY (id_contexte) REFERENCES contexte (id_contexte),
    FOREIGN KEY (id_type) REFERENCES type_tache (id_type),
    FOREIGN KEY (id_statut) REFERENCES statuts (id_statut)
);
CREATE TABLE tags
(
    id_tag  INT AUTO_INCREMENT PRIMARY KEY,
    nom_tag VARCHAR(50) NOT NULL
);
CREATE TABLE tache_tag
(
    id_tache INT,
    id_tag   INT,
    PRIMARY KEY (id_tache, id_tag),
    FOREIGN KEY (id_tache) REFERENCES tache (id_tache),
    FOREIGN KEY (id_tag) REFERENCES tags (id_tag)
);
INSERT INTO priorites (id_priorite, nom)
VALUES (1, 'Faible'),
       (2, 'Normal'),
       (3, 'Urgent'),
       (4, 'Critique');
INSERT INTO contexte (id_contexte, nom_contexte)
VALUES (1, 'Bureau'),
       (2, 'Domicile'),
       (3, 'Deplacement'),
       (4, 'En ligne');
INSERT INTO type_tache (id_type, nom_type)
VALUES (1, 'Appel'),
       (2, 'Email'),
       (3, 'Redaction'),
       (4, 'Réunion'),
       (5, 'Maintenance');
INSERT INTO statuts (id_statut, libelle)
VALUES (1, 'A faire'),
       (2, 'En cours'),
       (3, 'Bloquée'),
       (4, 'En attente'),
       (5, 'Termine');

```

### Version postgresql
````postgresql
CREATE DATABASE todolist;
\c todolist

CREATE TABLE priorites
(
    id_priorite SERIAL PRIMARY KEY,
    nom_priorite         VARCHAR(50) NOT NULL
);

CREATE TABLE contexte
(
    id_contexte  SERIAL PRIMARY KEY,
    nom_contexte VARCHAR(50) NOT NULL
);

CREATE TABLE type_tache
(
    id_type  SERIAL PRIMARY KEY,
    nom_type VARCHAR(50) NOT NULL
);

CREATE TABLE statuts
(
    id_statut SERIAL PRIMARY KEY,
    libelle   VARCHAR(50) NOT NULL
);

CREATE TABLE tache
(
    id_tache    SERIAL PRIMARY KEY,
    titre       VARCHAR(255) NOT NULL,
    description TEXT,
    date_crea   DATE,
    id_priorite INT,
    id_contexte INT,
    id_type     INT,
    id_statut   INT,
    FOREIGN KEY (id_priorite) REFERENCES priorites (id_priorite),
    FOREIGN KEY (id_contexte) REFERENCES contexte (id_contexte),
    FOREIGN KEY (id_type) REFERENCES type_tache (id_type),
    FOREIGN KEY (id_statut) REFERENCES statuts (id_statut)
);

CREATE TABLE tags
(
    id_tag  SERIAL PRIMARY KEY,
    nom_tag VARCHAR(50) NOT NULL
);

CREATE TABLE tache_tag
(
    id_tache INT,
    id_tag   INT,
    PRIMARY KEY (id_tache, id_tag),
    FOREIGN KEY (id_tache) REFERENCES tache (id_tache),
    FOREIGN KEY (id_tag) REFERENCES tags (id_tag)
);

INSERT INTO priorites (nom_priorite)
VALUES ('Faible'), ('Normal'), ('Urgent'), ('Critique');

INSERT INTO contexte (nom_contexte)
VALUES ('Bureau'), ('Domicile'), ('Deplacement'), ('En ligne');

INSERT INTO type_tache (nom_type)
VALUES ('Appel'), ('Email'), ('Redaction'), ('Réunion'), ('Maintenance');

INSERT INTO statuts (libelle)
VALUES ('A faire'), ('En cours'), ('Bloquée'), ('En attente'), ('Termine');
````
## Lancer le serveur :

`php -S localhost:8000`
> Attention ! Le Code utilise getenv pour la connexion a la bdd, il faut définir des var env dans le terminal

