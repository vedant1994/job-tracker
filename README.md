# Job Tracker 💼 AI-Powered Application Manager

A modern, full-stack Laravel application designed to help job seekers organize, track, and optimize their job search workflow. Integrated with **Google Gemini AI**, Job Tracker provides automated AI tools for drafting cover letters, preparing for interview questions, and scoring resume suitability against job descriptions.

---

## 🌟 Key Features

- 📊 **Interactive Dashboard**: Gain an overview of your job search progress with metrics tracking total applications, active interviews, offers, and rejections.
- 📋 **Job Application Tracking (CRUD)**: Manage job listings with key details including:
  - Company name & Job title
  - Job posting URL & full description
  - Application status (`saved`, `applied`, `interview`, `offer`, `rejected`)
  - Application date & submission deadline
  - Expected salary range & personal notes
- 🤖 **AI-Powered Career Tools (Google Gemini AI)**:
  - 📄 **Cover Letter Generator**: Creates a professional, customized 3-paragraph cover letter tuned to the specific job description.
  - ❓ **Interview Preparation**: Generates 7 targeted, role-specific interview questions accompanied by strategic tips for answering them effectively.
  - 🎯 **Resume Match Scorer**: Evaluates user-provided resume text against the job description to output a match score out of 100, top 3 strengths, top 3 skill gaps, and a concise verdict.
  - 📜 **AI Generation History**: Automatically saves generated cover letters, interview Q&As, and resume feedback for easy reference.
- 🔒 **User Authentication & Profile Management**: Powered by Laravel Breeze for secure multi-user registration, login, and profile administration.

---

## 🛠️ Tech Stack

- **Backend**: [Laravel 12.x](https://laravel.com) (PHP 8.2+)
- **Frontend**: Blade Templates, [Tailwind CSS v4](https://tailwindcss.com), [Alpine.js](https://alpinejs.dev), [Vite 7](https://vitejs.dev)
- **Database**: SQLite (default), compatible with MySQL / PostgreSQL
- **AI Integration**: Google Gemini API (`gemini-flash-latest`) via Laravel HTTP Client
- **Authentication**: Laravel Breeze

---

## 📁 Directory Structure

```text
job-tracker/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── AiGenerationController.php    # Handles AI prompts & Gemini API integration
│   │       ├── DashboardController.php       # Dashboard metrics & analytics logic
│   │       ├── JobApplicationController.php  # Job CRUD & status updates
│   │       └── ProfileController.php         # User profile management
│   └── Models/
│       ├── AiGeneration.php                  # Saved AI outputs
│       ├── JobApplication.php                # Primary application model
│       └── User.php                          # User authentication model
├── config/
│   └── services.php                          # Configured for Gemini API service
├── database/
│   ├── migrations/                           # Schema migrations (users, job_applications, ai_generations)
│   └── database.sqlite                       # Default local database
├── resources/
│   ├── views/
│   │   ├── dashboard.blade.php               # Overview dashboard UI
│   │   └── jobs/                             # Job views (index, create, show, edit)
├── routes/
│   ├── auth.php                              # Authentication routes
│   └── web.php                               # Main application & AI routes
└── tests/                                    # Feature and Unit tests
```

---

## 🚀 Getting Started

### Prerequisites

Ensure you have the following installed on your system:
- **PHP** >= 8.2 with PDO and SQLite extensions enabled
- **Composer**
- **Node.js** (v18+) & **npm**

### Installation Steps

1. **Clone the Repository**
   ```bash
   git clone https://github.com/vedant1994/job-tracker.git
   cd job-tracker
   ```

2. **Install PHP Dependencies**
   ```bash
   composer install
   ```

3. **Install & Build Frontend Assets**
   ```bash
   npm install
   npm run build
   ```

4. **Environment Setup**
   Copy `.env.example` to create your local `.env` configuration file:
   ```bash
   cp .env.example .env
   ```

5. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

6. **Configure Google Gemini API Key**
   Add your Google Gemini API key to your `.env` file:
   ```env
   OPENAGEMINI_API_KEY=your_gemini_api_key_here
   ```

7. **Run Database Migrations**
   Initialize the SQLite database schema:
   ```bash
   php artisan migrate
   ```

---

## 💻 Running the Application

### Development Server

You can run all development processes simultaneously using the built-in Composer command:

```bash
composer run dev
```

This command runs `php artisan serve`, `queue:listen`, `pail`, and `npm run dev` concurrently.

Alternatively, you can launch the HTTP server and Vite dev asset builder separately:

```bash
php artisan serve
```
and in another terminal window:
```bash
npm run dev
```

Open your browser and navigate to `http://127.0.0.1:8000`.

---

## 🗄️ Database Schema Summary

- **`users`**: Manages account credentials, authentication, and user profile data.
- **`job_applications`**:
  - `user_id` (foreign key)
  - `company_name`, `job_title`, `job_url`, `job_description`
  - `status` (`saved`, `applied`, `interview`, `offer`, `rejected`)
  - `applied_date`, `deadline`, `salary_range`, `notes`
- **`ai_generations`**:
  - `user_id` (foreign key), `job_application_id` (foreign key)
  - `type` (`cover_letter`, `interview_questions`, `resume_score`)
  - `result` (long text response from Gemini AI)

---

## 🧪 Testing

Run automated tests using PHPUnit / Artisan test runner:

```bash
composer test
```
or
```bash
php artisan test
```

---

## 📄 License

This project is open-sourced software licensed under the [MIT License](LICENSE).
