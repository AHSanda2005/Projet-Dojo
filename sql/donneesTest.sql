INSERT INTO genre (label) VALUES
('Masculin'),
('Féminin');

INSERT INTO eleve (nom, prenom, date_naissance, adresse, contact, id_genre) VALUES
('Martin', 'Lucas', '2010-05-15', '12 Rue des écoles, Paris', '0612345678', 1),
('Bernard', 'Emma', '2011-02-20', '25 Avenue Victor Hugo, Lyon', '0623456789', 2),
('Dubois', 'Hugo', '2010-11-03', '8 Boulevard Gambetta, Marseille', '0634567890', 1),
('Thomas', 'Léa', '2011-07-28', '17 Rue de la République, Lille', '0645678901', 2),
('Petit', 'Nathan', '2010-09-10', '3 Place de la Mairie, Toulouse', '0656789012', 1);

-- Table eleve (10 élèves)
INSERT INTO eleve (nom, prenom, date_naissance, adresse, contact, id_genre) VALUES
('Robert', 'Chloé', '2011-04-12', '9 Rue des Arts, Bordeaux', '0667890123', 2),
('Richard', 'Tom', '2010-08-25', '14 Allée des Tilleuls, Nantes', '0678901234', 1),
('Durand', 'Zoé', '2011-01-30', '5 Rue du Stade, Strasbourg', '0689012345', 2),
('Leroy', 'Maxime', '2010-12-08', '22 Avenue Foch, Nice', '0690123456', 1),
('Moreau', 'Lina', '2011-03-17', '7 Chemin Vert, Rennes', '0601234567', 2);

INSERT INTO prof (nom, prenom, date_naissance, adresse, contact, id_genre) VALUES
('Durand', 'Sophie', '1980-04-12', '45 Rue du Professeur, Paris', '0678901234', 2),
('Moreau', 'Pierre', '1975-10-22', '32 Avenue des Sciences, Lyon', '0689012345', 1);

INSERT INTO evolution (id_prof, id_eleve, avis, note, date_evolution) VALUES
(1, 1, 'Très bon travail, continuez ainsi !', 18, '2025-01-01'),
(1, 2, 'Des progrès notables, peut encore améliorer la concentration', 14, '2025-02-02'),
(2, 3, 'Excellent en maths, doit travailler son français', 16, '2025-03-03'),
(2, 4, 'Participation active en cours, résultats en hausse', 15, '2025-04-04'),
(1, 5, 'Bon potentiel mais travail irrégulier', 12, '2025-05-05'),
(2, 1, 'Très créatif, excellente approche des problèmes', 17, '2025-06-06'),
(1, 3, 'Doit revoir certaines bases en sciences', 13, '2024-12-12');

INSERT INTO evolution (id_prof, id_eleve, avis, note, date_evolution) VALUES
-- Professeur 1 (Krav Maga)
(1, 1, 'Excellente réaction face à une attaque surprise', 18.5, '2025-01-10'),
(1, 2, 'Technique de parade à améliorer', 12.0, '2025-01-15'),
(1, 3, 'Contrôle des distances parfait', 19.0, '2025-02-05'),
(1, 1, 'Progrès remarquables en défense contre étranglement', 16.5, '2025-02-20'),
(1, 4, 'Gestion du stress à travailler', 11.0, '2025-03-08'),
(1, 5, 'Désarmement réussi en moins de 3 secondes', 20.0, '2025-04-03'),

-- Professeur 2 (Jiu-Jitsu Brésilien)
(2, 6, 'Clé de bras exécutée parfaitement', 17.5, '2025-01-12'),
(2, 7, 'Projection mal équilibrée', 13.0, '2025-01-18'),
(2, 8, 'Excellente défense au sol', 18.0, '2025-02-15'),
(2, 9, 'Technique de soumission trop lente', 14.5, '2025-03-02'),
(2, 10, 'Contrôle au sol exceptionnel', 19.5, '2025-03-22'),

-- Évaluations mixtes
(1, 6, 'Bonne adaptation aux techniques de frappe', 15.0, '2025-04-10'),
(2, 1, 'Transition debout-sol à travailler', 13.5, '2025-04-18'),
(1, 7, 'Défense contre arme blanche efficace', 16.0, '2025-05-05'),
(2, 2, 'Garde trop ouverte en combat au sol', 12.5, '2025-05-12'),
(1, 8, 'Réactions instinctives excellentes', 17.0, '2025-06-08'),
(2, 3, 'Échappement parfait en position dominante', 18.5, '2025-06-15'),
(1, 9, 'Prise de décision rapide', 14.0, '2025-07-03'),
(2, 4, 'Technique de roulade à perfectionner', 11.5, '2025-07-20');