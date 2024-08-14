![darkside developments logo](resources/images/dslogo.png)

# DarksideTechTest
Technical test for Darkside Developments, task specifications include a basic html form with backend services

## The Brief

The objective of this exercise is to develop a straightforward form that can save and update customer information, such as name, email, phone, and address, to a database. The preferred technologies for this task are PHP, specifically with the Laravel framework for the server-side, and VueJS for the client-side.

Please ensure that any client-side code adheres to the same principles as the server-side code. Additionally, it is essential to follow engineering best practices throughout the project.

The principles we prioritize include security, performance, readability, testability, scalability, and simplicity. Please incorporate these principles into your solution.

Furthermore, strive to achieve a clear separation of concerns between the various components of your solution. Utilizing the MVC pattern, for instance, can facilitate this separation.

If Docker is not utilized, your application should retrieve and store data by reading from and writing to a file on disk, instead of utilizing a relational or NoSQL solution for the datastore.

## Technology Choices

Kanban board: https://trello.com/b/Bcg9JtCQ/darkside-technical

While the prefered technologies were listed as follows: php/laravel, vueJS composition API and MySQL, these technologies were not strict requirements. However I chose to use these technologies so that I may use this technical test as an exercise and opportunity to learn these technologies before deciding on a fallback tech stack, by making this choice i have gained a degree of confidence in working with laravel. I used Laravel with a breeze template for inertia.JS with VueJS and tailwindCSS for my frontend and backend architecture, the database technology used throughout the development, testing and dockerization of this project was MySQL as I am already familiar with SQL coming from PostGreSQL so i saw this as an inconsequential step with technology alongside the eloquent ORM built into laravel that removed the need for raw SQL queries.

PHPUnit was used for testing this application and sail to dockerize and deploy the application.

The structure of this application was built using Security best practices and MVC principles and using php artisan for the proper generation and location of files.

## Setting up the application

In order to setup the application first a .env file must be created, this can be done using the .env.example file which also includes database connection environment variables. For use in docker with sail the default env variable configuration for the database is 
```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=sail
DB_PASSWORD=password
```

Mailhog is also required for local testing of mailing services and email verification, an example connection is provided in the .env.example file
```
MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

## Running the application

1. in order to run the application first clone the repository to a local repo preferably on a linux system
`git clone https://github.com/The-Nightman/Darkside-Technical-Test.git`

2. cd into the project folder containing the application files
`cd Darkside-Technical-Test`

3. to start the dockerized version of the app run the following command in your terminal
```
./vendor/bin/sail up
```
if this fails or appears to freeze then you can attempt to cancel and then run the following command before running the `up` command again
```
./vendor/bin/sail build
```

4. once the application is running in a docker container you will need to run the following commands to guarantee the application is functional by running a migration to build the database, seeding the database with test data and creating a storage link by running the following commands in the terminal inside the application folder
```
./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan db:seed
./vendor/bin/sail artisan storage:link
```

5. you can now access the application at the localhost address shown in the terminal

this may not be needed but if the application appears to be broken and missing pages or elements you can rebuild the frontend by running the following command
```
./vendor/bin/sail npm run build
```

6. to stop the application either ctrl+c or if the container is running in the background then run the following command
```
./vendor/bin/sail stop
```

7. test the mailhog service by opening the address `http://localhost:8025/` in your browser, this should open the mailhog web interface. By default the docker-compose yaml will map mailhog to the ports 1025 and 8025 on localhost 

### Running tests

in order to run the feature tests within the project run the following command in the terminal, note that this requires you to revert back to step 4 in order to populate the database again
```
./vendor/bin/sail test
```

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
