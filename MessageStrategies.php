<?php
// Strategy Interface
interface MessageStrategy {
    public function send($recipient, $message);
}

// Concrete Strategy: Email
class EmailStrategy implements MessageStrategy {
    public function send($recipient, $message) {
        // Implementation for sending an email
        echo "Sending email to $recipient: $message\n";
        // Actual email sending logic goes here
    }
}

// Concrete Strategy: SMS
class SMSStrategy implements MessageStrategy {
    public function send($recipient, $message) {
        // Implementation for sending an SMS
        echo "Sending SMS to $recipient: $message\n";
        // Actual SMS sending logic goes here
    }
}

// Concrete Strategy: Social Media
class SocialMediaStrategy implements MessageStrategy {
    public function send($recipient, $message) {
        // Implementation for sending a message via social media
        echo "Posting to social media for $recipient: $message\n";
        // Actual social media posting logic goes here
    }
}
?>
