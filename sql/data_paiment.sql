
INSERT INTO tarif_ecolage (montant, adult) VALUES
(20000.0, FALSE),  -- Tarif pour enfant
(25000.0, TRUE);   -- Tarif pour adulte


INSERT INTO genre (label) VALUES
('Masculin'),
('Feminin'),
('Autre');

INSERT INTO eleve (nom, prenom, date_naissance, adresse, contact, date_inscription, id_genre) VALUES
('Rakoto', 'Jean', '2010-04-15 00:00:00', 'Antananarivo, 67Ha', '0341234567', '2025-01-15 09:00:00', 1),
('Rasoa', 'Marie', '2011-09-22 00:00:00', 'Fianarantsoa, Ambatonilita', '0339876543', '2025-06-20 10:30:00', 2),
('Andry', 'Sam', '2009-12-01 00:00:00', 'Toamasina, Tanambao V', '0321122334', '2025-03-25 14:15:00', 1);

INSERT INTO ecolage (id_eleve, montant, date_paiement, mois, annee, statut)
VALUES (1, 50000.0, '2025-01-15 09:00:00', 1, 2025, 'non paye');

SELECT montant FROM tarif_ecolage WHERE adult = FALSE; /* ENFANT */
SELECT montant FROM tarif_ecolage WHERE adult = TRUE; /* ADULTE */


SELECT mois, annee FROM ecolage WHERE id_eleve = 1 AND statut = 'non paye' ORDER BY annee, mois LIMIT 1;

INSERT INTO club_groupe (nom_responsable, contact, nombre)
VALUES 
  ('Rasolofoniaina Jean', '0321234567', 10),
  ('Rakotondramanana Hanta', '0349876543', 12),
  ('Randrianarisoa Fanja', '0331122334', 8);

INSERT INTO tarif_abonnement (montant) VALUES (200000.00);
