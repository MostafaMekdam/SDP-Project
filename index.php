<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start the session for authentication
session_start();

// Load required controllers
require_once 'controllers/BeneficiaryController.php';
require_once 'controllers/CommunicationController.php';
require_once 'controllers/DonorController.php';
require_once 'controllers/EventController.php';
require_once 'controllers/VolunteerController.php';
require_once 'controllers/AuthController.php';

// Utility functions
function isLoggedIn() {
    return isset($_SESSION['user_id']) && isset($_SESSION['role']);
}

function checkAccess($requiredRole) {
    if (!isLoggedIn() || $_SESSION['role'] !== $requiredRole) {
        header("Location: index.php?controller=auth&action=loginForm");
        exit;
    }
}

// Router Class to handle requests
class Router {
    private $routes = [];
    public function __construct() {
    $this->routes = [
        'beneficiary' => BeneficiaryController::class,
        'communication' => CommunicationController::class,
        'donor' => DonorController::class,
        'event' => EventController::class,
        'volunteer' => VolunteerController::class,
        'auth' => AuthController::class,
    ];
    }
    public function route($controller, $action, $params = []) {
        if (array_key_exists($controller, $this->routes)) {
            $controllerClass = $this->routes[$controller];
            $controllerFile = "controllers/{$controllerClass}.php";
            
            if (!file_exists($controllerFile)) {
                echo "Error: Controller file '{$controllerFile}' not found.";
                return;
            }
    
            require_once $controllerFile;
    
            // Instantiate the controller
            $controllerInstance = new $controllerClass();
    
            // Verify that the method exists
            if (method_exists($controllerInstance, $action)) {
                call_user_func_array([$controllerInstance, $action], $params);
            } else {
                echo "Error: Action '$action' not found in controller '$controllerClass'.";
            }
        } else {
            echo "Error: Controller '$controller' not found.";
        }
    }
    
}

// Function to display the User Control Panel
function displayUserControlPanel() {
    echo "<h1>Non-Profit Management System</h1>";
    echo "<ul>";
    if ($_SESSION['role'] === 'Admin') {
        echo "<li><a href='?controller=beneficiary&action=listBeneficiaries'>Manage Beneficiaries</a></li>";
        echo "<li><a href='?controller=communication&action=listCommunications'>Manage Communications</a></li>";
        echo "<li><a href='?controller=donor&action=listDonors'>Manage Donors</a></li>";
        echo "<li><a href='?controller=event&action=list'>Manage Events</a></li>";
        echo "<li><a href='?controller=volunteer&action=listVolunteers'>Manage Volunteers</a></li>";
    } elseif ($_SESSION['role'] === 'Donor') {
        echo "<li><a href='?controller=donor&action=view'>My Donations</a></li>";
        echo "<li><a href='?controller=event&action=list'>View Events</a></li>";
    } elseif ($_SESSION['role'] === 'Volunteer') {
        echo "<li><a href='?controller=event&action=list'>View Events</a></li>";
        echo "<li><a href='?controller=volunteer&action=skills'>My Skills</a></li>";
    }
    echo "</ul>";
    echo "<a href='?controller=auth&action=logout'>Logout</a>";
}

// Main Entry Logic
$controller = $_GET['controller'] ?? null;
$action = $_GET['action'] ?? null;
$params = array_slice($_GET, 2);

echo "Routing to controller: $controller, action: $action"; // Debugging line

$router = new Router();
$router->route($controller, $action, $params);

// Redirect unauthenticated users to login
if (!isLoggedIn()) {
    $controller = 'auth';
    $action = 'login';
}

// Route or display control panel
if ($controller && $action) {
    $router->route($controller, $action, $params);
} else {
    displayUserControlPanel();
}
?>
