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
    public function update($params) {
        $eventId = $params['id'] ?? null;
        unset($params['id']); // Remove `id` from data
        $data = $params;
    
        if (empty($eventId) || !is_array($data)) {
            echo "Invalid event ID or data.";
            return;
        }
    
        $result = $this->eventModel->updateEvent($eventId, $data);
        if ($result) {
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

    public function register() {
        if (isset($_GET['event_id'])) {
            $eventId = $_GET['event_id'];
            $userId = $_SESSION['user_id']; // Logged-in user's ID
    
            try {
                // Step 1: Add user as an observer to the event
                $observerQuery = "INSERT IGNORE INTO Event_Observers (event_id, user_id) VALUES (:event_id, :user_id)";
                $this->db->execute($observerQuery, [
                    ':event_id' => $eventId,
                    ':user_id' => $userId,
                ]);
    
                // Step 2: Check if the user is already a volunteer
                $volunteerQuery = "SELECT volunteer_id FROM Volunteer WHERE user_id = :user_id";
                $volunteer = $this->db->query($volunteerQuery, [':user_id' => $userId]);
    
                if (!$volunteer) {
                    throw new Exception("The logged-in user is not a volunteer.");
                }
    
                $volunteerId = $volunteer[0]['volunteer_id']; // Retrieve the volunteer ID
    
                // Step 3: Ensure the attendee exists in the Attendee table
                $attendeeQuery = "INSERT IGNORE INTO Attendee (attendee_id, ticket_status) VALUES (:attendee_id, 1)";
                $this->db->execute($attendeeQuery, [
                    ':attendee_id' => $volunteerId,
                ]);
    
                // Step 4: Link the attendee to the event
                $eventAttendeeQuery = "INSERT INTO Event_Attendees (event_id, attendee_id) VALUES (:event_id, :attendee_id)";
                $this->db->execute($eventAttendeeQuery, [
                    ':event_id' => $eventId,
                    ':attendee_id' => $volunteerId,
                ]);
    
                // Step 5: Add a notification to the volunteer's inbox
                $notificationQuery = "INSERT INTO Inbox (user_id, message) VALUES (:user_id, :message)";
                $message = "You have successfully registered for Event ID: $eventId and will receive updates.";
                $this->db->execute($notificationQuery, [
                    ':user_id' => $userId,
                    ':message' => $message,
                ]);
    
                echo "Successfully registered for the event and added as an observer.";
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        } else {
            echo "Error: Event ID is missing.";
        }
    }
    
    

    public function listAttendees() {
        if (isset($_GET['event_id'])) {
            $eventId = $_GET['event_id'];
    
            try {
                // Get the iterator for attendees
                $iterator = $this->eventModel->getAttendeeIterator($eventId);
                
                // Convert iterator to an array for the view
                $attendees = [];
                foreach ($iterator as $attendee) {
                    $attendees[] = $attendee;
                }
    
                // Include the view
                include 'views/event/attendees.php';
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        } else {
            echo "Event ID is missing.";
        }
    }


       // List volunteers for a specific event
    public function listVolunteers() {
        if (isset($_GET['event_id'])) {
            $eventId = (int)$_GET['event_id'];

            try {
                // Step 1: Validate event existence
                $event = $this->eventModel->getEventById($eventId);
                if (!$event) {
                    throw new Exception("The event does not exist.");
                }

                // Step 2: Fetch the list of volunteers attending the event
                $query = "
                    SELECT Volunteer.name, Volunteer.contact_info 
                    FROM Event_Attendees
                    JOIN Volunteer ON Volunteer.volunteer_id = Event_Attendees.attendee_id
                    WHERE Event_Attendees.event_id = :event_id
                ";
                $volunteers = $this->db->query($query, [':event_id' => $eventId]);

                // Include the view
                include 'views/event/volunteer_attendees.php';
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        } else {
            echo "Error: Event ID is missing.";
        }
    }
    
    
}
?>
