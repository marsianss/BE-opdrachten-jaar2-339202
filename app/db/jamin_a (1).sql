
-- Drop database if it exists and create a new one
DROP DATABASE IF EXISTS jamin_b;
CREATE DATABASE jamin_b;
USE jamin_b;

-- Create Product table
CREATE TABLE Product (
    Id INT PRIMARY KEY,
    Naam VARCHAR(255) NOT NULL,
    Barcode VARCHAR(13) UNIQUE NOT NULL
);

-- Insert Product data
INSERT INTO Product (Id, Naam, Barcode) VALUES
(1, 'Mintnopjes', '8719587231278'),
(2, 'Schoolkrijt', '8719587326713'),
(3, 'Honingdrop', '8719587327836'),
(4, 'Zure Beren', '8719587321441'),
(5, 'Cola Flesjes', '8719587321237'),
(6, 'Turtles', '8719587322245'),
(7, 'Witte Muizen', '8719587328256'),
(8, 'Reuzen Slangen', '8719587325641'),
(9, 'Zoute Rijen', '8719587322739'),
(10, 'Winegums', '8719587327527'),
(11, 'Drop Munten', '8719587322345'),
(12, 'Kruis Drop', '8719587322265'),
(13, 'Zoute Ruitjes', '8719587323256'),
(14, 'Drop ninja’s', '8719587323277');

-- Create ProductEinddatumLevering table
CREATE TABLE ProductEinddatumLevering (
    Id INT PRIMARY KEY,
    ProductId INT,
    EinddatumLevering DATE NOT NULL,
    FOREIGN KEY (ProductId) REFERENCES Product(Id)
);

-- Insert ProductEinddatumLevering data
INSERT INTO ProductEinddatumLevering (Id, ProductId, EinddatumLevering) VALUES
(1, 1, '2024-06-01'),
(2, 2, '2024-05-22'),
(3, 3, '2024-05-30'),
(4, 4, '2024-05-12'),
(5, 7, '2024-05-27'),
(6, 10, '2024-05-03'),
(7, 11, '2024-02-09'),
(8, 14, '2024-01-01');

-- Create Allergeen table
CREATE TABLE Allergeen (
    Id INT PRIMARY KEY,
    Naam VARCHAR(255) NOT NULL,
    Omschrijving TEXT NOT NULL
);

-- Insert Allergeen data
INSERT INTO Allergeen (Id, Naam, Omschrijving) VALUES
(1, 'Gluten', 'Dit product bevat gluten'),
(2, 'Gelatine', 'Dit product bevat gelatine'),
(3, 'AZO-Kleurstof', 'Dit product bevat AZO-kleurstoffen'),
(4, 'Lactose', 'Dit product bevat lactose'),
(5, 'Soja', 'Dit product bevat soja');

-- Create ProductPerAllergeen table
CREATE TABLE ProductPerAllergeen (
    Id INT PRIMARY KEY,
    ProductId INT,
    AllergeenId INT,
    FOREIGN KEY (ProductId) REFERENCES Product(Id),
    FOREIGN KEY (AllergeenId) REFERENCES Allergeen(Id)
);

-- Insert ProductPerAllergeen data
INSERT INTO ProductPerAllergeen (Id, ProductId, AllergeenId) VALUES
(1, 1, 2),
(2, 1, 1),
(3, 1, 3),
(4, 3, 4),
(5, 6, 5),
(6, 9, 2),
(7, 9, 5),
(8, 10, 2),
(9, 12, 4),
(10, 13, 1),
(11, 13, 4),
(12, 13, 5),
(13, 14, 5);

-- Create Leverancier table
CREATE TABLE Leverancier (
    Id INT PRIMARY KEY,
    Naam VARCHAR(255) NOT NULL,
    ContactPersoon VARCHAR(255) NOT NULL,
    LeverancierNummer VARCHAR(20) UNIQUE NOT NULL,
    Mobiel VARCHAR(15) NOT NULL,
    ContactId INT
);

-- Insert Leverancier data
INSERT INTO Leverancier (Id, Naam, ContactPersoon, LeverancierNummer, Mobiel, ContactId) VALUES
(1, 'Venco', 'Bert van Linge', 'L1029384719', '06-28493827', 1),
(2, 'Astra Sweets', 'Jasper del Monte', 'L1029284315', '06-39398734', 2),
(3, 'Haribo', 'Sven Stalman', 'L1029324748', '06-24383291', 3),
(4, 'Basset', 'Joyce Stelterberg', 'L1023845773', '06-48293823', 4),
(5, 'De Bron', 'Remco Veenstra', 'L1023857736', '06-34291234', 5),
(6, 'Quality Street', 'Johan Nooij', 'L1029234586', '06-23458456', 6),
(7, 'Hom Ken Food', 'Hom Ken', 'L1029234599', '06-23458477', NULL);

-- Create Contact table
CREATE TABLE Contact (
    Id INT PRIMARY KEY,
    Straat VARCHAR(255) NOT NULL,
    Huisnummer INT NOT NULL,
    Postcode VARCHAR(10) NOT NULL,
    Stad VARCHAR(255) NOT NULL
);

-- Insert Contact data
INSERT INTO Contact (Id, Straat, Huisnummer, Postcode, Stad) VALUES
(1, 'Van Gilslaan', 34, '1045CB', 'Hilvarenbeek'),
(2, 'Den Dolderpad', 2, '1067RC', 'Utrecht'),
(3, 'Fredo Raalteweg', 257, '1236OP', 'Nijmegen'),
(4, 'Bertrand Russellhof', 21, '2034AP', 'Den Haag'),
(5, 'Leon van Bonstraat', 213, '145XC', 'Lunteren'),
(6, 'Bea van Lingenlaan', 234, '2197FG', 'Sint Pancras');

-- Create ProductPerLeverancier table
CREATE TABLE ProductPerLeverancier (
    Id INT PRIMARY KEY,
    LeverancierId INT,
    ProductId INT,
    DatumLevering DATE NOT NULL,
    Aantal INT NOT NULL,
    DatumEerstVolgendeLevering DATE NULL,
    FOREIGN KEY (LeverancierId) REFERENCES Leverancier(Id),
    FOREIGN KEY (ProductId) REFERENCES Product(Id)
);

-- Insert ProductPerLeverancier data
INSERT INTO ProductPerLeverancier (Id, LeverancierId, ProductId, DatumLevering, Aantal, DatumEerstVolgendeLevering) VALUES
(1, 1, 1, '2023-04-09', 23, '2023-04-16'),
(2, 1, 1, '2023-04-18', 21, '2023-04-25'),
(3, 1, 2, '2023-04-09', 12, '2023-04-16'),
(4, 1, 3, '2023-04-10', 11, '2023-04-17'),
(5, 2, 4, '2023-04-14', 16, '2023-04-21'),
(6, 2, 4, '2023-04-21', 23, '2023-04-28'),
(7, 2, 5, '2023-04-14', 45, '2023-04-21'),
(8, 2, 6, '2023-04-14', 30, '2023-04-21'),
(9, 3, 7, '2023-04-12', 12, '2023-04-19'),
(10, 3, 7, '2023-04-19', 23, '2023-04-26'),
(11, 3, 8, '2023-04-10', 12, '2023-04-17'),
(12, 3, 9, '2023-04-11', 1, '2023-04-18');