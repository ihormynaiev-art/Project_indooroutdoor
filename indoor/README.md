# IndoorOutdoor Application Setup

This project is a Laravel application. Follow the steps below to set it up locally.

---

## Requirements
- PHP >= 8.2
- Composer
- Node.js & npm
- MySQL
- Git

---

## Installation

1. **Clone this repository**

2. **Install PHP dependencies**
   ```
   composer install
3. **Install JavaScript dependencies**
   ```
   npm install
4. **Build frontend assets**
   ```
   npm run dev
5. **Environment configuration**
   ```
   cp .env.example .env
6. **Update .env file with your local database credentials, update other settings, like mailgun API key, if needed**

7. **Generate application key**
   ```
   php artisan key:generate

8. **Run migrations and seeders**
   ```
   php artisan migrate --seed

