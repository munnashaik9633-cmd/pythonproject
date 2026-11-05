# Campus Feedback Lens

A complete student feedback analysis web application built with **HTML, CSS, JavaScript, PHP 8+ and MySQL 8+**.

## Features

- Public landing page inspired by the supplied Campus Feedback Lens reference.
- Role-based sign-in for students, faculty and administrators.
- Student feedback with five 1–5 rating criteria and optional written comments.
- Anonymous reporting: faculty and management screens never display the student identity.
- Database-level duplicate prevention for each student + subject + academic session.
- Faculty dashboard with subject-level summaries and anonymous comments.
- Admin dashboard with campus totals and department comparisons.
- Admin user and subject creation.
- Filterable aggregate reports, CSV export and browser print / Save as PDF.
- CSRF protection, password hashing, prepared SQL statements, HTML output escaping and session ID regeneration.
- Responsive layout for desktop and mobile.

## Requirements

- PHP 8.1 or newer (PDO MySQL extension and mbstring recommended).
- MySQL 8.0 or MariaDB 10.5+.
- Apache (XAMPP/WAMP/MAMP) or another PHP-capable web server.

## Install with XAMPP (Windows)

1. Install and open XAMPP. Start **Apache** and **MySQL**.
2. Copy the `campus-feedback-lens` folder into `C:\xampp\htdocs\`.
3. Open phpMyAdmin at `http://localhost/phpmyadmin`.
4. Create a database named `campus_feedback_lens` using `utf8mb4` collation.
5. Open `config/config.php` and confirm the database host, name, username and password. The XAMPP defaults are `localhost`, `campus_feedback_lens`, `root`, and an empty password.
6. Import `database/schema.sql` into the database using phpMyAdmin's Import tab.
7. Visit `http://localhost/campus-feedback-lens/setup.php`. It creates demo departments, accounts and subjects.
8. Open `http://localhost/campus-feedback-lens/`.

> If you put the project in a subfolder other than `campus-feedback-lens`, update absolute links or deploy at the web root. The default `BASE_URL` is `/campus-feedback-lens` for the XAMPP folder shown above. If you deploy at the domain root, change `BASE_URL` to an empty string in `config/config.php`.

## Demo accounts

| Role | Username | Password |
|---|---|---|
| Student | `student` | `student123` |
| Faculty | `faculty` | `faculty123` |
| Admin | `admin` | `admin123` |

Change demo passwords before deploying publicly. Delete `setup.php` after installation.

## Main routes

- `/index.php` – landing page
- `/login.php` – role-based sign in
- `/student/dashboard.php` – available subjects and personal submission history
- `/student/feedback.php?subject_id=1` – feedback form
- `/faculty/dashboard.php` – faculty analytics and anonymous comments
- `/admin/dashboard.php` – management overview
- `/admin/users.php` – create and list accounts
- `/admin/subjects.php` – create and list subjects
- `/reports.php` – aggregate filters, CSV and print/PDF

## Database design

- `departments`: academic departments.
- `users`: student, faculty and admin accounts. Passwords are stored as password hashes.
- `subjects`: subject-to-faculty and department mapping.
- `feedback`: five ratings, optional comment, session, and internal student reference.

The unique key `(student_id, subject_id, session_name)` blocks duplicate feedback. The student reference is required for duplicate prevention and is not selected or displayed in faculty/admin report queries.

## Privacy and production notes

This is an academic project starter. Before real institutional deployment:
- add HTTPS, secure cookie settings, rate limiting and password reset;
- define retention, consent and moderation policies for comments;
- consider collecting feedback only after a minimum response count to reduce re-identification risk;
- restrict admin creation and audit sensitive administrative actions;
- configure database backups and least-privilege database credentials;
- review local privacy and institutional requirements.

Anonymous means identity is hidden from faculty-facing views. The database retains an internal student foreign key to enforce one response per student per subject per session. A database administrator with direct database access can access that relationship.

## PDF export

On the Reports page, choose **Print / Save PDF**, then select “Save as PDF” in the browser print dialog. CSV export downloads the filtered aggregate report.

## Project structure

```text
campus-feedback-lens/
├── admin/
│   ├── dashboard.php
│   ├── subjects.php
│   └── users.php
├── assets/
│   ├── app.js
│   └── style.css
├── config/
│   ├── config.php
│   └── database.php
├── database/
│   └── schema.sql
├── docs/
│   ├── Project-Report.docx
│   ├── Project-Report.pdf
│   ├── SRS.md
│   ├── API-and-Module-Guide.md
│   └── Test-Cases.md
├── faculty/dashboard.php
├── includes/
│   ├── footer.php
│   ├── functions.php
│   └── header.php
├── student/
│   ├── dashboard.php
│   └── feedback.php
├── index.php
├── login.php
├── logout.php
├── reports.php
└── setup.php
```
