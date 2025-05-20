<?php
class BrandModel
{
    private $conn;
    private $table_name = "tbl_brand";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getBrand()
    {
        $query = "
            SELECT b.brand_id, b.brand_name, c.cartegory_name, b.cartegory_id
            FROM " . $this->table_name . " b
            JOIN tbl_cartegory c ON b.cartegory_id = c.cartegory_id
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function addBrand($name, $cartegory_id)
    {
        $query = "INSERT INTO " . $this->table_name . " (brand_name, cartegory_id) VALUES (:name, :cartegory_id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':cartegory_id', $cartegory_id);
        return $stmt->execute();
    }

    public function deleteBrand($id)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE brand_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function getBrandById($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE brand_id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function updateBrand($id, $name, $cartegory_id)
    {
        $query = "
            UPDATE " . $this->table_name . "
            SET brand_name = :name, cartegory_id = :cartegory_id
            WHERE brand_id = :id
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':cartegory_id', $cartegory_id);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>
