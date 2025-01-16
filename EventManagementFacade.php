<?php
require_once 'models/Event.php';
require_once 'models/Volunteer.php';
require_once 'config/Database.php';

class EventManagementFacade {
    private $eventModel;
    private $volunteerModel;
    private $db;

    public function __construct() {
        $this->eventModel = new Event();
        $this->volunteerModel = new Volunteer();
        $this->db = Database::getInstance();
    }

    // Create a new event
    public function createEvent($eventData) {
        try {
            $result = $this->eventModel->addEvent($eventData);
            return $result ? "Event created successfully." : "Failed to create event.";
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    // Update an existing event
    public function updateEvent($eventId, $eventData) {
        try {
            $result = $this->eventModel->updateEvent($eventId, $eventData);
            return $result ? "Event updated successfully." : "Failed to update event.";
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    // Register a volunteer to an event
    public function registerVolunteer($eventId, $volunteerId) {
        try {
            // Check if the volunteer exists in the Attendee table
            $attendeeCheckQuery = "SELECT attendee_id FROM Attendee WHERE attendee_id = :volunteer_id";
            $attendeeCheckResult = $this->db->query($attendeeCheckQuery, [':volunteer_id' => $volunteerId]);
    
            // Insert into Attendee table if not already present
            if (empty($attendeeCheckResult)) {
                $this->db->execute(
                    "INSERT INTO Attendee (attendee_id, ticket_status) VALUES (:volunteer_id, 1)",
                    [':volunteer_id' => $volunteerId]
                );
            }
    
            // Add volunteer to Event_Attendees
            $this->db->execute(
                "INSERT INTO Event_Attendees (event_id, attendee_id) VALUES (:event_id, :volunteer_id)",
                [':event_id' => $eventId, ':volunteer_id' => $volunteerId]
            );
    
            // Add volunteer as an observer
            $this->db->execute(
                "INSERT INTO Event_Observers (event_id, user_id) VALUES (:event_id, :volunteer_id)",
                [':event_id' => $eventId, ':volunteer_id' => $volunteerId]
            );
    
            // Send notification
            $this->sendNotification($volunteerId, "You are registered for Event ID: $eventId");
    
            return "Volunteer registered successfully.";
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }    

    // Unregister a volunteer from an event
    public function unregisterVolunteer($eventId, $volunteerId) {
        try {
            // Remove volunteer from Event_Attendees
            $this->db->execute(
                "DELETE FROM Event_Attendees WHERE event_id = :event_id AND attendee_id = :volunteer_id",
                [':event_id' => $eventId, ':volunteer_id' => $volunteerId]
            );

            // Remove volunteer as an observer
            $this->db->execute(
                "DELETE FROM Event_Observers WHERE event_id = :event_id AND user_id = :volunteer_id",
                [':event_id' => $eventId, ':volunteer_id' => $volunteerId]
            );

            // Send notification
            $this->sendNotification($volunteerId, "You have been unregistered from Event ID: $eventId");

            return "Volunteer unregistered successfully.";
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    // List event attendees
    public function listEventAttendees($eventId) {
        try {
            $query = "SELECT Volunteer.name, Volunteer.contact_info 
                      FROM Event_Attendees
                      JOIN Volunteer ON Volunteer.volunteer_id = Event_Attendees.attendee_id
                      WHERE Event_Attendees.event_id = :event_id";
            return $this->db->query($query, [':event_id' => $eventId]);
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    // List event volunteers
    public function listEventVolunteers($eventId) {
        return $this->listEventAttendees($eventId); // Reuse the same logic
    }

    // Send notification to a user
    private function sendNotification($userId, $message) {
        $this->db->execute(
            "INSERT INTO Inbox (user_id, message) VALUES (:user_id, :message)",
            [':user_id' => $userId, ':message' => $message]
        );
    }

    // Get event details
    public function getEventDetails($eventId) {
        return $this->eventModel->getEventById($eventId);
    }

    // List all events
    public function listAllEvents() {
        return $this->eventModel->getEvents();
    }
}
