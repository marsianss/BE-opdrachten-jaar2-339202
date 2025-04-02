<?php

class MagazijnModel
{
    private $db;

    public function __construct()
    {
        // Initialiseer de database-verbinding
        $this->db = new Database();
    }

    public function getAllMagazijnProducts()
    {
        try {
            $sql = "SELECT p.Barcode, p.Naam, ppl.Aantal AS AantalAanwezig, 'Stuk' AS VerpakkingsEenheid, p.Id AS ProductId
                    FROM Product p
                    JOIN ProductPerLeverancier ppl ON p.Id = ppl.ProductId
                    ORDER BY p.Barcode ASC";
            $this->db->query($sql);
            return $this->db->resultSet();
        } catch (Exception $e) {
            // Log de fout en gooi een nieuwe uitzondering
            error_log("Fout in getAllMagazijnProducts: " . $e->getMessage());
            throw new Exception("Database query failed: " . $e->getMessage());
        }
    }

    public function getLeveringInfoByProductId($productId)
    {
        try {
            $sql = "SELECT ppl.*, l.Naam AS LeverancierNaam, l.ContactPersoon, l.LeverancierNummer, l.Mobiel
                    FROM ProductPerLeverancier ppl
                    JOIN Leverancier l ON ppl.LeverancierId = l.Id
                    WHERE ppl.ProductId = :productId
                    ORDER BY ppl.DatumLevering ASC";
            $this->db->query($sql);
            // Bind de parameter productId aan de query
            $this->db->bind(':productId', $productId);
            // Voer de query uit en retourneer het resultaat
            return $this->db->resultSet();
        } catch (Exception $e) {
            // Log de fout en gooi een nieuwe uitzondering
            error_log("Fout in getLeveringInfoByProductId: " . $e->getMessage());
            throw new Exception("Database query failed: " . $e->getMessage());
        }
    }

    public function getProductVoorraad($productId)
    {
        try {
            // SQL-query om de voorraad van een specifiek product op te halen
            $sql = "SELECT AantalAanwezig FROM Magazijn WHERE ProductId = :productId";
            $this->db->query($sql);
            // Bind de parameter productId aan de query
            $this->db->bind(':productId', $productId);
            // Voer de query uit en retourneer een enkele rij
            return $this->db->single();
        } catch (Exception $e) {
            // Log de fout en gooi een nieuwe uitzondering
            error_log("Fout in getProductVoorraad: " . $e->getMessage());
            throw new Exception("Database query failed: " . $e->getMessage());
        }
    }

    public function getAllergenenInfoByProductId($productId)
    {
        try {
            $sql = "SELECT a.Naam, a.Omschrijving
                    FROM Allergeen a
                    JOIN ProductPerAllergeen ppa ON a.Id = ppa.AllergeenId
                    WHERE ppa.ProductId = :productId
                    ORDER BY a.Naam ASC";
            $this->db->query($sql);
            // Bind de parameter productId aan de query
            $this->db->bind(':productId', $productId);
            // Voer de query uit en retourneer het resultaat
            return $this->db->resultSet();
        } catch (Exception $e) {
            // Log de fout en gooi een nieuwe uitzondering
            error_log("Fout in getAllergenenInfoByProductId: " . $e->getMessage());
            throw new Exception("Database query failed: " . $e->getMessage());
        }
    }

    public function getProductDetails($productId)
    {
        try {
            // SQL-query om de details van een specifiek product op te halen
            $sql = "SELECT Naam, Barcode FROM Product WHERE Id = :productId";
            $this->db->query($sql);
            // Bind de parameter productId aan de query
            $this->db->bind(':productId', $productId);
            // Voer de query uit en retourneer een enkele rij
            return $this->db->single();
        } catch (Exception $e) {
            // Log de fout en gooi een nieuwe uitzondering
            error_log("Fout in getProductDetails: " . $e->getMessage());
            throw new Exception("Database query failed: " . $e->getMessage());
        }
    }

    public function getProductsByAllergeen($allergeen)
    {
        try {
            $sql = "SELECT p.Id AS ProductId, p.Naam, p.Barcode, l.Naam AS LeverancierNaam, l.Contactpersoon, l.Mobiel, m.AantalAanwezig
                    FROM Product p
                    JOIN ProductPerAllergeen pa ON p.Id = pa.ProductId
                    JOIN Allergeen a ON pa.AllergeenId = a.Id
                    JOIN ProductPerLeverancier pl ON p.Id = pl.ProductId
                    JOIN Leverancier l ON pl.LeverancierId = l.Id
                    JOIN Magazijn m ON p.Id = m.ProductId
                    WHERE a.Naam = :allergeen
                    ORDER BY p.Naam ASC";
            $this->db->query($sql);
            $this->db->bind(':allergeen', $allergeen);
            return $this->db->resultSet();
        } catch (Exception $e) {
            error_log("Fout in getProductsByAllergeen: " . $e->getMessage());
            throw new Exception("Database query failed: " . $e->getMessage());
        }
    }

    public function getAllAllergenen()
    {
        try {
            $sql = "SELECT Naam FROM Allergeen ORDER BY Naam ASC";
            $this->db->query($sql);
            return $this->db->resultSet();
        } catch (Exception $e) {
            error_log("Fout in getAllAllergenen: " . $e->getMessage());
            throw new Exception("Database query failed: " . $e->getMessage());
        }
    }

    public function getSupplierInfoByProductId($productId)
    {
        try {
            $sql = "SELECT l.Naam, l.Contactpersoon, l.Mobiel, c.Straat, c.Huisnummer, c.Postcode, c.Stad
                    FROM Leverancier l
                    JOIN ProductPerLeverancier pl ON l.Id = pl.LeverancierId
                    LEFT JOIN Contact c ON l.ContactId = c.Id
                    WHERE pl.ProductId = :productId";
            $this->db->query($sql);
            $this->db->bind(':productId', $productId);
            return $this->db->single();
        } catch (Exception $e) {
            error_log("Fout in getSupplierInfoByProductId: " . $e->getMessage());
            throw new Exception("Database query failed: " . $e->getMessage());
        }
    }
}