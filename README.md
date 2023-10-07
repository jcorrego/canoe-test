<p align="center"><a href="#" target="_blank"><img src="https://raw.githubusercontent.com/jcorrego/canoe-test/main/public/img/Canoe-Logo.svg" width="400" alt="Canoe Logo"></a></p>

# Canoe - Developer Test Application
## Investment Funds Management System

An application designed for efficient administration of investment funds, with functionality to manage funds, their aliases, fund managers, and companies they invest in. Special attention is given to detecting potential duplicate fund entries.

## Getting Started

This a backend only prototype, so no interface is provided. All routes are inside the `/api` space.
No authentication is present for simplicity.

This are the available routes:

- GET `/api/funds`
List of funds resources, paginated by 15 items, with available filters for name, manager_id, manager (name), start_year.
`https://canoe.orrego.dev/api/funds?manager=as`

- POST `/api/funds` Endpoint for creating a new fund.

- GET `/api/funds/{id}` Get one fund resource.

- PUT `/api/funds/{id}` Update field values on specified resource.

- DELETE `/api/funds/{id}` Remove the resource from database.

The best an easiest way to test the available services is to use the postman collection available here:

https://www.postman.com/solar-moon-680700/workspace/canoe-test/folder/357302-70a72f42-ebd0-4c78-b3b5-583e92fb9977?action=share&creator=357302&ctx=documentation

In that collection you can find samples of the different filters, updates, etc.

And the demo site available here: https://canoe.orrego.dev

### Testing Potential Duplicates

For testing the potential duplicates functionality, you can follow the next steps:
1. Query for potential duplicates, it should be empty at first. `/api/duplicates`
2. Query all funds using the `/api/funds` endpoint.
3. Copy the exact name of the first Fund, and take note of the manager id.
4. Use the create Fund endpoint (POST `api/funds`) with the name and the manager_id from the previous step.
5. Query for duplicates again and you should see 1 record.
6. You can repeat the process using aliases and it should work the same.

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

> Note: I'm not including instructions on how to setup the database here, because i assume you already have that knowledge and it depends on your environment setup.

Run migrations to set up the database:
```bash
php artisan migrate
```

Run initial seeders to get some sample data in the database:
```bash
php artisan db:seed
```

> Note: if you need to reset the DB to the initial state you can run the following command:
`php artisan migrate:fresh --seed`

Generate an application key:
```bash
php artisan key:generate
```

Start the local development server:
```bash
php artisan serve
```

The application should now be accessible at http://localhost.

#### Testing

To run tests for the application:

```bash
php artisan test
```

Ensure your .env.testing (if you have one) has the right configurations for your testing database.

#### Scalability and Performance Considerations

- Database tables have been indexed appropriately for fast lookups.
- Listings are already paginated to be prepared for large datasets.
- Consider caching for frequently accessed data to reduce database load.
- For future enhancements, consider adding a rate-limiting feature for API requests.

### DB diagram
<img src="https://raw.githubusercontent.com/jcorrego/canoe-test/main/resources/docs/dbd.png" width="100%" alt="ER Diagram">
