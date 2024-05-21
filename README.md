# Laravel 11 with Adminlte3 Template

Welcome to the repository for Laravel 11 integrated with the Adminlte3 template!

## Overview

This repository contains a Laravel 11 template that comes pre-configured with authentication from Jetstream and utilizes the adminlte3 template for the UI.

## Installation Guide

### Prerequisites

-   PHP >= 8.1
-   Composer
-   Node.js
-   npm

### Installation Steps

1. Clone the repository:

    ```bash
    git clone https://github.com/vikarmaulanaarrisyad/starter-template-adminlte-v3-laravel11.git laravel11-adminlte
    ```

2. Navigate into the project directory:

    ```bash
    cd laravel11-adminlte
    ```

3. Install PHP dependencies:

    ```bash
    composer install
    ```

4. Install JavaScript dependencies:

    ```bash
    npm install && npm run dev
    ```

5. Copy the `.env.example` file and rename it to `.env`:

    ```bash
    cp .env.example .env
    ```

6. Generate application key:

    ```bash
    php artisan key:generate
    ```

7. Run database migrations:

    ```bash
    php artisan migrate
    ```

8. Start the development server:
    ```bash
    php artisan serve
    ```

## Contributors

-   **Vikar Maulana** - [GitHub](https://github.com/vikarmaulanaarrisyad)

Feel free to explore their repositories as well.

---

If you encounter any issues or have suggestions for improvements, please feel free to open an issue or submit a pull request. Thank you for your interest and support!
