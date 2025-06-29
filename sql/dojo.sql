-- Type ENUM
CREATE TYPE etat AS ENUM ('neuve', 'usee', 'abimee');

-- Tables principales
CREATE TABLE genre (
  id_genre SERIAL PRIMARY KEY,
  label VARCHAR
);

CREATE TABLE superviseur (
  id_superviseur SERIAL PRIMARY KEY,
  nom VARCHAR,
  prenom VARCHAR,
  date_naissance TIMESTAMP,
  adresse VARCHAR,
  contact VARCHAR,
  id_genre INTEGER REFERENCES genre(id_genre)
);

CREATE TABLE prof (
  id_prof SERIAL PRIMARY KEY,
  nom VARCHAR,
  prenom VARCHAR,
  date_naissance TIMESTAMP,
  adresse VARCHAR,
  contact VARCHAR,
  id_genre INTEGER REFERENCES genre(id_genre)
);

CREATE TABLE eleve (
  id_eleve SERIAL PRIMARY KEY,
  nom VARCHAR,
  prenom VARCHAR,
  date_naissance TIMESTAMP,
  adresse VARCHAR,
  contact VARCHAR,
  id_genre INTEGER REFERENCES genre(id_genre)
);

CREATE TABLE parent (
  id_parent SERIAL PRIMARY KEY,
  nom VARCHAR,
  prenom VARCHAR,
  contact VARCHAR,
  adresse VARCHAR
);

CREATE TABLE parent_eleve (
  id SERIAL PRIMARY KEY,
  id_parent INTEGER REFERENCES parent(id_parent),
  id_eleve INTEGER REFERENCES eleve(id_eleve)
);



-- Matériel et suivi : Dylan modification (28-06-25)

CREATE TABLE materiel_type (
   id_type     SERIAL PRIMARY KEY,
   reference   VARCHAR(50) UNIQUE NOT NULL,
   label       VARCHAR(255) NOT NULL,
   description TEXT
);

ALTER TABLE materiel_type
    ADD COLUMN prix NUMERIC(10,2) DEFAULT 0; -- Dylan modification (29-06-25)


CREATE TABLE materiel_item (
   id_item    SERIAL PRIMARY KEY,
   id_type    INTEGER NOT NULL
       REFERENCES materiel_type(id_type)
           ON DELETE CASCADE,
   num_serie  VARCHAR(100) UNIQUE,
   etat       etat NOT NULL DEFAULT 'neuve'
);

CREATE TABLE stock_materiel (
    id_suivi        SERIAL PRIMARY KEY,
    id_type         INTEGER NOT NULL
        REFERENCES materiel_type(id_type)
            ON DELETE RESTRICT,
    type_mouvement  CHAR(1) NOT NULL             -- 'I' pour entrée, 'O' pour sortie
        CHECK (type_mouvement IN ('I','O')),
    quantite        INTEGER NOT NULL CHECK (quantite > 0),
    date            TIMESTAMP NOT NULL DEFAULT now()
);

CREATE TYPE etat_suivi AS ENUM ('disponible','endommage');

CREATE TABLE suivi_salle (
     id_suivi_salle SERIAL PRIMARY KEY,
     id_superviseur   INTEGER NOT NULL
         REFERENCES superviseur(id_superviseur)
             ON DELETE RESTRICT,
     id_item          INTEGER NOT NULL
         REFERENCES materiel_item(id_item)
             ON DELETE CASCADE,
     date             TIMESTAMP NOT NULL DEFAULT now(),
     description      TEXT,
     etat             etat_suivi NOT NULL DEFAULT 'disponible'
);
ALTER TABLE suivi_salle ADD COLUMN id_club INTEGER REFERENCES club_groupe(id); --Dylan modification (29-06-25)


