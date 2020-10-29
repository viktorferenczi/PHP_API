# TESTAPI

REST API with Create,Read,Update functions. 
Using HTTP request methods GET,POST,PUT handled with Front Controller Design Pattern.

### Tech

TESTAPI uses a number of technics to work properly:

* [PHP] - Especially suited to web development!
* [PhpStorm] - awesome php-based text editor
* [MySQL] - Fully managed database service
* [phpMyAdmin] - Handle the administration of MySQL
* [Github] - Version control
* [Composer] - Application-level package manager 
* [Postman] - Backend developer's favorite frontend
* [MAMP] - Web server solution stack package, XAMPP for Mac users.


### Installation

TESTAPI requires:
* PHP Version: 7.4.2
* MySQL database
* Composer

Steps:
* Install MAMP - XAMPP or launch your Apache and MySQL server.
* Generate the MySQL Database and table with the help of "sqlDump.sql" file.
* Rename the ".env.example" file to ".env"
* ".env" file should look like this in case if you are using MAMP:
    * DB_HOST=127.0.0.1 (localhost)
    * DB_PORT=8889 (MAMP uses this port as a default value, it might be diff in your case)
    * DB_DATABASE=Delocal (given by the sql dump)
    * DB_USERNAME=root (MAMP uses this username as a default value, it might be diff in your case)
    * DB_PASSWORD=root (MAMP uses this password as a default value, it might be diff in your case)

Dependencies:
* [PHP dotenv] -  Loads environment variables from .env
* [PSR-4] - Autoloader  -  Autoloading classes from file paths

Install the dependencies and start the server:

```sh
$ cd TESTAPI
$ composer install
$ php -S 127.0.0.1:8000 -t public
```
### Routes



| Method | Route | Description |
| ------ | ------ | -------- |
| GET | /contacts | Get all the contacts
| GET | /contacts/id | Get a single contact based on ID
| POST | /contacts | Create a contact
| PUT | /contacts/id | Update a contact based on ID

License
----

MIT


**Free to share, use, edit!**

   [PHP]: <https://www.php.net/>
   [PhpStorm]: <https://www.jetbrains.com/phpstorm/>
   [MySQL]: <https://www.mysql.com/>
   [phpMyAdmin]: <https://www.phpmyadmin.net/>
   [Github]: <https://github.com/>
   [Composer]: <https://getcomposer.org/doc/00-intro.md>
   [MAMP]: <https://www.mamp.info/en/mac/>
   [PHP dotenv]: <https://github.com/vlucas/phpdotenv#php-dotenv>
   [PSR-4]: <https://www.php-fig.org/psr/psr-4/>
[Postman]: <https://www.postman.com/>
