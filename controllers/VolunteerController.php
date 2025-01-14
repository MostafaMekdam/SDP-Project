<?php
require_once 'models/Volunteer.php';
require_once __DIR__ . '/../VolunteerDecorators.php';

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
            $volunteer = $this->volunteerModel->getVolunteerByUserId($data[':volunteer_id']);

            if ($volunteer === null) {
                echo "Volunteer not found.";
                return;
            }
            
            echo "Volunteer added successfully.";
        } else {
            echo "Error adding volunteer.";
        }
    }

    // Retrieves volunteer information
    public function getVolunteer($volunteerId) {
        $volunteer = $this->volunteerModel->getVolunteerByUserId($volunteerId);
        require 'views/volunteer/view.php';
    }

    // Updates a volunteer’s details
    public function updateVolunteer($volunteerId, $data) {
        $data[':volunteer_id'] = $volunteerId;
        $result = $this->volunteerModel->updateVolunteer($data);
        echo $result ? "Volunteer updated successfully." : "Error updating volunteer.";
    }

    public function viewInbox() {
        $userId = $_SESSION['user_id']; // Get the logged-in user ID
    
        // Fetch notifications
        $query = "SELECT * FROM Inbox WHERE user_id = :user_id ORDER BY timestamp DESC";
        $notifications = $this->db->query($query, [':user_id' => $userId]);
    
        // Mark all notifications as read
        $this->db->execute("UPDATE Inbox SET is_read = TRUE WHERE user_id = :user_id", [':user_id' => $userId]);
    
        include 'views/inbox.php';
    }
    

    // List all volunteers
    public function listVolunteers() {
        $volunteers = $this->volunteerModel->getVolunteers();
        require 'views/volunteer/list.php';
    }


        // Displays logged-in volunteer's skills
        public function viewSkills() {
            $userId = $_SESSION['user_id'];
    
            // Fetch volunteer by user_id
            $volunteer = $this->volunteerModel->getVolunteerByUserId($userId);
    
            if (!$volunteer) {
                echo "Error: Volunteer not found.";
                return;
            }
    
            $decoratedVolunteer = new SkillDecorator($volunteer);
            $skills = $decoratedVolunteer->getSkills();
    
            // Pass data to the view
            include 'views/volunteer/view_skills.php';
        }
    
        // Displays the choose_skills.php view
        public function chooseSkills() {
            $userId = $_SESSION['user_id'];
    
            // Get the volunteer by user ID
            $volunteer = $this->volunteerModel->getVolunteerByUserId($userId);
    
            if (!$volunteer) {
                echo "Error: Volunteer not found.";
                return;
            }
    
            // Fetch all available skills
            $query = "SELECT * FROM Skill";
            $skills = $this->db->query($query);
    
            if (empty($skills)) {
                echo "Error: No skills available.";
                return;
            }
    
            // Include the view and pass data to it
            $volunteerSkills = $volunteer->getSkillIds();
            include 'views/volunteer/choose_skills.php';
        }
    
        // Assign skills to the logged-in volunteer
        public function assignSkills() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $userId = $_SESSION['user_id'];
    
                // Get the volunteer by user ID
                $volunteer = $this->volunteerModel->getVolunteerByUserId($userId);
    
                if (!$volunteer) {
                    echo "Error: Volunteer not found.";
                    return;
                }
    
                // Get selected skills from the form
                $selectedSkills = $_POST['skills'] ?? [];
    
                // Fetch valid skill IDs from the database
                $query = "SELECT skill_id FROM Skill";
                $validSkills = $this->db->query($query);
                $validSkillIds = array_column($validSkills, 'skill_id');
    
                // Validate selected skills
                $validSelectedSkills = array_intersect($selectedSkills, $validSkillIds);
    
                // Clear existing skills
                $query = "DELETE FROM Volunteer_Skills WHERE volunteer_id = :volunteer_id";
                $this->db->execute($query, [':volunteer_id' => $volunteer->volunteer_id]);
    
                // Assign new skills
                foreach ($validSelectedSkills as $skillId) {
                    $query = "INSERT INTO Volunteer_Skills (volunteer_id, skill_id) VALUES (:volunteer_id, :skill_id)";
                    $params = [
                        ':volunteer_id' => $volunteer->volunteer_id,
                        ':skill_id' => $skillId,
                    ];
                    $this->db->execute($query, $params);
                }
    
                echo "Skills updated successfully.";
                header("Location: index.php?controller=volunteer&action=viewSkills");
                exit;
            }
        }

    
    
    
    
    

    
}
?>
