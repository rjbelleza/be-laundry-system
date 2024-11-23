# Laundry System Backend

## Description 
This project is the backend for a laundry management system, built with Laravel 11. It provides RESTful APIs for managing customers, orders, and laundry services.

## Installation 
Follow these steps to set up and run the project locally:

1. **Clone the repository**
    ```bash 
    git clone https://github.com/rjbelleza/be-laundry-system.git 
    cd laundry-system-backend 
    ```

2. **Install dependencies**
    ```bash 
    composer install 
    ```

3. **Set up environment variables**
    Copy the `.env.example` file to `.env` and update the necessary configuration settings (database, mail, etc.).
    ```bash 
    cp .env.example .env 
    ```

4. **Generate application key**
    ```bash 
    php artisan key:generate 
    ```

5. **Run database migrations**
    ```bash 
    php artisan migrate 
    ```    

6. **Run seeders (optional)**
    ```bash 
    php artisan db:seed 
    ```

7. **Start the development server**
    ```bash 
    php artisan serve 
    ```

## Usage
After setting up, you can access the API endpoints via the local development server. Here are some example endpoints:

- `GET /api/customers` - List all customers 
- `POST /api/customers` - Add a new customer 
- `GET /api/orders` - List all orders 
- `POST /api/orders` - Create a new order

## Contributing
For the project contributors, please follow these steps:

1. Fork the repository. 
2. Create a new branch (`git checkout -b feature-branch`). 
3. Make your changes. 
4. Commit your changes (`git commit -m 'Add new feature'`). 
5. Push to the branch (`git push origin feature-branch`). 
6. Create a Pull Request.
