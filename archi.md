                 UMERA CERTIFICATE MANAGER
                           │
             ┌─────────────┴─────────────┐
             │                           │
        PARTICIPANT                    ADMIN
          PORTAL                      DASHBOARD
             │                           │
       HTML/CSS/JS                HTML/CSS/JS
             │                           │
             └─────────────┬─────────────┘
                           │
                     Laravel / Blade
                           │
          ┌────────────────┼────────────────┐
          │                │                │
       Database        Services          Storage
          │                │                │
          │        ┌───────┼────────┐       │
          │        │       │        │       │
          │   Eligibility Certificate QR   PDFs
          │     Service     Service        │
          │        │       │        │       │
          └────────┴───────┴────────┴───────┘
                           │
                    Public Verification
                           │
                       Social Sharing





                       # Umera Certificate Manager — UmeraBoost 5.0

You are working as a senior Laravel developer, UI/UX designer, and software architect.

We are building a professional **Certificate Management and Verification System** for **Umera Business School**, initially for **UmeraBoost 5.0**.

This project must eventually allow eligible participants to find, view, download, share, and publicly verify their certificates.

We are starting from the beginning.

## IMPORTANT: START WITH DESIGN AND FOUNDATION

Do NOT immediately build the entire backend.

Do NOT create the database yet unless it is required by the existing Laravel project setup.

Do NOT implement certificate generation yet.

Do NOT implement the eligibility engine yet.

Do NOT implement AI yet.

First build the **professional frontend/UI foundation and user experience** inside the Laravel application.

After the UI is approved, we will implement the backend progressively.

---

# 1. TECHNOLOGY REQUIREMENTS

This is a Laravel application.

Use:

* Laravel
* Blade
* HTML5
* CSS / Tailwind CSS
* Vanilla JavaScript

Do NOT use:

* React
* Vue
* Angular
* Next.js
* Inertia.js
* A separate frontend application

Keep the frontend inside the Laravel application.

Use Blade layouts and reusable Blade components.

Use JavaScript only where necessary for frontend interactions.

If Tailwind is already installed, use it.

If Tailwind is not installed, inspect the project before deciding how to add it.

Do not unnecessarily change the existing Laravel configuration.

---

# 2. FIRST ACTION — INSPECT THE PROJECT

Before creating files or changing architecture:

1. Inspect the existing Laravel project structure.
2. Determine the Laravel version.
3. Determine the PHP version requirements.
4. Inspect `composer.json`.
5. Inspect `package.json`.
6. Inspect the existing routes.
7. Inspect existing Blade views.
8. Inspect existing CSS/JS setup.
9. Determine whether authentication already exists.
10. Determine whether Tailwind already exists.
11. Determine whether any existing design system or components exist.

Do NOT delete existing project files.

Do NOT overwrite existing functionality without understanding it.

If this is an empty/new Laravel project, establish a clean structure.

If functionality already exists, preserve it.

At the end of the inspection, briefly explain the current project structure before making major changes.

---

# 3. PRODUCT NAME

Use:

**Umera Certificate Manager**

Organization:

**Umera Business School**

Initial program:

**UmeraBoost 5.0**

The application should be designed so it can eventually support other Umera Business School programs.

Do not hard-code the entire architecture around UmeraBoost 5.0.

UmeraBoost 5.0 is the first program using the platform.

---

# 4. PRODUCT PURPOSE

The system will eventually solve the current manual certificate workflow.

Current problem:

* Participants register separately.
* Their information is collected in spreadsheets.
* Eligibility has to be determined.
* Certificates are manually prepared.
* Certificates may be sent to the wrong participants.
* Names/emails can be entered incorrectly.
* Certificate generation is time-consuming.
* There is no central verification system.
* There is no reliable download/verification tracking.

The new platform should solve these problems.

---

# 5. CORE USER EXPERIENCE

The participant experience should eventually be:

Landing Page
→ Enter registration email
→ Find participant
→ Check eligibility
→ Certificate available
→ View certificate
→ Download certificate
→ Share achievement
→ Public verification

The public verification experience:

Shared link / QR code
→ Verification page
→ Certificate authenticity confirmed
→ View certificate details
→ View/download certificate

The admin experience:

Admin Login
→ Dashboard
→ Participants
→ Eligibility
→ Certificates
→ Templates
→ Imports
→ Downloads
→ Verification
→ Reports
→ Activity Logs
→ Settings

---

# 6. DESIGN DIRECTION

The application should look like a serious professional educational credential platform.

