CREATE TABLE IF NOT EXISTS departments (
 id INT AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(120) NOT NULL UNIQUE,
 code VARCHAR(20) NOT NULL UNIQUE,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS users (
 id INT AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(150) NOT NULL,
 username VARCHAR(80) NOT NULL UNIQUE,
 password_hash VARCHAR(255) NOT NULL,
 role ENUM('student','faculty','admin') NOT NULL,
 department_id INT NULL,
 is_active TINYINT(1) NOT NULL DEFAULT 1,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 CONSTRAINT fk_user_department FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS subjects (
 id INT AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(150) NOT NULL,
 code VARCHAR(30) NOT NULL UNIQUE,
 faculty_id INT NOT NULL,
 department_id INT NOT NULL,
 is_active TINYINT(1) NOT NULL DEFAULT 1,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 CONSTRAINT fk_subject_faculty FOREIGN KEY (faculty_id) REFERENCES users(id),
 CONSTRAINT fk_subject_department FOREIGN KEY (department_id) REFERENCES departments(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS feedback (
 id BIGINT AUTO_INCREMENT PRIMARY KEY,
 student_id INT NOT NULL,
 subject_id INT NOT NULL,
 faculty_id INT NOT NULL,
 session_name VARCHAR(40) NOT NULL,
 teaching TINYINT UNSIGNED NOT NULL,
 communication TINYINT UNSIGNED NOT NULL,
 punctuality TINYINT UNSIGNED NOT NULL,
 knowledge TINYINT UNSIGNED NOT NULL,
 interaction TINYINT UNSIGNED NOT NULL,
 comment TEXT NULL,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 CONSTRAINT uq_student_subject_session UNIQUE (student_id, subject_id, session_name),
 CONSTRAINT fk_feedback_student FOREIGN KEY (student_id) REFERENCES users(id),
 CONSTRAINT fk_feedback_subject FOREIGN KEY (subject_id) REFERENCES subjects(id),
 CONSTRAINT fk_feedback_faculty FOREIGN KEY (faculty_id) REFERENCES users(id),
 CONSTRAINT chk_teaching CHECK (teaching BETWEEN 1 AND 5),
 CONSTRAINT chk_communication CHECK (communication BETWEEN 1 AND 5),
 CONSTRAINT chk_punctuality CHECK (punctuality BETWEEN 1 AND 5),
 CONSTRAINT chk_knowledge CHECK (knowledge BETWEEN 1 AND 5),
 CONSTRAINT chk_interaction CHECK (interaction BETWEEN 1 AND 5),
 INDEX idx_feedback_faculty (faculty_id),
 INDEX idx_feedback_subject (subject_id),
 INDEX idx_feedback_session (session_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
