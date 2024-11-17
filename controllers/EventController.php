<?php
require_once 'models/Event.php';
require_once 'models/Volunteer.php';
require_once 'models/Donor.php';

class EventController {
    private $eventModel;
    private $volunteerModel;
    private $donorModel;

    public function __construct() {
        $this->eventModel = new Event();
        $this->volunteerModel = new Volunteer();
        $this->donorModel = new Donor();

        // Register observers
        $this->eventModel->registerObserver($this->volunteerModel);
        $this->eventModel->registerObserver($this->donorModel);
    }

    // Adds a new event
    public function store($data) {
        $result = $this->eventModel->addEvent($data);
        if ($result) {
            echo "Event created successfully.";
        } else {
            echo "Error creating event.";
        }
    }

    // Retrieves event information
    public function view($eventId) {
        $event = $this->eventModel->getEventById($eventId);
        require 'views/event/view.php';
    }

    // Updates an event’s details
    public function update($eventId, $data) {
        $result = $this->eventModel->updateEvent($eventId, $data);
        if ($result) {
            echo "Event updated successfully.";
        } else {
            echo "Error updating event.";
        }
    }

    // List all events
    public function list() {
        $events = $this->eventModel->getEvents();
        require 'views/event/list.php';
    }

    // Display add event form
    public function add() {
        require 'views/event/add.php';
    }

    // Display edit event form
    public function edit($eventId) {
        $event = $this->eventModel->getEventById($eventId);
        require 'views/event/edit.php';
    }
}
?>
