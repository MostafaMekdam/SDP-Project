<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start the session for authentication
session_start();

// Autoload required classes
spl_autoload_register(function ($class) {
    $paths = ["controllers", "."];
    foreach ($paths as $path) {
        $file = __DIR__ . "/{$path}/{$class}.php";
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Utility functions
function isLoggedIn() {
    return isset($_SESSION['user_id']) && isset($_SESSION['role']);
}

function redirectToLogin() {
    header("Location: index.php?controller=auth&action=login");
    exit;
}

function checkAccess($requiredRole) {
    if (!isLoggedIn() || $_SESSION['role'] !== $requiredRole) {
        redirectToLogin();
    }
}

// Define route mappings
$routes = [
    'beneficiary' => BeneficiaryController::class,
    'communication' => CommunicationController::class,
    'donor' => DonorController::class,
    'event' => EventController::class,
    'volunteer' => VolunteerController::class,
    'auth' => AuthController::class,
    'admin' => AdminController::class,
];

// Instantiate Router with route definitions
$router = new Router($routes);

// Display User Control Panel based on role
function displayUserControlPanel() {
    echo "<h1>Non-Profit Management System</h1><ul>";
    switch ($_SESSION['role'] ?? '') {
        case 'Admin':
            echo "<li><a href='?controller=beneficiary&action=listBeneficiaries'>Manage Beneficiaries</a></li>";
            echo "<li><a href='?controller=communication&action=listCommunications'>Manage Communications</a></li>";
            echo "<li><a href='?controller=donor&action=listDonors'>Manage Donors</a></li>";
            echo "<li><a href='?controller=event&action=list'>Manage Events</a></li>";
            echo "<li><a href='?controller=volunteer&action=listVolunteers'>Manage Volunteers</a></li>";
            break;
        case 'Donor':
            echo "<li><a href='?controller=donor&action=view'>My Donations</a></li>";
            echo "<li><a href='?controller=event&action=list'>View Events</a></li>";
            break;
        case 'Volunteer':
            echo "<li><a href='?controller=event&action=list'>View Events</a></li>";
            echo "<li><a href='?controller=volunteer&action=viewSkills'>My Skills</a></li>";
            echo "<li><a href='?controller=volunteer&action=chooseSkills'>Add Skills</a></li>";
            break;
        default:
            redirectToLogin();
    }
    echo "</ul><a href='?controller=auth&action=logout'>Logout</a>";
}

// Main Logic
$controller = $_GET['controller'] ?? null;
$action = $_GET['action'] ?? null;
$params = ($_SERVER['REQUEST_METHOD'] === 'POST') ? $_POST : $_GET;

try {
    // Debugging log for route parameters
    error_log("Received Parameters: " . print_r($params, true));

    if ($controller && $action) {
        $router->route($controller, $action, $params);
    } elseif (isLoggedIn()) {
        displayUserControlPanel();
    } else {
        redirectToLogin();
    }
} catch (Exception $e) {
    // Handle exceptions gracefully
    http_response_code(500);
    echo "<h1>Internal Server Error</h1><p>" . htmlspecialchars($e->getMessage()) . "</p>";
    error_log("Exception: " . $e->getMessage());
}
