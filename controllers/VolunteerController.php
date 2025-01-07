<?php
require_once 'models/Volunteer.php';
require_once "C:/xampp/htdocs/projects/MVC/VolunteerDecorators.php";

class VolunteerController {
    private $volunteerModel;
    private $db;

    public function __construct() {
        // Initialize the Volunteer model
        $this->volunteerModel = new Volunteer();
        $this->db = Database::getInstance();
    }

    // Adds a new volunteer
    public function addVolunteer($data) {
        $volunteerData = [
            ':volunteer_id' => $data[':volunteer_id'],
            ':name' => $data[':name'],
            ':contact_info' => $data[':contact_info'],
            ':availability' => isset($data[':availability']) ? 1 : 0
        ];

        $result = $this->volunteerModel->addVolunteer($volunteerData);

        // Applying decorator pattern to add skills
        if ($result) {
            $volunteer = $this->volunteerModel->getVolunteerById($data[':volunteer_id']);
            $decoratedVolunteer = new SkillDecorator($volunteer);
            $decoratedVolunteer->addSkill('First Aid');
            $decoratedVolunteer->addSkill('CPR');
            $decoratedVolunteer->displaySkills();
            echo "Volunteer added successfully.";
        } else {
            echo "Error adding volunteer.";
        }
    }

    // Retrieves volunteer information
    public function getVolunteer($volunteerId) {
        $volunteer = $this->volunteerModel->getVolunteerById($volunteerId);
        require 'views/volunteer/view.php';
    }

    // Updates a volunteer’s details
    public function updateVolunteer($volunteerId, $data) {
        $data[':volunteer_id'] = $volunteerId;
        $result = $this->volunteerModel->updateVolunteer($data);
        echo $result ? "Volunteer updated successfully." : "Error updating volunteer.";
    }

    // List all volunteers
    public function listVolunteers() {
        $volunteers = $this->volunteerModel->getVolunteers();
        require 'views/volunteer/list.php';
    }


    public function addSkills() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $volunteerId = $_SESSION['user_id']; // Ensure the volunteer is logged in
            $volunteer = $this->volunteerModel->getVolunteerById($volunteerId);
    
            // Apply decorator pattern to add skills
            $decoratedVolunteer = new SkillDecorator($volunteer);
            $decoratedVolunteer->addSkill('First Aid');
            $decoratedVolunteer->addSkill('CPR');
            $decoratedVolunteer->displaySkills();
    
            echo "Skills added successfully.";
        } else {
            include 'views/volunteer/add_skills.php'; // Create this view
        }
    }

    
}
?>
