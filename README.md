# Laravel 12 + Vue 3 + Inertia.js + Tailwind CSS Installation Guide

## Prerequisites
Make sure you have the following installed on your system:

- PHP 8.2 or later
- Composer
- Node.js and npm
- MySQL or PostgreSQL (or any other supported database)
- Laravel Installer (optional)

## Installation Steps

### 1. Clone the Existing Project
```sh
git clone <repository-url> my-project
cd my-project
```

### 2. Install PHP Dependencies
```sh
composer install
```

### 3. Copy Environment File and Set Up Configuration
```sh
cp .env.example .env
```
Update `.env` with your database credentials and other necessary configurations.

### 4. Generate Application Key
```sh
php artisan key:generate
```

### 5. Install Node.js Dependencies
```sh
npm install
```

### 6. Run Migrations and Seed Database (If applicable)
```sh
php artisan migrate --seed
```

### 7. Start the Development Server
```sh
npm run dev
php artisan serve
```

## Usage
- Visit `http://127.0.0.1:8000` to see your Laravel + Vue + Inertia + Tailwind setup.
- You can now start building your application!
