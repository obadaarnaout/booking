# Escape Room Booking System

The Escape Room Booking System is a web application that allows users to book escape rooms and manage their bookings. This project is built with Laravel, a popular PHP framework.

## Getting Started

These instructions will guide you on how to set up and run the project on your local machine.

### Prerequisites

To run this project, make sure you have the following software installed:

- PHP 7.4 or higher
- Composer
- MySQL or another compatible database system

### Installation

1. Clone the repository to your local machine:

```bash
git clone https://github.com/obadaarnaout/booking.git
```

2. Navigate to the project directory:

```bash
cd booking
```

3. Install the project dependencies:

```bash
composer install
```

4. Create a copy of the `.env.example` file and rename it to `.env`. Update the database configuration in the `.env` file to match your local environment.

5. Generate an application key:

```bash
php artisan key:generate
```

6. Run the database migrations and seed the database with sample data: (users password 12345678)

```bash
php artisan migrate --seed
```

7. Start the development server:

```bash
php artisan serve
```

8. You can now access the application in your web browser at `http://localhost:8000`.

## Testing

The project includes automated tests to ensure the correctness and reliability of the API. To run the tests, use the following command:

```bash
php artisan test
```

## Postman API Documentation

Please refer to the [API documentation](https://documenter.getpostman.com/view/5259779/2s93eePTrF) for detailed information on each route.

## API Routes

The following are the available API routes:

- `/api/login`: POST request to authenticate a user and retrieve an access token.
- `/api/escape-rooms`: GET request to retrieve a list of escape rooms.
- `/api/escape-rooms/{id}`: GET request to retrieve details of a specific escape room.
- `/api/escape-rooms/{id}/time-slots`: GET request to retrieve the time slots available for a specific escape room.
- `/api/bookings`: POST request to create a new booking.
- `/api/bookings`: GET request to retrieve the user's bookings.
- `/api/bookings/{id}`: DELETE request to cancel a booking.


