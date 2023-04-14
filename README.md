# Weather International Agency Backend API

## Installing dependencies
Laravel is installed locally so you should only have to install php and composer<br >
Install php: https://windows.php.net/download#php-8.2 (choose x64 thread safe)

Install composer: https://getcomposer.org/download/

After which you want to update the repository files by doing: `composer update`
If that is done you can install the remaining needed files by doing: `composer install`

If you get any unzip or fileinfo errors, uncomment `;extension=fileinfo` and `;extension=zip` in your php.ini file. (You can use `php --ini` to see which ini file you are using)

After you have installed the required dependencies copy the `.env.examle` file and rename it to `.env`
You should now only have to do `php artisan key:generate` and you can now serve the application with limited features.

## Changing environment variables
Before the application can work fully you need to connect your database to the server. 
In the `.env` file you should be able to change multiple options about which database to use, where and what user, make sure these are correct.

When you have connected the database to the server, you will still need to import both the weatherstations and employee tables (employee table is not yet implemented in the application)
Just run the according sql file on the database and it should add all the necessary tables/rows.

To import/migrate the (not yet) necessary databases that laravel uses you can run `php artisan migrate` 
When all that is done, you should be completely ready to serve the application

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

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 2000 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Extra

composer update

php artisan migrate

php artisan passport:install

copy tokens to .env file (add these if u dont have them yet, example in .env.example)

PASSPORT_CLIENT_1=<1st key>
PASSPORT_CLIENT_2=<2nd key>

ex:
PASSPORT_CLIENT_1=eCJm1uOyBjPzUJIHaCQD2GiO8mBKL6wkJLIWnksu
PASSPORT_CLIENT_2=41iKUOSJUrVAh0z4EzgfJS8aTlClN7PmKAsiGeoZ

In the frontent copy the .example environements to environments example:
environment.ts.example to environement.ts

copy the 2nd key to environment of frontend (src>environments>environment.development.ts and environment.ts)

seed users table (gives "fake" users):
php artisan db:seed --class=UsersTableSeeder

check database and take an email of a random user

login with the email and the password "password"
password is always "password" for seeds

in console you will get an bearer token