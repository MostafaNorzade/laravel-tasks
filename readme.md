## Laravel-daily-Tasks

Laravel 8 with user authentication, password recovery, and individual user tasks lists. This also makes full use of Controllers for the routes, templates for the views, and makes use of middleware for routing.  Uses laravel ORM modeling and has CRUD (Create Read Update Delete) functionality for all tasks.

This is a sample usage of my laravel-temp-tag package. When you mark a daily-task as done, it will automatically return back to in-complete state for tomorrow.

Super easy setup, can be done in 5 minutes or less.

| Laravel-Daily-Tasks Features|
|Built on [Laravel](http://laravel.com/) 8|
|CRUD (Create, Read, Update, Delete) Tasks Management|
|User Registration with password reset via Email|
|User Login with remember password|

### Quick Project Setup
1. Run `sudo git clone https://github.com/imanghafoori1/laravel-tasks.git laravel-tasks`
2. From the projects root run `cp .env.example .env`
3. Configure your `.env`
4. Run `sudo composer update` from the projects root folder
5. From the projects root folder run `sudo chmod -R 755 ../laravel-tasks`
6. From the projects root folder run `php artisan task:install` to migrate and seed

#### View the Project in Browser
1. From the projects root folder run `php artisan serve`
2. Open your web browser and go to `http://localhost`


### Laravel-Tasks Authentication URL's (routes)
* ```/```
* ```/auth/login```
* ```/auth/logout```
* ```/auth/register```
* ```/password/reset```

### Laravel-Tasks URL's (routes)
* ```/home```
* ```/tasks```
* ```/tasks/create```
* ```/tasks/{id}/edit```

---
