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

    public function listVolunteers() {
        // Query to get volunteers with their assigned tasks
        $query = "
            SELECT 
                v.volunteer_id, 
                v.name, 
                v.contact_info, 
                GROUP_CONCAT(t.description SEPARATOR ', ') AS assigned_tasks
            FROM Volunteer v
            LEFT JOIN VolunteerTask_Volunteers vt ON v.volunteer_id = vt.volunteer_id
            LEFT JOIN VolunteerTask t ON vt.task_id = t.task_id
            GROUP BY v.volunteer_id
        ";
    
        $volunteers = $this->db->query($query); // Execute the query
    
        // Load the volunteer list view
        require 'views/volunteer/list.php';
    }
    
    

    // List all volunteers
    //public function listVolunteers() {
        //$volunteers = $this->volunteerModel->getVolunteers();
        //require 'views/volunteer/list.php';
    //}

    




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

        public function assignTasks($params) {
            $eventId = $params['event_id'] ?? null;
        
            if (!$eventId) {
                echo "Error: Event ID is required.";
                return;
            }
        
            // Fetch volunteers for the event
            $query = "
                SELECT v.volunteer_id, v.name, v.contact_info
                FROM Volunteer v
                JOIN Event_Attendees ea ON v.volunteer_id = ea.attendee_id
                WHERE ea.event_id = :event_id
            ";
            $volunteers = $this->db->query($query, [':event_id' => $eventId]);
        
            // Fetch all tasks
            $tasksQuery = "SELECT * FROM VolunteerTask";
            $tasks = $this->db->query($tasksQuery);
        
            // Include the view for assigning tasks
            include 'views/volunteer/assign_tasks.php';
        }


        public function saveAssignedTasks($params) {
            $eventId = $params['event_id'] ?? null;
            $volunteers = $params['volunteers'] ?? [];
            $tasks = $params['tasks'] ?? [];
        
            if (!$eventId || empty($volunteers) || empty($tasks)) {
                echo "Error: Missing data.";
                return;
            }
        
            // Save assignments to the database
            foreach ($volunteers as $volunteerId) {
                if (!empty($tasks[$volunteerId])) {
                    $query = "INSERT INTO VolunteerTask_Volunteers (task_id, volunteer_id) 
                              VALUES (:task_id, :volunteer_id)";
                    $this->db->execute($query, [
                        ':task_id' => $tasks[$volunteerId],
                        ':volunteer_id' => $volunteerId
                    ]);
                }
            }
        
            echo "Tasks assigned successfully.";
            header("Location: index.php?controller=volunteer&action=listVolunteers");
            exit;
        }
        
        

    
    
    
    
    

    
}
?>
