<?php
require_once 'Subject.php'; // Include the Subject interface
require_once 'Observer.php'; // Include the Observer interface
require_once 'config/Database.php';


class Event implements Subject {
    private $db;
    private $observers = [];

    public function __construct() {
        $this->db = Database::getInstance(); // Use Singleton for database instance
    }

    public function registerObserver(Observer $observer) {
        $this->observers[] = $observer;
    }

    public function removeObserver(Observer $observer) {
        $index = array_search($observer, $this->observers);
        if ($index !== false) {
            unset($this->observers[$index]);
        }
    }

    public function notifyObservers() {
        foreach ($this->observers as $observer) {
            $observer->update($this->getLastEventData());
        }
    }

    private function getLastEventData() {
        $query = "SELECT * FROM event ORDER BY event_id DESC LIMIT 1";
        $result = $this->db->query($query);
        return $result !== false && count($result) > 0 ? $result[0] : null; // Return the first result or null if no result is found
    }

    public function addEvent($data) {
        $query = "INSERT INTO event (name, date, location, capacity) 
                  VALUES (:name, :date, :location, :capacity)";
        $result = $this->db->execute($query, $data);

        if ($result) {
            $this->notifyObservers();
        }

        return $result;
    }

    public function getEvents() {
        $query = "SELECT * FROM event";
        return $this->db->query($query);
    }

    public function getEventById($eventId) {
        $query = "SELECT * FROM event WHERE event_id = :event_id";
        $result = $this->db->query($query, ['event_id' => $eventId]);
        return $result !== false && count($result) > 0 ? $result[0] : null; // Return the first result or null if no result is found
    }

    public function updateEvent($eventId, $data) {
        $query = "UPDATE event 
                  SET name = :name, date = :date, location = :location, capacity = :capacity
                  WHERE event_id = :event_id";
        return $this->db->execute($query, array_merge($data, ['event_id' => $eventId]));
    }

    public function deleteEvent($eventId) {
        $query = "DELETE FROM event WHERE event_id = :event_id";
        return $this->db->execute($query, ['event_id' => $eventId]);
    }
}
?>
