<?php
require_once 'models/Beneficiary.php';

class BeneficiaryController
{
    private $beneficiaryModel;

    public function __construct()
    {
        $this->beneficiaryModel = new Beneficiary();
    }

    // Displays the form to add a new beneficiary
    public function add()
    {
        require 'views/beneficiary/add.php'; // Render the add beneficiary form
    }

    // Adds a new beneficiary
    public function addBeneficiary($data) 
    {
        $result = $this->beneficiaryModel->addBeneficiary($data);
    
        if ($result) {
            // Redirect to the beneficiary list page
            header("Location: ?controller=beneficiary&action=listBeneficiaries");
            exit;
        } else {
            echo "Error adding beneficiary.";
        }
    }

    // Displays the details of a specific beneficiary
    public function view($params)
    {
        $beneficiaryId = $params['id'] ?? null;
        if ($beneficiaryId) {
            $beneficiary = $this->beneficiaryModel->getBeneficiaryById($beneficiaryId);
            if ($beneficiary) {
                require 'views/beneficiary/view.php'; // Render the view beneficiary page
            } else {
                echo "Beneficiary not found.";
            }
        } else {
            echo "Invalid beneficiary ID.";
        }
    }

    // Displays the form to edit a specific beneficiary
    public function edit($params)
    {
        $beneficiaryId = $params['id'] ?? null;
        if ($beneficiaryId) {
            $beneficiary = $this->beneficiaryModel->getBeneficiaryById($beneficiaryId);
            if ($beneficiary) {
                require 'views/beneficiary/edit.php'; // Render the edit beneficiary page
            } else {
                echo "Beneficiary not found.";
            }
        } else {
            echo "Invalid beneficiary ID.";
        }
    }

    // Updates a beneficiary’s details
    public function updateBeneficiary($beneficiaryId, $data)
    {
        $result = $this->beneficiaryModel->updateBeneficiary($beneficiaryId, $data);
        echo $result ? "Beneficiary updated successfully." : "Error updating beneficiary.";
    }

    // List all beneficiaries
    public function listBeneficiaries()
    {
        $beneficiaries = $this->beneficiaryModel->getBeneficiaries();
        require 'views/beneficiary/list.php'; // Display list of beneficiaries
    }
}
