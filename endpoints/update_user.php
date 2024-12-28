<?php

// Include the database connection
require_once __DIR__ . '/../config/db.php';

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Decode JSON input
    $data = json_decode(file_get_contents('php://input'), true);

    // Validate input data
    if (!isset($data['id'], $data['name'], $data['email'], $data['latitude'], $data['longitude'], $data['networks'])) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid input. Required fields: id, name, email, latitude, longitude, networks.']);
        exit;
    }

    // Assign data to variables
    $userId = $data['id'];
    $updateData = [
        'name' => $data['name'],
        'email' => $data['email'],
        'latitude' => $data['latitude'],
        'longitude' => $data['longitude']
    ];

    // Validate that the user exists
    $db->where('id', $userId);
    $user = $db->getOne('users');
    if (!$user) {
        echo json_encode(['status' => 'error', 'message' => 'User ID does not exist.']);
        exit;
    }

    // Validate network IDs
    $validNetworkIds = $db->getValue('alumni_networks', 'id', null);
    $invalidNetworks = array_diff($data['networks'], $validNetworkIds);
    if (!empty($invalidNetworks)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid network IDs: ' . implode(', ', $invalidNetworks)]);
        exit;
    }

    // Update user details
    $db->where('id', $userId);
    if ($db->update('users', $updateData)) {
        // Remove old network associations
        $db->where('user_id', $userId);
        if (!$db->delete('user_networks')) {
            echo json_encode(['status' => 'error', 'message' => 'Failed to clear old network associations.']);
            exit;
        }

        // Add new associations
        foreach ($data['networks'] as $networkId) {
            $db->insert('user_networks', ['user_id' => $userId, 'network_id' => $networkId]);
        }

        echo json_encode(['status' => 'success', 'message' => 'User details updated successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update user details.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method. Use POST.']);
}
