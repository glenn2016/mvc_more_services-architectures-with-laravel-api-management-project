# Project Management App

## 📝 Project Description
This project is a **project management application** designed to create and track projects with fine-grained user and task management.

The application is built around a **role-based system** with two types of users:

- **Team Leader**:
  - Can create new projects.
  - Can automatically add members to a team.
  - Can assign tasks to team members within a project.

- **Member**:
  - Receives tasks assigned by the team leader.
  - Participates in the progress of the projects they are assigned to.

The goal is to provide a solid foundation for a collaborative project tracking tool, with a clear hierarchy and role-based responsibilities.

## 🛠️ Technologies Used
- Laravel 12
- MySQL 
- Composer
- jwt for API auth



## ⚙️ Installation

```bash
# 1. Clone the repository
https://github.com/glenn2016/clean-architectures-with-laravel-api-management-project.git

# 2. Move into the project directory
cd api_managaement_poject

# 3. Install PHP dependencies via Composer
composer install

# 4. Copy and configure the environment file
cp .env.example .env

# 5. Generate the application key
php artisan key:generate
php artisan jwt:secret

# 6. Set your database credentials in the .env file

# 7. Run migrations 
php artisan migrate

# 8. Start the local development server
php artisan serve
