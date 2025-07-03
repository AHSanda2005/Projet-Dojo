-- Type ENUM
CREATE TYPE etat AS ENUM ('neuve', 'usee', 'abimee');
CREATE TYPE statut AS ENUM ('cree','modifie','annule');

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
  reference_materiel INTEGER PRIMARY KEY,
  label VARCHAR,
  id_materiel SERIAL UNIQUE
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

CREATE TABLE plage_horaire (
    id SERIAL PRIMARY KEY,
    heure_debut TIME UNIQUE,
    heure_fin TIME UNIQUE
);

INSERT INTO plage_horaire (heure_debut, heure_fin) VALUES
('08:00', '10:00'),
('10:00', '12:00'),
('13:00', '15:00'),
('15:00', '17:00');

CREATE TABLE seances_cours (
    id_seances SERIAL PRIMARY KEY,
    id_cours INTEGER REFERENCES cours(id_cours),
    date DATE NOT NULL,
    id_plage INTEGER REFERENCES plage_horaire(id),
    id_prof INTEGER REFERENCES prof(id_prof)
);

CREATE TABLE historique_seances (
  id_historique SERIAL PRIMARY KEY,
  id_seances INTEGER REFERENCES seances_cours(id_seances),
  date DATE,
  statut statut
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

CREATE TABLE maximum (
  nombre_eleve_cours INTEGER,
  nombre_eleve INTEGER
);

CREATE TABLE abonnement (
  id_abonnement SERIAL PRIMARY KEY,
  id_club INTEGER REFERENCES club_groupe(id),
  jour INTEGER,
  mois INTEGER,
  actif BOOLEAN
);

CREATE TABLE gestion_groupe (
    id SERIAL PRIMARY KEY,
    id_eleve INTEGER REFERENCES eleve(id_eleve),
    mois INTEGER,
    annee INTEGER,
    groupe INTEGER,
    UNIQUE (id_eleve, mois, annee)
);

CREATE TABLE planification_cours (
    id SERIAL PRIMARY KEY,
    id_seance INTEGER REFERENCES seances_cours(id_seances),
    groupe INTEGER,
    UNIQUE (id_seance, groupe)
);

-- 1. Genres (nécessaires pour prof et eleve)
INSERT INTO genre (label) VALUES ('Homme'), ('Femme');

-- 2. Profs
INSERT INTO prof (nom, prenom, date_naissance, adresse, contact, id_genre) VALUES
('Rakoto', 'Jean', '1980-01-01', 'Antananarivo', '0321123456', 1),
('Rabe', 'Pauline', '1985-06-15', 'Fianarantsoa', '0321987654', 2);

-- 3. Élèves
INSERT INTO eleve (nom, prenom, date_naissance, adresse, contact, id_genre) VALUES
('Andrianina', 'Sarah', '2010-04-12', 'Antsirabe', '0341122334', 2),
('Ravelo', 'Marc', '2009-08-23', 'Mahajanga', '0334455667', 1),
('Rakotovao', 'Lova', '2011-11-01', 'Toamasina', '0339988776', 1),
('Rasoa', 'Miora', '2010-02-18', 'Toliara', '0322345678', 2);

-- 5. Paiement ecolage pour affectation des groupes (ex. Juin 2025)
INSERT INTO ecolage (id_eleve, montant, date_paiement, mois, annee) VALUES
(1, 30000, '2025-07-01', 7, 2025),
(2, 30000, '2025-06-02', 6, 2025),
(3, 30000, '2025-06-03', 6, 2025),
(4, 30000, '2025-06-03', 6, 2025);

