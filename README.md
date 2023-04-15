# Weather International Agency Backend API

## Installing dependencies
Laravel is installed locally so you should only have to install php and composer<br >
Install php: https://windows.php.net/download#php-8.2 (choose x64 thread safe)

Install composer: https://getcomposer.org/download/

After which you want to update/install the remaining vendor files by doing: `composer update`

If you get any unzip or fileinfo errors, uncomment `;extension=fileinfo`, `;extension=zip` and `;extension=pdo_mysql` in your php.ini file. (You can use `php --ini` to see which ini file you are using)

After you have installed the required dependencies copy the `.env.examle` file and rename it to `.env`
You should now only have to do `php artisan key:generate` and you can now serve the application with limited features.

## Changing environment variables
Before the application can work fully you need to connect your database to the server. 
In the `.env` file you should be able to change multiple options about which database to use, where and what user, make sure these are correct.

When you have connected the database to the server, you will still need to import both the weatherstations and employee tables (employee table is not yet implemented in the application)
Just run the according sql file on the database and it should add all the necessary tables/rows.

To import/migrate the (not yet) necessary databases that laravel uses you can run `php artisan migrate` 
If this command fails be sure to have `;extension=pdo_mysql` uncommented in your php.ini file.
When all that is done, you should be completely ready to serve the application

## Installing passport
Make sure the previous 2 steps are complete (and u have updated the dependecies to the lastest version with `composer update`)

If you havn't yet, migrate the necessary tables to the database with `php artisan migrate` </br>
If that's done you can install passport: `php artisan passport:install` </br>
The terminal or commandprompt, whatever you are using, should print out the following:
```
Encryption keys generated successfully.
Personal access client created successfully.
Client ID: 1
Client secret: xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
Password grant client created successfully.
Client ID: 2
Client secret: xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
```
Copy both client secrets to the right environmental variable in your .env, if you have an older .env file you can look at the example in .env.example </br>
You will also want to copy the client 2 key to your frontend environment variables. This is so you can send request where authentication is required.

You can now create a random set of 10 users, of which the password is `password` with the command: < /br>`php artisan db:seed --class=UsersTableSeeder` </br>
In the database you should now have 10 users, of which you can choose one to login and test the appropriate features on your frontend

## Serving the application
To serve the app use: `php artisan serve` in the project directory.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 2000 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.
