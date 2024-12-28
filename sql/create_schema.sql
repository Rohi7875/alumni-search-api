CREATE DATABASE alumni_db;
USE alumni_db;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    latitude DECIMAL(10, 8) NOT NULL,
    longitude DECIMAL(11, 8) NOT NULL
);

CREATE TABLE alumni_networks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

CREATE TABLE user_networks (
    user_id INT NOT NULL,
    network_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (network_id) REFERENCES alumni_networks(id) ON DELETE CASCADE,
    UNIQUE (user_id, network_id)
);

CREATE INDEX idx_location ON users (latitude, longitude);
