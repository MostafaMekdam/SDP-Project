<?php

abstract class ReceiptTemplate {
    public function generateReceipt($donation) {
        $receipt = $this->generateHeader();
        $receipt .= $this->generateBody($donation);
        $receipt .= $this->generateFooter();
        return $receipt;
    }

    protected function generateHeader() {
        return "<h1>Donation Receipt</h1>";
    }

    protected abstract function generateBody($donation);

    protected function generateFooter() {
        return "<p>Thank you for your generous support!</p>";
    }
}

class GeneralDonationReceipt extends ReceiptTemplate {
    protected function generateBody($donation) {
        return "<p>Donation ID: " . htmlspecialchars($donation['donation_id']) . "</p>" .
               "<p>Amount: $" . htmlspecialchars($donation['amount']) . "</p>" .
               "<p>Date: " . htmlspecialchars($donation['date']) . "</p>";
    }
}

class EventDonationReceipt extends ReceiptTemplate {
    protected function generateBody($donation) {
        $body = "<p>Donation ID: " . htmlspecialchars($donation['donation_id']) . "</p>" .
                "<p>Amount: $" . htmlspecialchars($donation['amount']) . "</p>" .
                "<p>Date: " . htmlspecialchars($donation['date']) . "</p>";
        if (!empty($donation['event_name'])) {
            $body .= "<p>Event: " . htmlspecialchars($donation['event_name']) . "</p>" .
                     "<p>Event Date: " . htmlspecialchars($donation['event_date']) . "</p>" .
                     "<p>Event Location: " . htmlspecialchars($donation['event_location']) . "</p>";
        }
        return $body;
    }
}
