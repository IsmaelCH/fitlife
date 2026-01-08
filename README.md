# FitLife — Laravel Data-Driven Web Application

FitLife is a minimal and modern fitness community website built with Laravel.
The project demonstrates authentication, role management, CRUD operations,
database relations, and a clean MVC structure.

This project was developed as part of an assignment for Erasmus Hogeschool Brussel.

---

## Features

### Authentication
- User registration and login
- Logout and “remember me”
- Password reset (forgot password)
- Default admin account created via seeder

### User roles
- Users are either **regular users** or **admins**
- Only admins can:
  - create users manually
  - promote or demote users to admin
  - manage news, FAQ, and contact messages

### Public profiles
- Every user has a **public profile page** (accessible without login)
- Logged-in users can edit their own profile:
  - username (optional)
  - birthday (optional)
  - bio (optional)
  - profile photo upload (stored on the server)

### News
- Public news list and detail pages
- Admin CRUD (create, edit, delete news)
- Each news item contains:
  - title
  - image (stored on server)
  - content
  - publication date

### FAQ
- Public FAQ page grouped by categories
- Admin CRUD for FAQ categories and questions

### Contact
- Public contact form
- When submitted, the admin receives an email
- Admin panel to view all contact messages and reply by email (extra feature)

### Extra features
- Users can comment on news items
- Admin contact inbox with reply functionality
- Profile wall (users can post messages on other users’ profiles)- Profile post comments (users can comment on wall posts)
- Modal popups for viewing full news articles and profile posts
- Wger Fitness API integration for exercises, nutrition, and workout plans
---

## Technical Stack

### Backend
- **PHP 8.4+**
- **Laravel 12** (latest version)
- **SQLite** (default) or MySQL/PostgreSQL
- **Laravel Breeze** for authentication scaffolding
- **Eloquent ORM** for database operations

### Frontend
- **Tailwind CSS** for styling
- **Blade** templating engine
- **Vite** for asset bundling
- **Alpine.js** (included with Breeze)
- Vanilla JavaScript for modal interactions and AJAX

### Development Tools
- **Composer** (PHP dependency manager)
- **NPM** (Node package manager)
- **Laravel Herd** or any local PHP server
- **Git** for version control

---

## Installation & Setup

1. Clone the repository
2. Install PHP dependencies: `composer install`
3. Install Node dependencies: `npm install`
4. Copy `.env.example` to `.env`
5. Generate application key: `php artisan key:generate`
6. Run migrations: `php artisan migrate`
7. Seed database: `php artisan db:seed`
8. Link storage: `php artisan storage:link`
9. Build assets: `npm run dev`
10. Start server: `php artisan serve` or use Laravel Herd

Default admin credentials (from seeder):
- Email: admin@fitlife.test
- Password: password

---

## Sources & Resources

### Documentation & Frameworks
- **Laravel Documentation**  
  https://laravel.com/docs  
  Complete framework documentation and guides

- **Laravel Breeze**  
  https://laravel.com/docs/starter-kits#laravel-breeze  
  Authentication starter kit with Blade templates

- **Tailwind CSS Documentation**  
  https://tailwindcss.com/docs  
  Utility-first CSS framework for styling

- **PHP Documentation**  
  https://www.php.net/docs.php  
  Official PHP language reference

- **Alpine.js Documentation**  
  https://alpinejs.dev  
  Lightweight JavaScript framework for interactivity

### External APIs
- **Wger Workout Manager API**  
  https://wger.de/api/v2/  
  Free fitness API for exercises, nutrition, and workout plans

### Development Tools & AI Assistants
- **GitHub Copilot**  
  https://github.com/features/copilot  
  AI-powered code completion and assistance tool used throughout development
  for code suggestions, debugging, and learning Laravel best practices

- **OpenAI ChatGPT**  
  https://chat.openai.com  
  Used as a learning tool for understanding Laravel concepts, debugging errors,
  exploring design patterns, and improving code structure

- **Claude (Anthropic)**  
  AI assistant used for code review, architecture decisions, and implementation
  guidance throughout the project development

### Design Resources
- **Unsplash**  
  https://unsplash.com  
  Stock photos for news article placeholders

- **Heroicons**  
  https://heroicons.com  
  SVG icon set integrated throughout the interface

### Learning Resources
- **Laracasts**  
  https://laracasts.com  
  Video tutorials for Laravel best practices

- **Laravel News**  
  https://laravel-news.com  
  Latest Laravel ecosystem updates and tutorials

- **Stack Overflow**  
  https://stackoverflow.com  
  Community Q&A for troubleshooting specific issues

- **MDN Web Docs**  
  https://developer.mozilla.org  
  JavaScript, HTML, and CSS reference documentation

---

## Academic Integrity Statement

All code in this project was written by the student with assistance from AI tools
(GitHub Copilot, ChatGPT, Claude) used as learning aids and productivity enhancers.
The student maintains full understanding of all implemented features and can explain
any part of the codebase. AI tools were used for:
- Code suggestions and autocompletion
- Debugging assistance
- Learning Laravel best practices
- Exploring different implementation approaches

Final decisions on architecture, design, and implementation were made by the student.

---

## License

This is an educational project developed for Erasmus Hogeschool Brussel.
All rights reserved by the student author.
