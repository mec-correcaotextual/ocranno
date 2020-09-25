# OCRAnno - OCR text annotation tool

OCRAnno is a text annotation tool designed to provide annotated data to improve the results of OCR systems. OCRAnno is being developed as part of a collaboration between the Institute of Informatics at UFRGS and Petrobras.

## Requirements

OCRAnno was developed using the open-source PHP web framework, Laravel 7.0. The requirements are basically the same as the framework, found in the [documentation (version 7.x)](https://laravel.com/docs/7.x) . Laravel has support to different databases, the chosen one was [MySQL](https://www.mysql.com/).

To run the project you will need to have installed [Composer](https://getcomposer.org/).

## How to run the project

After cloning the project, inside the project folder, create the file `.env`, by copying and renaming the `.env.exemple` file. This file has the basic settings  for Laravel. If necessary, you will  need to configure the database connection, default admin user and mail settings (to recover user's password).

Before running the commands, you have to create the MySQL database named `ocranno`, the same `DB_DATABASE` informed in `.env` file.

Finally, you can run the following commands:

```
$ composer install
$ php artisan migrate
$ php artisan key:generate
$ php artisan serve
```
The last command will generate a locally URL to access the system into the browser.

If you have some doubts or problems to run, maybe this [link](https://gist.github.com/hootlex/da59b91c628a6688ceb1) can help.

------

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects:

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 1500 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