Design qualities:

* Modern
* Premium
* Professional
* Trustworthy
* Academic
* Clean
* Minimal
* Elegant
* Responsive

Avoid:

* Generic SaaS appearance
* Overly flashy gradients
* Gaming aesthetics
* Crypto/Web3 aesthetics
* Excessive animations
* Excessive red
* Cluttered dashboards

The certificate itself is elegant, so the UI should complement it.

---

# 7. BRAND COLORS

Use the existing Umera Business School visual identity as the primary reference.

The certificate uses:

* Dark red / Umera red
* Black
* White
* Light gray
* Neutral tones

Use the Umera red as an accent.

Do not make every component red.

Use white space and neutral backgrounds extensively.

---

# 8. CERTIFICATE DESIGN — VERY IMPORTANT

An exact UmeraBoost 5.0 certificate image has been supplied as the visual reference.

The certificate image is the authoritative source for the certificate design.

DO NOT:

* Redesign it
* Recreate it with generative AI
* Change its layout
* Change its typography
* Change its colors
* Change its logo
* Change its borders
* Change its signatures
* Change the certified stamp
* Change its decorative elements
* Change its fixed wording
* Distort it
* Automatically "improve" it

The eventual certificate-generation system must preserve the original artwork.

The current certificate contains example participant data.

The eventual dynamic fields are:

1. Participant name
2. Course name
3. Issue date
4. Certificate ID
5. QR code

For the UI prototype, use the supplied certificate as the visual reference.

The certificate must remain visually identical to the approved original except for the dynamic fields.

---

# 9. IMPORTANT CERTIFICATE FILE

There is a certificate image available in the project/workspace.

Before designing the certificate preview:

1. Locate the supplied certificate image.
2. Inspect its dimensions and aspect ratio.
3. Use it as the certificate visual reference.
4. Do not modify the original file.
5. Do not overwrite it.
6. Create a dedicated template/reference directory if appropriate.

The current certificate image is portrait-oriented.

Do not crop it incorrectly.

Do not stretch it.

Maintain its aspect ratio.

---

# 10. BUILD THE FIRST USER-FACING PAGE

Create the participant landing page.

Suggested route:

`/`

The page should include:

Umera Business School branding.

Heading:

**Your UmeraBoost Certificate**

Supporting text:

**Access, download, and share your verified UmeraBoost certificate.**

Certificate lookup form.

Label:

**Email address**

Placeholder:

**Enter the email you used during registration**

Primary button:

**Find My Certificate**

Supporting text:

**Use the same email address you used when registering for UmeraBoost.**

Also include a small trust section:

✓ Official Umera Business School certificate

✓ Secure certificate access

✓ Public verification

✓ Shareable achievement

Keep the page visually clean.

---

# 11. CREATE A CERTIFICATE LOOKUP EXPERIENCE

Create the UI for the certificate lookup process.

For now, use mock data.

Do not connect to the database yet.

When a user enters an email, simulate the lookup.

Create these states:

### Default

Email input + button.

### Loading

Show:

**Looking for your certificate...**

### Certificate found

Show:

**Congratulations, Adeyemo Goodness!**

**Your certificate is ready.**

Course:

**Fundamentals of Generative Artificial Intelligence**

Program:

**UmeraBoost 5.0**

Certificate ID:

**UMB5-GAI-2026-000001**

Status:

**✓ Verified Certificate**

Buttons:

**View Certificate**

**Download Certificate**

**Share Achievement**

### Not eligible

Show:

**Your certificate is not currently available.**

Provide a clear explanation.

Example:

**Your registration was found, but you have not yet met the certificate eligibility requirements.**

### Not found

Show:

**We couldn't find a registration using that email address.**

Provide guidance to check the email used during registration.

---

# 12. CERTIFICATE PREVIEW PAGE

Create a beautiful certificate preview page.

The certificate should be the main visual focus.

Desktop:

Center the certificate with appropriate margins.

Mobile:

Scale the certificate correctly while preserving the original aspect ratio.

Do not stretch or distort it.

Below/around the certificate show:

Certificate status:

✓ VERIFIED

Certificate ID:

`UMB5-GAI-2026-000001`

Issue date:

October 1, 2026

Actions:

**Download Certificate**

**Share Achievement**

**Copy Verification Link**

---

# 13. SHARE ACHIEVEMENT UI

Create a share modal.

Title:

**Share your achievement**

Text:

**Share your certificate with friends, employers, colleagues, or your professional network.**

Options:

