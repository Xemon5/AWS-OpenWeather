CREATE DATABASE weather
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_general_ci;

USE weather;

CREATE TABLE weather_data (
    id INT(11) NOT NULL AUTO_INCREMENT,
    city VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
    temperature FLOAT,
    humidity INT(11),
    description VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
    feels_like FLOAT,
    temp_min FLOAT,
    temp_max FLOAT,
    pressure INT(11),
    wind_speed FLOAT,
    icon VARCHAR(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
    PRIMARY KEY (id)
);