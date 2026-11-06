# Software Requirements Specification (SRS)
## Campus Feedback Lens

### 1. Purpose
Campus Feedback Lens provides a central web application for collecting student feedback about teaching and learning, then presenting aggregated results to faculty and institutional administrators.

### 2. Scope
The system supports student, faculty and administrator roles. Students submit one rating form per subject and academic session. Faculty review their subject results and anonymous comments. Administrators manage accounts and subjects and review institution-wide reports.

### 3. User classes
- **Student:** signs in, views available subjects, submits feedback and sees their own submission history.
- **Faculty:** reviews aggregated results and comments for assigned teaching.
- **Administrator:** reviews campus metrics, creates users and subjects, and exports reports.

### 4. Functional requirements
- FR-01: The system shall authenticate users by username, password and role.
- FR-02: The system shall provide role-specific access control.
- FR-03: Students shall submit ratings from 1 through 5 for teaching, communication, punctuality, subject knowledge and interaction.
- FR-04: Students may add an optional comment up to 1,500 characters.
- FR-05: The system shall prevent a student from submitting twice for the same subject and session.
- FR-06: Faculty views shall not expose student names, usernames or student IDs.
- FR-07: Faculty shall view aggregated ratings and anonymized comments for their subjects.
- FR-08: Administrators shall view campus totals and department summaries.
- FR-09: Administrators shall create user accounts and subjects.
- FR-10: Authorized users shall filter aggregate reports and export CSV.
- FR-11: Authorized users shall print reports or save them as PDF through the browser.

### 5. Non-functional requirements
- Security: password hashing, prepared SQL statements, CSRF token validation and output escaping.
- Privacy: feedback views use aggregate values and do not expose student identifiers.
- Usability: responsive pages and clear validation messages.
- Performance: indexes support subject, faculty and session report filters.
- Maintainability: shared authentication and layout logic is kept in include files.
- Compatibility: current desktop and mobile browsers with PHP 8.1+ and MySQL 8+ server.

### 6. Data requirements
Entities: Department, User, Subject and Feedback. Feedback stores five rating columns, session, optional comment and creation timestamp. A unique constraint on student, subject and session enforces duplicate prevention.

### 7. Assumptions and constraints
- The institution provides accurate user, faculty, department and subject records.
- PHP and MySQL are available on the hosting server.
- Student identity is stored internally for duplicate prevention, but is not visible in faculty or management reporting.
- This implementation is a prototype and requires security hardening before public production use.

### 8. Acceptance criteria
- Valid users can sign in and are redirected to the correct role dashboard.
- Unauthorized roles cannot access restricted pages.
- Valid student ratings are saved.
- Duplicate feedback for the same subject/session is rejected.
- Faculty reports do not show student identity.
- Admin can create accounts and subjects.
- CSV export contains the currently filtered aggregate results.
