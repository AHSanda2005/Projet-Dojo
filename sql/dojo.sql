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

-- Matériel et suivi
CREATE TABLE materiel (
  id_materiel SERIAL,
  reference_materiel INTEGER UNIQUE,
  label VARCHAR,
  PRIMARY KEY (id_materiel, reference_materiel)
);

CREATE TABLE stock_materiel (
  id_suivi_materiel SERIAL PRIMARY KEY,
  id_materiel INTEGER REFERENCES materiel(id_materiel),
  quantite INTEGER,
  date TIMESTAMP
);

CREATE TABLE historique_garde (
  id_historique SERIAL PRIMARY KEY,
  id_superviseur INTEGER REFERENCES superviseur(id_superviseur),
  date DATE,
  heure TIMESTAMP
);

CREATE TABLE suivi_salle (
  id_superviseur INTEGER REFERENCES superviseur(id_superviseur),
  description TEXT,
  reference_materiel INTEGER REFERENCES materiel(reference_materiel),
  etat etat
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
