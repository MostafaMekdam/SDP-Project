<?php
require_once 'models/User.php';
require_once 'models/Donor.php';

class UserFactory {
    public static function createUser($username, $password, $role, $extraData = []) {
        $userModel = new User();
        $donorModel = new Donor();

        // Create a user in the `users` table
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $userId = $userModel->createUser($username, $hashedPassword, $role);

        if (!$userId) {
            throw new Exception("Failed to create user.");
        }

        // Handle role-specific creation
        switch ($role) {
            case 'Donor':
                // Ensure required data for Donor
                if (!isset($extraData['contact_info'])) {
                    throw new Exception("Contact info is required for Donor role.");
                }
                $donorData = [
                    ':name' => $username, // You can use a separate name field if available
                    ':contact_info' => $extraData['contact_info'],
                    ':user_id' => $userId
                ];
                if (!$donorModel->addDonor($donorData)) {
                    throw new Exception("Failed to create donor.");
                }
                break;

            case 'Volunteer':
                // Logic for Volunteer creation (if any)
                break;

            case 'Admin':
                // Admin creation doesn't need extra data
                break;

            default:
                throw new Exception("Unknown role: $role");
        }

        return $userId; // Return the created user ID
    }
}
