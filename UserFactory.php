<?php
require_once 'models/User.php';
require_once 'models/Donor.php';

class UserFactory {
    /**
     * Create a new user and handle role-specific logic.
     *
     * @param string $username The username of the user.
     * @param string $password The password of the user.
     * @param string $role The role of the user (Admin, Donor, Volunteer).
     * @param array $extraData Additional data required for role-specific logic.
     * @return int The created user's ID.
     * @throws Exception If user creation fails or role-specific logic fails.
     */
    public static function createUser($username, $password, $role, $extraData = []) {
        $userModel = new User();
        $donorModel = new Donor();

        // Hash the password securely
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Create the user in the `users` table
        $userId = $userModel->createUser($username, $hashedPassword, $role);
        if (!$userId) {
            throw new Exception("Failed to create user in the `users` table.");
        }

        // Handle role-specific logic
        switch ($role) {
            case 'Donor':
                self::handleDonorCreation($username, $extraData, $userId, $donorModel);
                break;

            case 'Volunteer':
                self::handleVolunteerCreation($username, $extraData, $userId);
                break;

            case 'Admin':
                // No additional logic needed for Admin
                break;

            default:
                throw new Exception("Unknown role: $role");
        }

        return $userId; // Return the created user's ID
    }

    /**
     * Handle donor-specific creation logic.
     *
     * @param string $username The username of the donor.
     * @param array $extraData Additional data required for the donor.
     * @param int $userId The user ID linked to the donor.
     * @param Donor $donorModel The Donor model instance.
     * @throws Exception If donor creation fails.
     */
    private static function handleDonorCreation($username, $extraData, $userId, $donorModel) {
        if (empty($extraData['contact_info'])) {
            throw new Exception("Contact info is required for Donor role.");
        }

        // Prepare donor data
        $donorData = [
            ':name' => $username,
            ':contact_info' => $extraData['contact_info'],
            ':user_id' => $userId,
        ];

        // Insert donor into the `donor` table
        if (!$donorModel->addDonor($donorData)) {
            throw new Exception("Failed to create donor in the `donor` table.");
        }
    }

    /**
     * Handle volunteer-specific creation logic (if needed).
     *
     * @param string $username The username of the volunteer.
     * @param array $extraData Additional data required for the volunteer.
     * @param int $userId The user ID linked to the volunteer.
     */
    private static function handleVolunteerCreation($username, $extraData, $userId) {
        // Placeholder for volunteer-specific logic, if required in the future
    }
}
?>