* LinkedIn
* WhatsApp
* Facebook
* X
* Copy verification link

Example verification URL:

`https://cert.umbs.ng/verify/UMB5-GAI-2026-000001`

Use a realistic preview card.

The social sharing buttons can be mock interactions at this stage.

Do not integrate social APIs yet.

---

# 14. PUBLIC VERIFICATION PAGE

Create:

`/verify/{certificate}`

This page must not require login.

It represents the future public certificate verification experience.

Design it as a digital credential.

Display:

Umera Business School

✓ VERIFIED

**Certificate verified by Umera Business School**

Certificate holder:

**Adeyemo Goodness**

Achievement:

**Fundamentals of Generative Artificial Intelligence**

Program:

**UmeraBoost 5.0**

Certificate type:

**Certificate of Completion**

Issue date:

**October 1, 2026**

Certificate ID:

**UMB5-GAI-2026-000001**

Issuer:

**Umera Business School**

Buttons:

**View Certificate**

**Download Certificate**

**Share**

Create a premium, trustworthy design.

---

# 15. VERIFICATION STATES

Design all verification states.

### Valid

✓ VERIFIED

Certificate is authentic.

### Revoked

⚠ CERTIFICATE REVOKED

Certificate is no longer valid.

### Not Found

Certificate could not be found.

### Error

Something went wrong while verifying the certificate.

These are UI states for now.

---

# 16. QR CODE

The eventual certificate will contain a QR code.

The QR code will point to:

`https://cert.umbs.ng/verify/{certificate-id}`

For the prototype, create a placeholder QR code.

Do not modify the existing certificate artwork permanently.

We will determine the exact QR placement during certificate-generation implementation.

---

# 17. ADMIN LOGIN

Create a professional admin login UI.

Brand:

**Umera Certificate Manager**

Fields:

Email

Password

Remember me

Login

Forgot password

This is UI only for now.

---

# 18. ADMIN DASHBOARD

Create a professional dashboard.

Cards:

Participants

Eligible

Certificates Issued

Downloaded

Not Downloaded

Revoked

Example values:

Participants: 1,248

Eligible: 1,087

Certificates Issued: 1,087

Downloaded: 921

Not Downloaded: 166

Revoked: 3

Include:

Recent activity

Certificate download activity

Verification activity

Simple analytics.

Do not overcomplicate the dashboard.

---

# 19. ADMIN SIDEBAR

Navigation:

Dashboard

Programs

Courses

Participants

Registrations

Eligibility

Certificates

Templates

Imports

Downloads

Verification

Reports

Activity Logs

Settings

Use clear icons.

Responsive mobile navigation is required.

---

# 20. PARTICIPANTS PAGE

Create:

Search

Filters

Pagination

Table

Columns:

Name

Email

Course

Program

Eligibility

Certificate

Download status

Actions

Actions:

View

Edit

View Certificate

---

# 21. ELIGIBILITY PAGE

Create:

Total participants

Eligible

Not eligible

Pending review

Table:

Participant

Course

Registration

Attendance

Assessment

Completion

Eligibility

Actions

Status badges:

✓ Eligible

✕ Not Eligible

⏳ Pending

Do not implement real eligibility calculations yet.

Use mock data.

---

# 22. CERTIFICATES PAGE

Create certificate management UI.

Columns:

Certificate ID

Participant

Course

Issue Date

Status

Downloads

Verification

Actions

Statuses:

Generated

Issued

Revoked

Pending

Actions:

View

Download

Verify

Revoke

---

# 23. TEMPLATE MANAGEMENT

Create a certificate template management screen.

Show:

Certificate template preview

Template name

Program

Status

Created date

Actions

Example:

**UmeraBoost 5.0 Certificate**

Status:

**Active**

Include an information box:

**Certificate artwork is locked. Dynamic participant information is rendered separately on the approved certificate template.**

---

# 24. IMPORT PAGE

Create an Excel/CSV import interface.

Title:

**Import Participants**

Drag/drop upload area.

Supported:

`.xlsx`

`.csv`

Process visualization:

Upload
→ Validate
→ Preview
→ Import

Example result:

1,248 records

1,210 valid

25 duplicates

13 errors

Buttons:

**Validate File**

**Import Valid Records**

This is UI only for now.

---

# 25. DOWNLOAD ANALYTICS

Create a downloads page.

Metrics:

Total certificates

Total downloads

Unique downloads

Download rate

Not downloaded

Recent downloads

Include a clean chart.

---

# 26. VERIFICATION ANALYTICS

