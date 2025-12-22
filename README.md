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
- Profile wall (users can post messages on other users’ profiles)

---

## Technical requirements

- PHP 8.4+
- Composer
- Node.js + npm
- Laravel 12
- SQLite (default) or MySQL
- Herd or any local PHP server

---

## Sources / References

- Laravel Documentation  
  https://laravel.com/docs

- Laravel Breeze (authentication starter kit)  
  https://laravel.com/docs/starter-kits#laravel-breeze

- Tailwind CSS Documentation (UI styling)  
  https://tailwindcss.com/docs

- PHP Documentation  
  https://www.php.net/docs.php

- OpenAI ChatGPT  
  https://chat.openai.com  
  Used as a learning and support tool for understanding Laravel concepts,
  debugging errors, and improving code structure. All final code decisions
  and implementation were done by the student.
