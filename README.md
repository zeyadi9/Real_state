# 🏡 Real Estate Management System

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Flutter](https://img.shields.io/badge/Flutter-02569B?style=for-the-badge&logo=flutter&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-00000F?style=for-the-badge&logo=mysql&logoColor=white)

A comprehensive Real Estate Management System featuring a robust Laravel web backend for administration and a cross-platform Flutter mobile application for seamless user access.

---

## ✨ Features

### 🖥️ Backend (Laravel Web Portal)
- **Role-Based Access Control (RBAC):** Secure and structured access for Admins and standard Users.
- **Property Management:** Add, update, delete, and mark properties as sold. Detailed tracking of financial aspects including deposits and sale prices.
- **Audit Logs:** Comprehensive tracking of all actions taken within the system for security and monitoring.
- **RESTful API:** Secure API endpoints equipped with token-based authentication (Sanctum) for the mobile application.
- **Data Exporting:** Easily export property lists, logs, and reports to Excel.

### 📱 Mobile App (Flutter)
- **User Authentication:** Secure login gateway for users and agents.
- **Property Listings:** Browse available properties with detailed specifications (rooms, bathrooms, financial details).
- **Dynamic Integration:** Fetches real-time, up-to-date property information directly from the Laravel API.

---

## 🛠️ Tech Stack

- **Backend:** PHP, Laravel, MySQL
- **Mobile:** Dart, Flutter
- **Frontend (Web Dashboard):** Blade Templates, HTML/CSS

---

## 🚀 Installation & Local Setup

### 1️⃣ Backend Setup (Laravel)
1. **Clone the repository:**
   ```bash
   git clone https://github.com/zeyadi9/Real_state.git
   ```
2. **Install PHP dependencies:**
   ```bash
   composer install
   ```
3. **Setup environment variables:**
   ```bash
   cp .env.example .env
   ```
4. **Generate application key:**
   ```bash
   php artisan key:generate
   ```
5. **Configure your database** in the `.env` file.
6. **Run migrations:**
   ```bash
   php artisan migrate
   ```
7. **Start the local server:**
   ```bash
   php artisan serve
   ```

### 2️⃣ Mobile App Setup (Flutter)
1. **Navigate to the mobile app directory:**
   ```bash
   cd mobile_app
   ```
2. **Install Flutter dependencies:**
   ```bash
   flutter pub get
   ```
3. **Configure API connection:**
   Update the `baseUrl` inside `lib/api_service.dart` to match your backend's URL.
4. **Run the application:**
   ```bash
   flutter run
   ```

---

## 📁 Project Structure

- `app/` - Laravel backend core code (Controllers, Models, Middleware).
- `mobile_app/` - Flutter source code encompassing the entire mobile application.
- `database/migrations/` - Database schemas and version control.
- `routes/` - Web and API endpoint definitions.
- `resources/views/` - Web portal UI components (Properties, Users, Audit Logs).

---

*Designed and Developed for seamless Real Estate operations.*
