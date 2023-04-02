# Weather International Agency Backend API

## Installing dependencies
Laravel is installed locally so you should only have to install php and composer<br >
Install php: https://windows.php.net/download#php-8.2 (choose x64 thread safe)

Install composer: https://getcomposer.org/download/

After which you want to update the repository files by doing: `composer update`
If that is done you can install the remaining needed files by doing: `composer install`

## Changing environment variables
In .env (you may want to copy .env.exmaple into .env) you should add or change the value of `FRONTEND_URL` to `http://localhost:4200` so it connects to the angular application.
Ex: `FRONTEND_URL=http://localhost:4200`
It should be located underneath `APP_URL`

You should also change the database env variables to connect to your database.

## Serving the application
To serve the app use: `php artisan serve` in the project directory.

## If you need to install Laravel or want it globally you can do the following:
### Installing laravel globally:

To install laravel globally do: <br >
`composer global require laravel/installer` <br >
After which you can create a new project by using: <br >
`laravel new <project-name>`

### Install laravel locally:

Otherwise if you want to install it locally, you can do: <br >
`composer create-project laravel/laravel <project-name>`

Installing laravel breeze: <br >
`composer require laravel/breeze --dev` <br >
You will want to do `php artisan breeze:install` to complete the breeze installation

If you get any unzip or fileinfo errors: <br >
Uncomment `;extension=fileinfo` and `;extension=zip` in your php.ini file. (You can use `php --ini` to see which ini file ur using)



## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 2000 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.