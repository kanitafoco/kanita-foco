<?php
require_once 'BaseDAO.php';

class ReviewDAO extends BaseDAO {

    public function __construct() {
        parent::__construct('reviews');
    }

    public function create($data) {
        return $this->add($data);
    }

    public function getByRecipe($recipeId) {
        return $this->query("
            SELECT r.*, u.name AS user_name
            FROM {$this->table_name} r
            JOIN users u ON r.user_id = u.id
            WHERE r.recipe_id = :recipe_id
            ORDER BY r.created_at DESC", ['recipe_id' => $recipeId]);
    }

    public function getAverageRating($recipeId) {
        $result = $this->query_unique("
            SELECT AVG(rating) AS avg_rating
            FROM {$this->table_name}
            WHERE recipe_id = :recipe_id", ['recipe_id' => $recipeId]);
        return $result['avg_rating'] ? round((float)$result['avg_rating'], 2) : null;
    }
}


