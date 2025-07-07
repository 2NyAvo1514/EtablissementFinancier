CREATE DATABASE banque;
USE banque;

CREATE TABLE banque_TypeClient(
    id INT AUTO_INCREMENT PRIMARY KEY,
    typeClient VARCHAR(255)
);

CREATE TABLE banque_TypePret (
    id INT AUTO_INCREMENT PRIMARY KEY ,
    typePret varchar(255) ,
    dureeMin INT , -- en mois
    dureeMax INT -- en mois
) ;

CREATE TABLE banque_TypeMouvementSolde (
    id INT AUTO_INCREMENT PRIMARY KEY ,
    typeMouvementSolde varchar(255)
) ;

CREATE TABLE banque_Client(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255),
    mail VARCHAR(255),
    mdp VARCHAR(255),
    dateNaissance date,
    idTypeClient INT,
    FOREIGN KEY (idTypeClient) REFERENCES banque_TypeClient(id)
);

-- CREATE TABLE banque_MessageAdmin(
--     id INT AUTO_INCREMENT PRIMARY KEY,
--     message VARCHAR(255),
--     idClient INT,
--     date DATETIME,
--     FOREIGN KEY (idClient) REFERENCES banque_Client(id)
-- );

-- CREATE TABLE banque_MessageClient(
--     id INT AUTO_INCREMENT PRIMARY KEY,
--     message VARCHAR(255),
--     idClient INT,
--     date DATETIME,
--     FOREIGN KEY (idClient) REFERENCES banque_Client(id)
-- );

CREATE TABLE banque_Pret (
    id INT AUTO_INCREMENT PRIMARY KEY,
    idTypePret INT ,
    montant DECIMAL(10,2),
    idClient INT,
    descriptionPret TEXT,
    datePret date,
    nbrMois int ,
    FOREIGN KEY(idTypePret) REFERENCES banque_TypePret(id), 
    FOREIGN KEY(idClient) REFERENCES banque_Client(id)
) ;

CREATE TABLE banque_HistoriquePret (
    id INT AUTO_INCREMENT PRIMARY KEY,
    idPret int ,
    statutValidation int,
    dateValidation date ,
    FOREIGN KEY (idPret) REFERENCES banque_Pret(id)
);

CREATE TABLE banque_Taux (
    id INT AUTO_INCREMENT PRIMARY KEY,
    idTypeClient INT,
    idTypePret INT,
    valeur INT,
    dateTaux DATE,
    FOREIGN KEY (idTypeClient) REFERENCES banque_TypeClient(id),
    FOREIGN KEY (idTypePret) REFERENCES banque_TypePret(id)
);

CREATE TABLE banque_HistoriqueMouvementSolde(
    id INT AUTO_INCREMENT PRIMARY KEY,
    idClient INT,
    idTypeMouvementSolde INT,
    montant DECIMAL(10,2),
    dateMouvement DATE,
    statutValidation BOOLEAN,
    FOREIGN KEY (idClient) REFERENCES banque_Client(id),
    FOREIGN KEY (idTypeMouvementSolde) REFERENCES banque_TypeMouvementSolde(id)
);

ALTER TABLE banque_Client
ADD COLUMN numeroIdentification VARCHAR(255);

CREATE TABLE banque_Fond (
    id INT AUTO_INCREMENT PRIMARY KEY,
    solde BIGINT
);

-- alter table banque_Pret drop COLUMN duree ;
-- alter table banque_Pret add COLUMN nbrMois int;

-- alter table banque_HistoriquePret drop COLUMN statusValidation;
-- alter table banque_HistoriquePret add COLUMN statutValidation int;