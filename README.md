<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/jcorrego/canoe-test/main/public/img/canoe-logo.svg" width="400" alt="Canoe Logo"></a></p>

## Canoe - Developer Test Application
### Investment Funds Management System

An application designed for efficient administration of investment funds, with functionality to manage funds, their aliases, fund managers, and companies they invest in. Special attention is given to detecting potential duplicate fund entries.

### Getting Started

#### Prerequisites
- PHP >= 8.1
- Composer
- MySQL (or your preferred database system)
#### Installation
Clone the repository:
```bash
git clone https://github.com/jcorrego/canoe-test
```

Navigate to the project directory and install dependencies:
```bash
cd investment-funds-management-system
composer install
```

Copy .env.example to .env and configure the database connection details:
```bash
cp .env.example .env
```

Run migrations to set up the database:
```bash
php artisan migrate
```

Run initial seeders to get some sample data in the database:
```bash
php artisan db:seed
```

Generate an application key:
```bash
php artisan key:generate
```

Start the local development server:
```bash
php artisan serve
```

The application should now be accessible at http://localhost.

#### Usage
With the provided sample data, there is a user already created for you to login and test all functionallity:
```
user: admin@canoe-test.test
passwd: qg8MQzP@cN // Yes, its better to copy-paste it.
```

#### Testing

To run tests for the application:

```bash
php artisan test
```

Ensure your .env.testing (if you have one) has the right configurations for your testing database.

#### Scalability and Performance Considerations

- Database tables have been indexed appropriately for fast lookups.
- Interface listings are already paginated to be prepared for
- Consider caching for frequently accessed data to reduce database load.
- For future enhancements, consider adding a rate-limiting feature for API requests.
