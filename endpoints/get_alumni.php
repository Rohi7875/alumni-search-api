<?php

// Include the database connection
require_once __DIR__ . '/../config/db.php';

// Check if the request method is GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $userId = isset($_GET['user_id']) ? (int)$_GET['user_id'] : null;
    $radius = isset($_GET['radius']) ? (float)$_GET['radius'] : null;

    if (!$userId || !$radius) {
        echo json_encode(['status' => 'error', 'message' => 'Missing required parameters.']);
        exit;
    }

    // Fetch user location
    $db->where('id', $userId);
    $user = $db->getOne('users', ['latitude', 'longitude']);

    if (!$user) {
        echo json_encode(['status' => 'error', 'message' => 'User not found.']);
        exit;
    }

    $latitude = $user['latitude'];
    $longitude = $user['longitude'];

    // Query to find nearby alumni
    $query = "\n        SELECT \n            u.id, u.name, u.email, u.latitude, u.longitude, \n            GROUP_CONCAT(n.name) AS networks\n        FROM users u\n        JOIN user_networks un ON u.id = un.user_id\n        JOIN alumni_networks n ON un.network_id = n.id\n        WHERE (\n            6371 * acos(\n                cos(radians(?)) *\n                cos(radians(u.latitude)) *\n                cos(radians(u.longitude) - radians(?)) +\n                sin(radians(?)) * sin(radians(u.latitude))\n            )\n        ) <= ?\n        AND u.id != ?\n        GROUP BY u.id\n    ";

    $results = $db->rawQuery($query, [$latitude, $longitude, $latitude, $radius, $userId]);

    echo json_encode(['status' => 'success', 'data' => $results]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
