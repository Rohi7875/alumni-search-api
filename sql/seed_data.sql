USE alumni_db;

-- Insert Dummy Users
INSERT INTO users (name, email, latitude, longitude) VALUES
('John Doe', 'john.doe@example.com', 17.385044, 78.486671),
('Jane Smith', 'jane.smith@example.com', 17.400000, 78.500000),
('Alice Brown', 'alice.brown@example.com', 17.390000, 78.480000),
('Bob Johnson', 'bob.johnson@example.com', 17.420000, 78.470000),
('Chris Evans', 'chris.evans@example.com', 17.380000, 78.460000);

-- Insert Dummy Alumni Networks
INSERT INTO alumni_networks (name) VALUES
('Engineering Alumni'),
('Technology Alumni'),
('Business Alumni'),
('Arts Alumni');

-- Associate Users with Alumni Networks
INSERT INTO user_networks (user_id, network_id) VALUES
(1, 1), -- John Doe -> Engineering Alumni
(1, 2), -- John Doe -> Technology Alumni
(2, 1), -- Jane Smith -> Engineering Alumni
(3, 3), -- Alice Brown -> Business Alumni
(4, 2), -- Bob Johnson -> Technology Alumni
(5, 4); -- Chris Evans -> Arts Alumni
