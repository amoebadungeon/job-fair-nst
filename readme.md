Job Fair Web Application

A comprehensive web application for managing job fair events, featuring exhibitor registration, session bookings, a contact form, and an interactive frontend built with Vue.js.
✨ Key Features

    📝 Exhibitor & Contact Forms: Secure registration for exhibitors and a validated contact form for inquiries.

    📅 Session Reservations: Users can book slots for job matching sessions and career talks.

    🤖 Interactive UI: A dynamic frontend with a live countdown timer, interactive layouts, and a Dialogflow chatbot.

    🔐 RESTful API: A clean PHP backend with logical endpoints for managing all data.

🛠 Technology Stack
Area	Technology	Purpose
Backend	PHP 8.x	Server-side Logic
	MySQL	Database Management
	Apache	Web Server
Frontend	Vue.js 3	Reactive UI Framework
	Axios	HTTP Requests
	CSS / SCSS	Styling & Animations
🚀 Getting Started

Follow these steps to set up the project on your local machine.
Prerequisites

    XAMPP (or any Apache/MySQL/PHP environment)

    Node.js and npm (for the Vue.js frontend)

    Composer (for PHP dependencies)

1. Clone the Repository
code Bash

    
# Clone the project into your htdocs folder
git clone https://your-repository-url.com/job-fair-app C:\xampp\htdocs\job-fair-app

  

2. Backend Setup
code Bash

    
# 1. Navigate to the backend directory
cd C:\xampp\htdocs\job-fair-app\backend

# 2. Install PHP dependencies (e.g., for Dialogflow API)
composer install

# 3. Create the database
#  - Start Apache and MySQL in XAMPP.
#  - Go to http://localhost/phpmyadmin
#  - Create a new database named `job_fair`.
#  - Select the `job_fair` database and go to the "Import" tab.
#  - Upload the `database/job_fair.sql` file to create the tables.

# 4. Check database connection
#  - Open `backend/config/database.php` and ensure the credentials
#    match your XAMPP setup (default is usually 'root' with no password).

  

3. Frontend Setup
code Bash

    
# 1. Navigate to the frontend directory in a new terminal
cd C:\xampp\htdocs\job-fair-app\frontend

# 2. Install all necessary Node.js packages
npm install

# 3. Run the Vue.js development server
npm run serve

# Your application will be available at http://localhost:8080 (or another port if 8080 is busy)

  

📡 API Endpoints

The backend provides the following core API endpoints.

Base URL: http://localhost/job-fair-app/backend/api/
Method	Endpoint	Description
POST	/exhibitor.php	Submits a new exhibitor registration.
POST	/create_reservation.php	Creates a new session reservation.
GET	/reservation.php	Fetches booked session slots.
POST	/chatbot.php	Sends a message to the Dialogflow chatbot.
📁 Project Structure
code Code

    
job-fair-app/
├── 📂 backend/
│   ├── 📂 api/                   # API endpoint scripts
│   ├── 📂 config/                # Database & API keys
│   ├── 📂 models/                # PHP data models
│   ├── 📂 vendor/                # Composer dependencies
│   └── .htaccess               # Global server rules
├── 📂 database/
│   └── job_fair.sql              # Database schema
└── 📂 frontend/
    ├── 📂 public/
    └── 📂 src/                   # Vue.js source code```


**Install dependencies**
   ```bash
   npm install
   ```
 **Extract or clone the project**
   ```bash
   cd frontend/job-fair-app
   ```
**Run development server**
   ```bash
   npm run serve
   ```

**Open in browser**
   - Navigate to `http://localhost:5173` (or the URL shown in terminal)

### Build for Production

```bash
npm run build