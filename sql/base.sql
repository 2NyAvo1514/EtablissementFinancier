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

-- Types de client utilisés :
-- 1 = particulier
-- 2 = entreprise

INSERT INTO banque_Client (nom, mail, mdp, dateNaissance, idTypeClient, numeroIdentification)
VALUES
('Ando Rakoto', 'ando.rakoto@mail.com', 'mdp123', '1990-05-12', 1, 'CIN001234'),
('Hery Rasoanaivo', 'hery.rasoanaivo@mail.com', 'mdp456', '1985-08-23', 2, 'NIF0035985'),
('Fanja Ravelomanana', 'fanja.ravelo@mail.com', 'mdp789', '1992-11-30', 1, 'CIN007890');


INSERT INTO banque_Pret (idTypePret, montant, idClient, descriptionPret, datePret, nbrMois) VALUES
(1, 800000.00, 1, 'Prêt pour achat de maison', '2025-06-01',8),
(2, 15000000.00, 2, 'Pret pour frais Medicaux', '2025-06-02',15),
(3, 14400000.00, 3, 'Prêt pour développement entreprise', '2025-06-03',72);

INSERT INTO banque_HistoriquePret (idPret, statutValidation, dateValidation) VALUES
(1, 0, '2025-06-01'),
(2, 0, '2025-06-02'),
(3, 0, '2025-06-03');

INSERT INTO banque_Assurance (idTypeClient, idTypePret, valeur, dateAssurance) VALUES
-- Particulier (1) avec prêts Long terme (1)
(1, 1, 12, '2024-07-01'),    -- Assurance 12% sur prêt long terme particulier
(1, 2, 8,  '2024-07-01'),    -- Assurance 8% sur prêt moyen terme particulier
(1, 3, 5,  '2024-07-01'),    -- Assurance 5% sur prêt court terme particulier

-- Entreprise (2) avec prêts Long terme (1)
(2, 1, 15, '2024-07-01'),    -- Assurance 15% sur prêt long terme entreprise
(2, 2, 10, '2024-07-01'),    -- Assurance 10% sur prêt moyen terme entreprise
(2, 3, 7,  '2024-07-01');    -- Assurance 7% sur prêt court terme entreprise