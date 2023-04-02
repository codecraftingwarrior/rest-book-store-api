# Symfony4.4 REST API with FOSRestBundle and JMS Serializer
This project is a RESTful API for managing books and their authors, built using the Symfony PHP framework with the FOSRestBundle extension.

## Features
- CRUD operations for books and authors
- Query books and authors with filtering, sorting, and pagination
- Ability to generate CRUD REST Controller with `php bin/console make:rest-controller`
- User registration
- JWT based authentication (access & refresh token generation)
- Comprehensive set of Data Fixture using faker package
- Clean and efficient codebase
- Integration with Doctrine ORM for database management

## Installation
To install the project, follow these steps:

- Clone the repository and navigate to the project directory.
- Install dependencies with composer install.
- Configure the database settings in .env.
- Create the database with `php bin/console doctrine:database:create`.
- Run the database migrations with `php bin/console doctrine:migrations:migrate`.
- Start the web server with `php bin/console server:start`.
