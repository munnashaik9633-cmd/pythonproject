# Test Plan and Test Cases

| ID | Test | Steps | Expected result |
|---|---|---|---|
| TC-01 | Student login | Sign in with student demo account | Student dashboard opens |
| TC-02 | Faculty login | Sign in with faculty demo account | Faculty dashboard opens |
| TC-03 | Admin login | Sign in with admin demo account | Admin dashboard opens |
| TC-04 | Invalid login | Enter incorrect password | Error message appears; no session is created |
| TC-05 | Role restriction | Sign in as student and open `/admin/dashboard.php` | Access denied |
| TC-06 | Submit feedback | Select subject, rate all five criteria and submit | Success message and submission history entry |
| TC-07 | Missing rating | Submit with one rating unselected | Browser validation blocks submission |
| TC-08 | Rating range | Attempt to post a rating outside 1–5 | Server validation rejects it |
| TC-09 | Duplicate response | Submit same subject and session again | Duplicate is rejected by application/database |
| TC-10 | Anonymous faculty view | Submit feedback and open faculty dashboard | Student identity is not displayed |
| TC-11 | Create user | Admin creates a valid user | User appears in account list |
| TC-12 | Duplicate username | Admin reuses an existing username | Friendly error is shown |
| TC-13 | Create subject | Admin adds subject with faculty and department | Subject appears in list and student subject choices |
| TC-14 | CSV export | Open reports and select Export CSV | Filtered aggregate CSV downloads |
| TC-15 | Print/PDF | Click Print / Save PDF | Browser print dialog opens |
| TC-16 | CSRF validation | Submit POST without valid token | Request is rejected |

## Suggested manual test sequence

1. Run setup and sign in as admin.
2. Confirm demo departments, faculty, subjects and student accounts exist.
3. Sign in as student and submit a rating for IT301.
4. Submit again for IT301 in the same session and verify duplicate prevention.
5. Sign in as faculty and verify aggregate scores and comment display without student identity.
6. Sign in as admin, create a test account and subject.
7. Open reports, filter by department/session, export CSV and print to PDF.
