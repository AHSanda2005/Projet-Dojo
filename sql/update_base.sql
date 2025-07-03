CREATE TYPE statut_ecolage AS ENUM ( /* Wanda - update 29-06-25 */
  'non paye',
  'paye',
  'en retard',
  'annule',
  'en attente'
);


CREATE TABLE eleve (
  id_eleve SERIAL PRIMARY KEY,
  nom VARCHAR,
  prenom VARCHAR,
  date_naissance TIMESTAMP,
  adresse VARCHAR,
  contact VARCHAR,
  date_inscription TIMESTAMP, /* Wanda - update 29-06-25 */
  id_genre INTEGER REFERENCES genre(id_genre)
);


CREATE TABLE ecolage (
  id_ecolage SERIAL PRIMARY KEY,
  id_eleve INTEGER REFERENCES eleve(id_eleve),
  montant FLOAT,
  date_paiement TIMESTAMP,
  mois INTEGER,
  annee INTEGER,
  statut statut_ecolage DEFAULT 'non paye' /* Wanda - update 29-06-25 */
);

CREATE TABLE paiement (
  id_payement SERIAL PRIMARY KEY,
  id_reservation INTEGER REFERENCES reservation(id_reservation), /* Wanda - update 29-06-25 */
  montant FLOAT,
  date_paiement TIMESTAMP
);