CREATE TABLE facture_materiel (
      id_facture SERIAL PRIMARY KEY,
      id_suivi_salle INTEGER REFERENCES suivi_salle(id_suivi_salle) UNIQUE,
      date TIMESTAMP DEFAULT NOW(),
      destinataire VARCHAR(255),  -- nom club ou superviseur
      montant NUMERIC(10,2)
);
ALTER TABLE facture_materiel ADD COLUMN est_paye BOOLEAN DEFAULT FALSE;


SELECT mi.*
FROM materiel_item mi
WHERE mi.id_type = 1
  AND NOT EXISTS (
    SELECT 1 FROM stock_materiel sm
    WHERE sm.id_type = 1
      AND sm.type_mouvement = 'O'
      AND sm.quantite >= (
        SELECT COUNT(*) FROM materiel_item
        WHERE id_type = 1
    )
);

SELECT * FROM materiel_item
WHERE id_type = 1
  AND etat = 'neuve';

INSERT INTO club_groupe (nom_responsable, contact, nombre)
VALUES ('Rakoto Jean', '0341234567', 15);

INSERT INTO club_groupe (nom_responsable, contact, nombre)
VALUES ('Rasolonjatovo Lova', '0339876543', 10);

UPDATE materiel_type
SET prix = 45000.00
WHERE id_type = 1;

INSERT INTO materiel_type (reference, label, description, prix)
VALUES ('TAP-001', 'Tapis de sol', 'Tapis antidérapant pour arts martiaux', 35000.00);


-- Dylan modification (28-06-25)

CREATE TABLE historique_garde (
  id_historique SERIAL PRIMARY KEY,
  id_superviseur INTEGER REFERENCES superviseur(id_superviseur),
  date DATE,
  heure TIMESTAMP
);


-- Cours
CREATE TABLE cours (
  id_cours SERIAL PRIMARY KEY,
  label VARCHAR
);

CREATE TABLE seances_cours (
  id_seances SERIAL PRIMARY KEY,
  id_cours INTEGER REFERENCES cours(id_cours),
  date DATE,
  heure_debut TIME,
  heure_fin TIME
);

CREATE TABLE historique_seances (
  id_historique SERIAL PRIMARY KEY,
  id_seances INTEGER REFERENCES seances_cours(id_seances),
  date DATE
);

CREATE TABLE evolution (
  id_prof INTEGER REFERENCES prof(id_prof),
  id_eleve INTEGER REFERENCES eleve(id_eleve),
  avis TEXT
);

CREATE TABLE ecolage (
  id_ecolage SERIAL PRIMARY KEY,
  id_eleve INTEGER REFERENCES eleve(id_eleve),
  montant FLOAT,
  date_paiement TIMESTAMP,
  mois INTEGER,
  annee INTEGER
);

-- Clubs
CREATE TABLE club_groupe (
  id SERIAL PRIMARY KEY,
  nom_responsable VARCHAR,
  contact VARCHAR,
  nombre INTEGER
);

CREATE TABLE reservation (
  id_reservation SERIAL PRIMARY KEY,
  id_club INTEGER REFERENCES club_groupe(id),
  date_reservation TIMESTAMP,
  date_reserve TIMESTAMP,
  heure_debut TIME,
  heure_fin TIME
);

CREATE TABLE paiement (
  id_payement SERIAL PRIMARY KEY,
  id_groupe INTEGER REFERENCES club_groupe(id),
  montant FLOAT,
  date_paiement TIMESTAMP
);

CREATE TABLE tarif_ecolage (
  id_tarif SERIAL PRIMARY KEY,
  montant FLOAT,
  adult BOOLEAN
);

CREATE TABLE tarif_club (
  id_tarif SERIAL PRIMARY KEY,
  montant_par_heure FLOAT
);

CREATE TABLE tarif_abonnement (
  montant FLOAT
);

CREATE TABLE abonnement (
  id_abonnement SERIAL PRIMARY KEY,
  id_club INTEGER REFERENCES club_groupe(id),
  jour INTEGER,
  mois INTEGER,
  actif BOOLEAN
);
