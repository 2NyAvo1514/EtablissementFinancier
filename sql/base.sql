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




