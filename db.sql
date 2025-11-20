CREATE DATABASE IF NOT EXISTS tutoring_system;
USE tutoring_system;

-- ------------------------------------------------------
-- USERS TABLE
-- ------------------------------------------------------
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'tutor', 'student') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ------------------------------------------------------
-- SUBJECTS TABLE
-- ------------------------------------------------------
CREATE TABLE subjects (
    subject_id INT AUTO_INCREMENT PRIMARY KEY,
    subject_name VARCHAR(150) NOT NULL
);

-- ------------------------------------------------------
-- TUTOR SCHEDULES TABLE
-- ------------------------------------------------------
CREATE TABLE tutor_schedules (
    schedule_id INT AUTO_INCREMENT PRIMARY KEY,
    tutor_id INT NOT NULL,
    subject_id INT NOT NULL,
    day_of_week ENUM('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday') NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    status ENUM('available','booked') DEFAULT 'available',

    FOREIGN KEY (tutor_id) REFERENCES users(user_id)
        ON UPDATE CASCADE ON DELETE CASCADE,

    FOREIGN KEY (subject_id) REFERENCES subjects(subject_id)
        ON UPDATE CASCADE ON DELETE CASCADE
);

-- ------------------------------------------------------
-- BOOKINGS TABLE
-- ------------------------------------------------------
CREATE TABLE bookings (
    booking_id INT AUTO_INCREMENT PRIMARY KEY,
    schedule_id INT NOT NULL,
    student_id INT NOT NULL,
    status ENUM('pending','approved','declined','completed') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (schedule_id) REFERENCES tutor_schedules(schedule_id)
        ON UPDATE CASCADE ON DELETE CASCADE,

    FOREIGN KEY (student_id) REFERENCES users(user_id)
        ON UPDATE CASCADE ON DELETE CASCADE
);

-- ------------------------------------------------------
-- REVIEWS TABLE
-- ------------------------------------------------------
CREATE TABLE reviews (
    review_id INT AUTO_INCREMENT PRIMARY KEY,
    booking_id INT NOT NULL,
    student_id INT NOT NULL,
    tutor_id INT NOT NULL,
    rating INT CHECK (rating BETWEEN 1 AND 5),
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (booking_id) REFERENCES bookings(booking_id)
        ON UPDATE CASCADE ON DELETE CASCADE,

    FOREIGN KEY (student_id) REFERENCES users(user_id)
        ON UPDATE CASCADE ON DELETE CASCADE,

    FOREIGN KEY (tutor_id) REFERENCES users(user_id)
        ON UPDATE CASCADE ON DELETE CASCADE
);
