<?php
// Decorator Abstract Class
abstract class VolunteerDecorator extends Volunteer {
    protected $volunteer;

    public function __construct(Volunteer $volunteer) {
        $this->volunteer = $volunteer;
    }

    // Override all methods from Volunteer class to ensure they call the base object methods
    public function getVolunteers() {
        return $this->volunteer->getVolunteers();
    }

    public function getVolunteerById($volunteerId) {
        return $this->volunteer->getVolunteerById($volunteerId);
    }

    public function addVolunteer($volunteerData) {
        return $this->volunteer->addVolunteer($volunteerData);
    }

    public function updateVolunteer($volunteerData) {
        return $this->volunteer->updateVolunteer($volunteerData);
    }

    public function deleteVolunteer($volunteerId) {
        return $this->volunteer->deleteVolunteer($volunteerId);
    }

    public function update($eventData) {
        $this->volunteer->update($eventData);
    }
}

// Concrete Decorator Class
class SkillDecorator extends VolunteerDecorator {
    private $skills = [];

    public function addSkill($skill) {
        $this->skills[] = $skill;
    }

    public function getSkills() {
        return $this->skills;
    }

    public function displaySkills() {
        echo "Skills: " . implode(", ", $this->skills) . "\n";
    }
}
?>
