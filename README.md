# How to Run the Project

This project is built using Vue 3 for the frontend and Laravel for the backend. To run this project, you will need to have the following installed on your system:

- Composer
- Node.js
- MySQL

## Steps to Run the Project

### 1. Clone the Repository

First, clone the repository to your local machine.

### 2. Install Frontend Dependencies

Navigate into the frontend directory and install the necessary dependencies:

```bash
cd frontend
npm install
npm run dev
```

### 3. Install Backend Dependencies

Navigate into the backend directory and install the necessary dependencies:

```bash
cd backend
composer install
```

### 4. Configure Environment

Create a `.env` file by copying the contents of `.env.example`:

```bash
cp .env.example .env
```

Generate the application key:

```bash
php artisan key:generate
```

Run migrations and seed the database:

```bash
php artisan migrate --seed
```

### 5. Serve the Application

Run the following command to start the Laravel development server:

```bash
php artisan serve
```

Now, your project should be up and running!