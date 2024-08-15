# Laravel SOA E-Commerce

## Overview

`laravel-soa-ecommerce` is a modern e-commerce application built with Laravel, designed to demonstrate a Service-Oriented Architecture (SOA). This application features:

- User registration and authentication using JWT tokens.
- Product management with CRUD operations.
- Order placement supporting one or multiple products.
- An architecture based on SOA for enhanced scalability and maintainability.

## Features

- **User Registration and Authentication**: Register users and manage authentication using JWT tokens.
- **Product Management**: Perform CRUD operations to manage products including fields such as name, description, price, and quantity.
- **Order Placement**: Place orders with one or more products.
- **SOA Architecture**: Designed using Service-Oriented Architecture principles.

## Getting Started

### Prerequisites

- PHP 8.0 or higher
- Composer
- Laravel 10.x
- MySQL or another supported database

### Installation

1. **Clone the Repository**

   ```bash
   git clone https://github.com/your-username/laravel-soa-ecommerce.git
   cd laravel-soa-ecommerce
   ```

2. **Install Dependencies**

   ```bash
   composer install
   ```

3. **Set Up Environment File**

   Copy the example environment file and update the configuration as needed.

   ```bash
   cp .env.example .env
   ```

   Edit the `.env` file to configure your database and other environment settings.

4. **Generate Application Key**

   ```bash
   php artisan key:generate
   ```

5. **Run Migrations and Seed Database**

   ```bash
   php artisan migrate --seed
   ```

6. **Serve the Application**

   ```bash
   php artisan serve
   ```

   The application will be available at [http://localhost:8000](http://localhost:8000).

## Database Design

The database schema includes the following tables and relationships:

- **Users**: Stores user details.
- **Products**: Stores product details.
- **Orders**: Stores order details, including relationships to users and products.

SQL commands to create the database tables are included in the `database/migrations` directory.

## Code Review

The code has been reviewed with a focus on:

1. **Security**: Ensuring proper validation and sanitization of user inputs to prevent vulnerabilities.
2. **Performance**: Optimizing database queries and ensuring efficient data handling.
3. **Maintainability**: Following best practices in coding standards and architectural design.

## Documentation

API documentation is provided in OpenAPI (Swagger) format and is available in the `docs` directory.

## Contributing

Contributions are welcome! Feel free to submit issues, feature requests, or pull requests.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

---

For any questions or further information, please contact [ghaithhamwi123@outlook.com](mailto:ghaithhamwi123@outlook.com).
