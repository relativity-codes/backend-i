# Laravel Project Setup

## Prerequisites

- PHP (>= 7.4)
- Composer

## Installation Steps

1. **Clone the Repository**

   ```bash
   git clone https://github.com/relativity-codes/backend-i.git 
   cd backend-i
   ```

2. **Install Dependencies**

   ```bash
   composer install
   ```

3. **Set Up Environment**
   - Copy the `.env.example` file to `.env`

        ```bash
        cp .env.example .env
        ```

   - Generate the application key:

        ```bash
        php artisan key:generate
        ```

4. **Configure SQLite Database**
   - In the `.env` file, set the database connection to SQLite:

        ```plaintext
        DB_CONNECTION=sqlite
        DB_DATABASE=/absolute/path/to/database.sqlite  (optional)
        ```

   - Also setup aws for sms service

        ```plaintext
        AWS_ACCESS_KEY_ID=
        AWS_SECRET_ACCESS_KEY=
        ```

    - Create an empty SQLite file in your project directory (optional):

        ```bash
        touch database/database.sqlite
        ```

5. **Run Migrations and Seed Database (if applicable)**

   ```bash
   php artisan migrate --seed
   ```

6. **Start the Local Server**

   ```bash
   php artisan serve
   ```

## Additional Commands

- **Clear Cache (if needed):**

  ```bash
  php artisan config:cache
  php artisan route:cache
  php artisan view:cache
  ```

## Access the Application Documentation

Visit `http://127.0.0.1:8000/docs/api` for the API documentation.

## Note

This project is a basic Laravel setup and may require additional configuration and customization to meet your specific needs.
