<?php

/**
 * @OA\Get(path="/review/{id}", tags={"Review"}, summary="Get review by ID")
 */
Flight::route('GET /review/@id', function($id) {
    Flight::json(Flight::review_service()->get_by_id($id));
});

/**
 * @OA\Post(path="/review", tags={"Review"}, summary="Add review")
 */
Flight::route('POST /review', function() {
    Flight::json(Flight::review_service()->add(Flight::request()->data->getData()));
});

/**
 * @OA\Delete(path="/review/{id}", tags={"Review"}, summary="Delete review")
 */
Flight::route('DELETE /review/@id', function($id) {
    Flight::json(Flight::review_service()->delete($id));
});
