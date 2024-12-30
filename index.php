<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Load all required controllers
require_once 'controllers/BeneficiaryController.php';
require_once 'controllers/CommunicationController.php';
require_once 'controllers/DonorController.php';
require_once 'controllers/EventController.php';
require_once 'controllers/VolunteerController.php';

// Router Class to handle requests
class Router {
    private $routes = [
        'beneficiary' => BeneficiaryController::class,
        'communication' => CommunicationController::class,
        'donor' => DonorController::class,
        'event' => EventController::class,
        'volunteer' => VolunteerController::class,
    ];

    public function route($controller, $action, $params) {
        if (array_key_exists($controller, $this->routes)) {
            $controllerClass = $this->routes[$controller];
            $controllerInstance = new $controllerClass();

            if (method_exists($controllerInstance, $action)) {
                call_user_func_array([$controllerInstance, $action], $params);
            } else {
                echo "Error: Action '$action' not found in controller '$controller'.";
            }
        } else {
            echo "Error: Controller '$controller' not found.";
        }
    }
}

// Function to display the User Control Panel
function displayUserControlPanel() {
    echo "<h1>Non-Profit Management System</h1>";
    echo "<ul>
        <li><a href='?controller=beneficiary&action=listBeneficiaries'>Manage Beneficiaries</a></li>
        <li><a href='?controller=communication&action=listCommunications'>Manage Communications</a></li>
        <li><a href='?controller=donor&action=listDonors'>Manage Donors</a></li>
        <li><a href='?controller=event&action=list'>Manage Events</a></li>
        <li><a href='?controller=volunteer&action=listVolunteers'>Manage Volunteers</a></li>
    </ul>";
}

// Main Entry Logic
$controller = $_GET['controller'] ?? null;
$action = $_GET['action'] ?? null;
$params = array_slice($_GET, 2);

$router = new Router();

if ($controller && $action) {
    $router->route($controller, $action, $params);
} else {
    displayUserControlPanel();
}
?>
