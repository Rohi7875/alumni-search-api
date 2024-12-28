<?php

// Route API requests
if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'update_user':
            require_once __DIR__ . '/../endpoints/update_user.php';
            break;
        case 'get_alumni':
            require_once __DIR__ . '/../endpoints/get_alumni.php';
            break;
        default:
            echo json_encode(['status' => 'error', 'message' => 'Invalid action.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'No action specified.']);
}
