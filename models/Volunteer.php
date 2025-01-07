<?php
require_once 'Observer.php';
require_once 'Event.php';
require_once 'config/Database.php';
class Volunteer implements Observer {
    private $db;

    public function __construct() {
        // Use the Singleton Database instance
        $this->db = Database::getInstance();
    }

    public function update($eventData) {
        echo "Volunteer notified: Event '{$eventData['name']}' has been updated.\n";
    }


    public function getVolunteerByUserId($userId) {
        $query = "SELECT * FROM Volunteer WHERE user_id = :user_id";
        return $this->db->query($query, [':user_id' => $userId])[0] ?? null;
    }
    
    

    // Get all volunteers
    public function getVolunteers() {
        $query = "SELECT * FROM Volunteer"; 
        return $this->db->query($query);
    }

    // Get a specific volunteer by ID
    public function getVolunteerById($volunteerId) {
        $query = "SELECT * FROM Volunteer WHERE volunteer_id = :volunteer_id";
        return $this->db->query($query, [':volunteer_id' => $volunteerId])[0];
    }

    // Add a new volunteer
    public function addVolunteer($volunteerData) {
        $query = "INSERT INTO Volunteer (volunteer_id, name, contact_info, availability) 
                  VALUES (:volunteer_id, :name, :contact_info, :availability)";
        return $this->db->execute($query, $volunteerData);
    }

    // Update volunteer details
    public function updateVolunteer($volunteerData) {
        $query = "UPDATE Volunteer SET name = :name, contact_info = :contact_info, availability = :availability 
                  WHERE volunteer_id = :volunteer_id";
        return $this->db->execute($query, $volunteerData);
    }

    // Delete a volunteer
    public function deleteVolunteer($volunteerId) {
        $query = "DELETE FROM Volunteer WHERE volunteer_id = :volunteer_id";
        return $this->db->execute($query, [':volunteer_id' => $volunteerId]);
    }
}
?>
