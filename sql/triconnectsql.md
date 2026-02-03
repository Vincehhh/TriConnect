CREATE DATABASE IF NOT EXISTS triconnect_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE triconnect_db;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('user', 'moderator', 'admin') DEFAULT 'user',
    avatar_url VARCHAR(255) DEFAULT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE user_physical_stats (
    user_id INT PRIMARY KEY,
    weight FLOAT,
    height INT,
    vo2_max INT,
    ftp INT,
    resting_hr INT,
    max_hr INT,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE oauth_tokens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    provider ENUM('strava', 'garmin') NOT NULL,
    access_token VARCHAR(512) NOT NULL,
    refresh_token VARCHAR(512),
    expires_at DATETIME,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE activities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    external_id VARCHAR(100),
    type ENUM('swim', 'ride', 'run') NOT NULL,
    start_date DATETIME NOT NULL,
    distance FLOAT,
    moving_time INT,
    total_elevation_gain INT,
    average_watts INT DEFAULT NULL,
    average_heartrate FLOAT DEFAULT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE forum_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    slug VARCHAR(50) NOT NULL UNIQUE
) ENGINE=InnoDB;

CREATE TABLE forum_threads (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    author_id INT NOT NULL,
    title VARCHAR(150) NOT NULL,
    views INT DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES forum_categories(id),
    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE forum_posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    thread_id INT NOT NULL,
    author_id INT NOT NULL,
    content TEXT NOT NULL,
    is_solution BOOLEAN DEFAULT FALSE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (thread_id) REFERENCES forum_threads(id) ON DELETE CASCADE,
    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE generated_plans (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    sport ENUM('swim', 'bike', 'run') NOT NULL,
    level_input VARCHAR(50),
    goal_input TEXT,
    generated_result JSON,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

INSERT INTO forum_categories (name, slug) VALUES 
('Natation', 'natation'),
('Cyclisme', 'cyclisme'),
('Course à pied', 'course-a-pied'),
('Matériel', 'materiel'),
('Nutrition', 'nutrition');