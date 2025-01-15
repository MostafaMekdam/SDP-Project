<?php
require_once 'Command.php';
require_once 'models/Event.php';
require_once 'config/Database.php';

class UnregisterVolunteerCommand implements Command {
    private $eventId;
    private $volunteerId;
    private $db;

    public function __construct($eventId, $volunteerId) {
        $this->eventId = $eventId;
        $this->volunteerId = $volunteerId;
        $this->db = Database::getInstance();
    }

    public function execute() {
        try {
            // Remove volunteer from attendees
            $query = "DELETE FROM Event_Attendees WHERE event_id = :event_id AND attendee_id = :volunteer_id";
            $this->db->execute($query, [
                ':event_id' => $this->eventId,
                ':volunteer_id' => $this->volunteerId,
            ]);

            // Remove volunteer from observers
            $query = "DELETE FROM Event_Observers WHERE event_id = :event_id AND user_id = :volunteer_id";
            $this->db->execute($query, [
                ':event_id' => $this->eventId,
                ':volunteer_id' => $this->volunteerId,
            ]);

            // Notify the volunteer
            $query = "INSERT INTO Inbox (user_id, message) VALUES (:user_id, :message)";
            $message = "You have been unregistered from Event ID: {$this->eventId}.";
            $this->db->execute($query, [
                ':user_id' => $this->volunteerId,
                ':message' => $message,
            ]);

            echo "Volunteer unregistered successfully.";
        } catch (Exception $e) {
            echo "Error while unregistering volunteer: " . $e->getMessage();
        }
    }

    public function undo() {
        // Re-add volunteer as attendee
        $query = "INSERT INTO Event_Attendees (event_id, attendee_id) VALUES (:event_id, :volunteer_id)";
        $this->db->execute($query, [
            ':event_id' => $this->eventId,
            ':volunteer_id' => $this->volunteerId,
        ]);

        // Re-add volunteer as observer
        $query = "INSERT INTO Event_Observers (event_id, user_id) VALUES (:event_id, :volunteer_id)";
        $this->db->execute($query, [
            ':event_id' => $this->eventId,
            ':volunteer_id' => $this->volunteerId,
        ]);

        echo "Undo successful: Volunteer re-registered.";
    }
}
