# Multi-User Task Manager API with Role-Based Access and Blade UI

A full-featured Laravel application providing a **Multi-User Task Management API** with **Role-Based Access Control (RBAC)** using **Laravel Sanctum** for API authentication.  
Includes a sleek **Blade-based frontend UI** for user registration, login, task management, and admin controls.

---

## 🚀 Features

### API

- **User Authentication** with Laravel Sanctum (token-based)
- **Role-Based Access Control**:
  - `admin`: full CRUD on all tasks
  - `user`: create tasks & manage only their own tasks
- RESTful API routes for managing tasks:
  - `POST /api/register` — user registration
  - `POST /api/login` — user login (returns token)
  - `POST /api/tasks` — create a new task (any authenticated user)
  - `GET /api/tasks` — admin sees all tasks; users see only their own
  - `PUT /api/tasks/{id}` — update task (admin any, user own only)
  - `DELETE /api/tasks/{id}` — delete task (admin any, user own only)

### Frontend UI (Blade)

- User-friendly registration and login forms
- Dashboard for creating, viewing, editing, and deleting tasks
- Role-aware task listing and actions
- Logout functionality
- Responsive, modern design using Tailwind CSS

---

