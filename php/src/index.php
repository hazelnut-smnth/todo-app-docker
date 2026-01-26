<?php
/**
 * Application Entry Point
 * Routes all requests to appropriate controller actions
 */

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include CSRF protection
require_once __DIR__ . '/csrf.php';

require_once __DIR__ . '/controllers/TaskController.php';

$controller = new TaskController();
$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'index':
        $controller->index();
        break;
    
    case 'create':
        $controller->create();
        break;
    
    case 'update':
        $controller->update();
        break;
    
    case 'delete':
        $controller->delete();
        break;
    
    case 'toggle':
        $controller->toggle();
        break;
}