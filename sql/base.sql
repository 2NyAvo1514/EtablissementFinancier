INSERT INTO banque_TypeMouvementSolde(typeMouvementSolde) VALUES
('pret'),('remboursement'),('retrait'),('depot');

INSERT INTO banque_TypePret(typePret,dureeMin,dureeMax) VALUES
('long terme',60,300),('moyen terme',12,60),('court terme',1,12);

INSERT INTO banque_TypeClient(typeClient) VALUES
("particulier"),
("entreprise");

INSERT INTO banque_Taux (idTypeClient,idTypePret,valeur,dateTaux) VALUES
(1,1,6,"2024-01-01"),
(1,2,7,"2024-01-01"),
(1,3,9,"2024-01-01"),
(2,1,5,"2024-01-01"),
(2,2,6,"2024-01-01"),
(2,3,7,"2024-01-01");

INSERT INTO banque_Pret (idTypePret, montant, idClient, descriptionPret, datePret, nbrMois) VALUES 
(1, 1200.00, 1, 'Achat ordinateur', '2024-05-01', 12),   -- Court terme
(3, 50000.00, 2, 'Investissement local', '2024-01-01', 120); -- Long terme

INSERT INTO banque_HistoriquePret (idPret, statutValidation, dateValidation) VALUES
(1, true, '2024-05-05'),
(2, true, '2024-01-10');

-- idPret = 1 : 12 mois à 100.00
INSERT INTO banque_Prevision (idPret, mois, annee, montantFinal) VALUES
(1, 5, 2024, 100.00),
(1, 6, 2024, 100.00),
(1, 7, 2024, 100.00),
(1, 8, 2024, 100.00),
(1, 9, 2024, 100.00),
(1, 10, 2024, 100.00),
(1, 11, 2024, 100.00),
(1, 12, 2024, 100.00),
(1, 1, 2025, 100.00),
(1, 2, 2025, 100.00),
(1, 3, 2025, 100.00),
(1, 4, 2025, 100.00);

-- idPret = 2 : 120 mois à 416.67
INSERT INTO banque_Prevision (idPret, mois, annee, montantFinal) VALUES
(2, 1, 2024, 416.67),
(2, 2, 2024, 416.67),
(2, 3, 2024, 416.67);
-- etc. à compléter selon besoin




