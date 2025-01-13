<?php
require_once 'models/Event.php';
require_once 'models/Volunteer.php';
require_once 'models/Donor.php';

class EventController {
    private $eventModel;
    private $volunteerModel;
    private $donorModel;
    private $db;

    public function __construct() {
        $this->eventModel = new Event();
        $this->volunteerModel = new Volunteer();
        $this->donorModel = new Donor();
        $this->db = Database::getInstance();

        // Register observers
        $this->eventModel->registerObserver($this->volunteerModel);
        $this->eventModel->registerObserver($this->donorModel);
    }

    // Adds a new event

    public function store() {
        $eventData = [
            'name' => $_POST['name'],
            'date' => $_POST['date'],
            'location' => $_POST['location'],
            'capacity' => $_POST['capacity']
        ];
    
        $result = $this->eventModel->addEvent($eventData);
        if ($result) {
            // Redirect to the event list page after successful creation
            header("Location: index.php?controller=event&action=list");
            exit;
        } else {
            echo "Error creating event.";
        }
    }    


    // Retrieves event information
    public function view($params) {
        if (!isset($params['id']) || empty($params['id'])) {
            die("An error occurred: Invalid event ID provided.");
        }
    
        $eventId = (int)$params['id'];
        $event = $this->eventModel->getEventById($eventId);
    
        if ($event === null) {
            die("An error occurred: Event not found.");
        }
    
        require 'views/event/view.php';
    }          

    // Updates an event’s details
    public function update($eventId, $data) {
        if (empty($eventId) || !is_array($data)) {
            echo "Invalid event ID or data.";
            return;
        }
    
        $result = $this->eventModel->updateEvent($eventId, $data);
        if ($result) {
            // Redirect back to the event list
            header("Location: index.php?controller=event&action=list");
            exit;
        } else {
            echo "Error updating event.";
        }
    }
    

    // List all events
    public function list() {
        $events = $this->eventModel->getEvents();
        
        if ($_SESSION['role'] === 'Donor') {
            include 'views/event/donor_list.php'; // Separate view for donors
        } elseif ($_SESSION['role'] === 'Volunteer') {
            include 'views/event/volunteer_list.php'; // New view for volunteers
        } else {
            include 'views/event/list.php'; // Existing view for admins
        }
    }
    

    // Display add event form
    public function add() {
        require 'views/event/add.php';
    }

    // Display edit event form
    public function edit($params) {
        if (!isset($params['id']) || empty($params['id'])) {
            die("An error occurred: Invalid event ID provided.");
        }
    
        $eventId = (int)$params['id'];
        $event = $this->eventModel->getEventById($eventId);
    
        if ($event === null) {
            die("An error occurred: Event not found.");
        }
    
        require 'views/event/edit.php';
    }    

    // Register an attendee (volunteer or donor) for an event
    public function register() {
        if (isset($_GET['event_id'])) {
            $eventId = $_GET['event_id'];
            $volunteerId = $_SESSION['user_id']; // Ensure the volunteer is logged in
    
            try {
                // Step 1: Insert attendee into the `attendee` table
                $query = "INSERT INTO attendee (ticket_status) VALUES (:ticket_status)";
                $params = [':ticket_status' => 1]; // Default ticket status
                $this->db->execute($query, $params);
    
                // Step 2: Get the last inserted attendee ID
                $attendeeId = $this->db->lastInsertId();
    
                // Step 3: Insert into `event_attendees` table
                $query = "INSERT INTO event_attendees (event_id, attendee_id) VALUES (:event_id, :attendee_id)";
                $params = [
                    ':event_id' => $eventId,
                    ':attendee_id' => $attendeeId,
                ];
    
                if ($this->db->execute($query, $params)) {
                    echo "Successfully registered for the event.";
                } else {
                    echo "Error registering for the event.";
                }
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        } else {
            echo "Event ID is missing.";
        }
    }
    
}
?>
