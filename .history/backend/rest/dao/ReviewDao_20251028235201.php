<?php
require_once 'BaseDAO.php';

class ReviewDAO extends BaseDAO {

    public function __construct() {
        parent::__construct('reviews');
    }

    public function create($data) {
        return $this->add($data);
    }

    public function getByProduct($productId) {
        return $this->query("
            SELECT r.*, u.full_name AS user_name 
            FROM {$this->table_name} r
            JOIN users u ON r.user_id = u.user_id
            WHERE r.product_id = :product_id
            ORDER BY r.created_at DESC", ['product_id' => $productId]);
    }

    public function getAverageRating($productId) {
        $result = $this->query_unique("
            SELECT AVG(rating) AS avg_rating 
            FROM {$this->table_name} 
            WHERE product_id = :product_id", ['product_id' => $productId]);
        return $result['avg_rating'] ? round((float)$result['avg_rating'], 2) : null;
    }

    public function deleteByUser($userId) {
        $stmt = $this->connection->prepare("DELETE FROM {$this->table_name} WHERE user_id = :user_id");
        $stmt->bindValue(':user_id', $userId);
        return $stmt->execute();
    }
}
?>