Create:

Total verification attempts

Valid verifications

Invalid attempts

Revoked certificate checks

Recent verification activity

Keep it simple.

---

# 27. ACTIVITY LOGS

Create an admin activity log page.

Example:

Admin generated certificate

Admin imported participants

Participant downloaded certificate

Certificate verified

Admin changed eligibility

Admin revoked certificate

Show:

Action

User

Target

Date/time

Status

---

# 28. RESPONSIVE DESIGN

The application must work properly on:

Mobile

Tablet

Desktop

Do not simply shrink desktop layouts.

Design the mobile experience intentionally.

The public verification page is especially important on mobile because shared links will commonly be opened from WhatsApp, LinkedIn, email, etc.

---

# 29. COMPONENT ARCHITECTURE

Create reusable Blade components where appropriate.

Examples:

* Button
* Input
* Card
* Badge
* Modal
* Alert
* Toast
* Table
* Pagination
* Certificate Card
* Verification Badge
* Status Badge
* Empty State
* Loading State
* Error State
* Share Modal
* Sidebar
* Navbar

Do not duplicate the same HTML unnecessarily.

---

# 30. JAVASCRIPT

Use vanilla JavaScript for:

* Mobile navigation
* Modals
* Share modal
* Copy verification link
* Loading states
* Preview interactions
* Toast notifications
* UI interactions

Do not introduce React/Vue.

Do not build unnecessary JavaScript frameworks.

Keep JavaScript modular.

---

# 31. MOCK DATA

Use realistic mock data.

Example:

Name:

Adeyemo Goodness

Email:

[goodness@example.com](mailto:goodness@example.com)

Program:

UmeraBoost 5.0

Course:

Fundamentals of Generative Artificial Intelligence

Certificate ID:

UMB5-GAI-2026-000001

Eligibility:

Eligible

Certificate:

Issued

Use additional fictional participants for tables and dashboard statistics.

---

# 32. DO NOT IMPLEMENT YET

Do NOT implement:

* Production database
* Eligibility engine
* Real participant authentication
* Certificate PDF generation
* Real QR generation
* Email notifications
* Real social APIs
* AI integration
* WhatsApp API
* Telegram API
* Payment system
* Production certificate storage

Those will be implemented in later stages.

---

# 33. PREPARE FOR FUTURE BACKEND

Even though we are starting with the UI, structure the code so that it can later connect naturally to Laravel.

Use clean routes.

Use Blade templates.

Use reusable components.

Use mock data in a way that can later be replaced by controllers/models.

Do not hard-code business logic into JavaScript.

The future source of truth will be Laravel.

---

# 34. DESIGN QUALITY REQUIREMENT

Do not produce a generic template.

Think like a senior product designer creating a real product for an established business school.

The UI should be good enough to show to Umera Business School management.

Pay attention to:

* typography
* spacing
* hierarchy
* responsiveness
* button states
* empty states
* error states
* loading states
* visual consistency
* certificate presentation
* trust indicators
* mobile usability

---

# 35. DEVELOPMENT PROCESS

Work incrementally.

STEP 1:
Inspect the existing project.

STEP 2:
Set up/confirm the Blade + CSS + JavaScript foundation.

STEP 3:
Create the main application layout.

STEP 4:
Create the participant certificate portal.

STEP 5:
Create the certificate preview.

STEP 6:
Create the share modal.

STEP 7:
Create the public verification page.

STEP 8:
Create the admin layout.

STEP 9:
Create the admin dashboard.

STEP 10:
Create Participants, Eligibility, Certificates, Templates, Imports, Downloads, Verification, Reports, and Activity Log screens.

STEP 11:
Make everything responsive.

STEP 12:
Review the entire UI for consistency.

Do not attempt all backend functionality in this first stage.

---

# 36. FINAL REQUIREMENT

At the end of this stage, I should be able to run the Laravel application and navigate through a convincing prototype of the complete Umera Certificate Manager.

The prototype should demonstrate:

Participant:

Home
→ Find Certificate
→ Certificate Found
→ Certificate Preview
→ Share
→ Public Verification

Admin:

Login
→ Dashboard
→ Participants
→ Eligibility
→ Certificates
→ Templates
→ Imports
→ Downloads
→ Verification
→ Reports
→ Activity Logs

Use mock data for now.

The next stage will be the real Laravel backend and database implementation.

Do not proceed to Stage 2 automatically.

Finish Stage 1 cleanly and report what was created, what files were changed, and any decisions that need approval.
