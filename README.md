# User Management System

This project is based on Laravel and utilizes FilamentPHP for the dashboard.

## Installation Guide

-   Clone this repo

```
   git clone https://github.com/developedBySwan/user-management-system.git
```

-   Copy the .env.example file to .env:

```
    cp .env.example .env
```

-   Install PHP dependencies using Composer:

```
 composer install
```

-   Install JavaScript dependencies using npm:

```
    npm install
```

-   Generate an application key:

```
    php artisan key:generate
```

-   Set up project data:

```
    php artisan setup:project
```

-   Start the Laravel development server:

```
    php artisan serve
```

### Accessing the Application

Once the server is running, you can access the application by opening your web browser and navigating to http://localhost:8000 (or the specified address if you customized the port).
