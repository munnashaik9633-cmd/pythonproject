# Module and Application Guide

This is a traditional PHP server-rendered application. It does not expose a separate public JSON REST API; browser forms submit to PHP page controllers and PHP uses PDO to communicate with MySQL.

## Module responsibilities

| Module | Files | Responsibility |
|---|---|---|
| Shared configuration | `config/` | Database settings, PDO connection, session configuration |
| Shared helpers | `includes/functions.php` | Authentication, role guards, CSRF, escaping, flash messages |
| Public | `index.php`, `login.php`, `logout.php` | Landing page and session lifecycle |
| Student | `student/` | Subject list, submission form, submission history |
| Faculty | `faculty/dashboard.php` | Aggregated faculty ratings and anonymous comments |
| Administration | `admin/` | Campus overview, user and subject management |
| Reports | `reports.php` | Filtered aggregate report, CSV, print/PDF |
| Installation | `setup.php`, `database/schema.sql` | Initial schema and demo data setup |

## Form actions

- `POST /login.php`: username, password, role, CSRF token.
- `POST /student/feedback.php`: subject ID, session, five ratings, optional comment and CSRF token.
- `POST /admin/users.php`: name, username, password, role, department and CSRF token.
- `POST /admin/subjects.php`: subject name, code, faculty ID, department ID and CSRF token.
- `GET /reports.php?export=csv`: downloads aggregate report rows based on the selected filters.

## Security controls implemented

- `password_hash()` and `password_verify()`.
- PDO prepared statements.
- Session ID regeneration after successful authentication.
- Role checks on protected routes.
- CSRF tokens on POST forms.
- `htmlspecialchars()` output encoding.
- Unique database key to prevent duplicate feedback.

## Important privacy detail

The feedback table contains `student_id` internally so that the database can enforce one response per student per subject per session. The faculty dashboard and reports do not select this field. For strict anonymity even from database administrators, the data model would need a different privacy-preserving duplicate-prevention design.
