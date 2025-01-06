CREATE TABLE Donor (
    donor_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    contact_info VARCHAR(255),
    user_id INT UNIQUE, -- Link to the users table
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

CREATE TABLE Volunteer (
    volunteer_id INT PRIMARY KEY,
    name VARCHAR(100),
    contact_info VARCHAR(255),
    availability BIT
);



CREATE TABLE Beneficiary (
    beneficiary_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    contact_info VARCHAR(255),
    need VARCHAR(255)
);

CREATE TABLE Attendee (
    attendee_id INT PRIMARY KEY AUTO_INCREMENT,
    ticket_status BIT
);

CREATE TABLE Donation (
    donation_id INT PRIMARY KEY AUTO_INCREMENT,
    donor_id INT,
    type VARCHAR(50),
    amount DECIMAL(10, 2) NOT NULL,
    date DATETIME NOT NULL,
    FOREIGN KEY (donor_id) REFERENCES Donor(donor_id),
    event_id INT DEFAULT NULL,
    FOREIGN KEY (event_id) REFERENCES Event(event_id)
);

CREATE TABLE Event (
    event_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100),
    date DATE,
    location VARCHAR(100),
    capacity INT
);

CREATE TABLE Receipt (
    receipt_id INT PRIMARY KEY AUTO_INCREMENT,
    date_issued DATE,
    amount DECIMAL(10, 2),
    donation_id INT,
    FOREIGN KEY (donation_id) REFERENCES Donation(donation_id)
);

CREATE TABLE ResourceDistribution (
    distribution_id INT PRIMARY KEY AUTO_INCREMENT,
    resource_type VARCHAR(100),
    quantity INT,
    date_distributed DATE,
    beneficiary_id INT,
    FOREIGN KEY (beneficiary_id) REFERENCES Beneficiary(beneficiary_id)
);

CREATE TABLE VolunteerTask (
    task_id INT PRIMARY KEY AUTO_INCREMENT,
    description TEXT,
    required_skills VARCHAR(255)
);

CREATE TABLE Communication (
    communication_id INT PRIMARY KEY AUTO_INCREMENT,
    message TEXT,
    type VARCHAR(50),
    recipient VARCHAR(100),
    date_sent DATE
);

CREATE TABLE Transactions (
    transaction_id INT PRIMARY KEY AUTO_INCREMENT,
    amount DECIMAL(10, 2),
    date DATE,
    donation_id INT,
    FOREIGN KEY (donation_id) REFERENCES Donation(donation_id)
);

CREATE TABLE Skill (
    skill_id INT PRIMARY KEY AUTO_INCREMENT,
    skill_name VARCHAR(100)
);

CREATE TABLE Volunteer_Skills (
    volunteer_id INT,
    skill_id INT,
    FOREIGN KEY (volunteer_id) REFERENCES Volunteer(volunteer_id),
    FOREIGN KEY (skill_id) REFERENCES Skill(skill_id),
    PRIMARY KEY (volunteer_id, skill_id)
);

CREATE TABLE Event_Attendees (
    event_id INT,
    attendee_id INT,
    FOREIGN KEY (event_id) REFERENCES Event(event_id),
    FOREIGN KEY (attendee_id) REFERENCES Attendee(attendee_id),
    PRIMARY KEY (event_id, attendee_id)
);

CREATE TABLE VolunteerTask_Volunteers (
    task_id INT,
    volunteer_id INT,
    FOREIGN KEY (task_id) REFERENCES VolunteerTask(task_id),
    FOREIGN KEY (volunteer_id) REFERENCES Volunteer(volunteer_id),
    PRIMARY KEY (task_id, volunteer_id)
);
CREATE TABLE users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('Admin', 'Donor', 'Volunteer') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
