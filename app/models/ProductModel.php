<?php

class ProductModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getProductsByDateRange($startDate, $endDate)
    {
        try {
            $sql = "SELECT p.Id, p.Naam, p.Barcode, pel.EinddatumLevering
                    FROM Product p
                    JOIN ProductEinddatumLevering pel ON p.Id = pel.ProductId
                    WHERE pel.EinddatumLevering BETWEEN :startDate AND :endDate
                    ORDER BY pel.EinddatumLevering DESC";
            $this->db->query($sql);
            $this->db->bind(':startDate', $startDate);
            $this->db->bind(':endDate', $endDate);
            return $this->db->resultSet();
        } catch (Exception $e) {
            error_log("Fout in getProductsByDateRange: " . $e->getMessage());
            throw new Exception("Database query failed: " . $e->getMessage());
        }
    }

    public function getProductById($id)
    {
        try {
            $sql = "SELECT p.Id, p.Naam, p.Barcode, pel.EinddatumLevering
                    FROM Product p
                    JOIN ProductEinddatumLevering pel ON p.Id = pel.ProductId
                    WHERE p.Id = :id";
            $this->db->query($sql);
            $this->db->bind(':id', $id);
            return $this->db->single();
        } catch (Exception $e) {
            error_log("Fout in getProductById: " . $e->getMessage());
            throw new Exception("Database query failed: " . $e->getMessage());
        }
    }

    public function deleteProduct($id)
    {
        try {
            $sql = "DELETE FROM Product WHERE Id = :id";
            $this->db->query($sql);
            $this->db->bind(':id', $id);
            return $this->db->execute();
        } catch (Exception $e) {
            error_log("Fout in deleteProduct: " . $e->getMessage());
            throw new Exception("Database query failed: " . $e->getMessage());
        }
    }
}
