<?php

class LeverancierModel
{
    private $db;

    public function __construct()
    {
        // Initialiseer de database-verbinding
        $this->db = new Database();
    }

    public function getAllLeveranciers()
    {
        try {
            $sql = "SELECT l.Id, l.Naam, l.Contactpersoon, l.Mobiel, l.Leveranciernummer, COUNT(pl.ProductId) AS AantalProducten
                    FROM Leverancier l
                    LEFT JOIN ProductPerLeverancier pl ON l.Id = pl.LeverancierId
                    GROUP BY l.Id, l.Naam, l.Contactpersoon, l.Mobiel, l.Leveranciernummer
                    ORDER BY l.Naam ASC";
            $this->db->query($sql);
            return $this->db->resultSet();
        } catch (Exception $e) {
            error_log("Fout in getAllLeveranciers: " . $e->getMessage());
            throw new Exception("Database query failed: " . $e->getMessage());
        }
    }

    public function getGeleverdeProducten($leverancierId)
    {
        try {
            // SQL-query om de geleverde producten van een specifieke leverancier op te halen
            $sql = "CALL spGetGeleverdeProducten(:leverancierId)";
            $this->db->query($sql);
            // Bind de parameter leverancierId aan de query
            $this->db->bind(':leverancierId', $leverancierId);
            return $this->db->resultSet();
        } catch (Exception $e) {
            // Log de fout en gooi een nieuwe uitzondering
            error_log("Fout in getGeleverdeProducten: " . $e->getMessage());
            throw new Exception("Database query failed: " . $e->getMessage());
        }
    }

    public function updateProduct($id, $aantal, $datum)
    {
        try {
            $sql = 'UPDATE Magazijn SET AantalAanwezig = AantalAanwezig + :aantal, DatumGewijzigd = :datum WHERE ProductId = :id';
            $this->db->query($sql);
            $this->db->bind(':id', $id);
            $this->db->bind(':aantal', $aantal);
            $this->db->bind(':datum', $datum);
            $this->db->execute();

            // Update de datum van de laatste levering in de ProductPerLeverancier tabel
            $sql = 'UPDATE ProductPerLeverancier SET DatumLevering = :datum WHERE ProductId = :id';
            $this->db->query($sql);
            $this->db->bind(':id', $id);
            $this->db->bind(':datum', $datum);
            return $this->db->execute();
        } catch (Exception $e) {
            // Log de fout en gooi een nieuwe uitzondering
            error_log("Fout in updateProduct: " . $e->getMessage());
            throw new Exception("Database query failed: " . $e->getMessage());
        }
    }

    public function getProductById($id)
    {
        try {
            $sql = 'SELECT * FROM Product WHERE Id = :id';
            $this->db->query($sql);
            $this->db->bind(':id', $id);
            return $this->db->single();
        } catch (Exception $e) {
            // Log de fout en gooi een nieuwe uitzondering
            error_log("Fout in getProductById: " . $e->getMessage());
            throw new Exception("Database query failed: " . $e->getMessage());
        }
    }

    public function getLeverancierByProductId($productId)
    {
        try {
            $sql = '
                SELECT l.Naam, l.Contactpersoon, l.Mobiel, l.Leveranciernummer, COUNT(p.Id) AS AantalProducten, MAX(pl.DatumLevering) AS DatumEerstVolgendeLevering
                FROM Leverancier l
                JOIN ProductPerLeverancier pl ON l.Id = pl.LeverancierId
                JOIN Product p ON pl.ProductId = p.Id
                WHERE p.Id = :productId
                GROUP BY l.Naam, l.Contactpersoon, l.Mobiel, l.Leveranciernummer
            ';
            $this->db->query($sql);
            $this->db->bind(':productId', $productId);
            return $this->db->single();
        } catch (Exception $e) {
            // Log de fout en gooi een nieuwe uitzondering
            error_log("Fout in getLeverancierByProductId: " . $e->getMessage());
            throw new Exception("Database query failed: " . $e->getMessage());
        }
    }

    public function getLeverancierById($leverancierId)
    {
        try {
            $sql = 'SELECT l.*, COUNT(pl.ProductId) AS AantalProducten
                    FROM Leverancier l
                    LEFT JOIN ProductPerLeverancier pl ON l.Id = pl.LeverancierId
                    WHERE l.Id = :leverancierId
                    GROUP BY l.Id';
            $this->db->query($sql);
            $this->db->bind(':leverancierId', $leverancierId);
            return $this->db->single();
        } catch (Exception $e) {
            // Log de fout en gooi een nieuwe uitzondering
            error_log("Fout in getLeverancierById: " . $e->getMessage());
            throw new Exception("Database query failed: " . $e->getMessage());
        }
    }

    public function updateLeverancier($data)
    {
        try {
            $sql = 'UPDATE Leverancier SET Naam = :naam, Contactpersoon = :contactpersoon, Leveranciernummer = :leveranciernummer, Mobiel = :mobiel WHERE Id = :id';
            $this->db->query($sql);
            $this->db->bind(':id', $data['id']);
            $this->db->bind(':naam', $data['naam']);
            $this->db->bind(':contactpersoon', $data['contactpersoon']);
            $this->db->bind(':leveranciernummer', $data['leveranciernummer']);
            $this->db->bind(':mobiel', $data['mobiel']);
            return $this->db->execute();
        } catch (Exception $e) {
            error_log("Fout in updateLeverancier: " . $e->getMessage());
            throw new Exception("Database query failed: " . $e->getMessage());
        }
    }
}