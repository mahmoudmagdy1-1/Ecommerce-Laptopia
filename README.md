# E-Commerce Platform

A custom PHP e-commerce platform built from scratch with a Laravel-like architecture. This project includes a custom router, MVC pattern, database layer, and authentication system without relying on external frameworks or libraries.


## Features

- User authentication (customer and admin roles)
- Shopping cart functionality
- Order management
- Admin dashboard
- User management
- Product management
- Category management
- Order processing

## Usage

### Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher

### Installation

1. Clone the repo into your document root (www, htdocs, etc)
2. Create a database called `ecomm`
3. Import the `db.sql` file into your database
4. Update the environment file with your database credentials at `config/_db.php`
5. Run the command `composer install` to set up the autoloading
6. Set your document root to the `public` directory

### Setting the Document Root

You will need to set your document root to the `public` directory. Here are some instructions for setting the document root for some popular local development tools:

##### PHP built-in server

If you are using the PHP built-in server, you can run the following command from the project root:

`php -S localhost:8000 -t public`

##### XAMPP

If you are using XAMPP, you can set the document root in the `httpd.conf` file. Here is an example:

```conf
DocumentRoot "C:/xampp/htdocs/ecomm/public"
<Directory "C:/xampp/htdocs/ecomm/public">
```

##### MAMP

If you are using MAMP, you can set the document root in the `httpd.conf` file. Here is an example:

```conf
DocumentRoot "/Applications/MAMP/htdocs/ecomm/public"
<Directory "/Applications/MAMP/htdocs/ecomm/public">
```

## Project Structure and Notes

#### Custom Router

Creating a route in `routes.php` looks like this:

`$router->get('/products', 'ProductController@index');`

This would load the `index` method in the `App/controllers/ProductController.php` file.

#### Authorization Middleware

You can pass in middleware for authorization. This is an array of roles. For example:

- For admin-only routes:
  `$router->get('/admin/dashboard', 'AdminController@dashboard', ['admin']);`

- For customer-only routes:
  `$router->get('/checkout', 'OrderController@checkout', ['customer']);`

- For guest-only routes (non-logged in users):
  `$router->get('/login', 'UserController@login', ['guest']);`

- For routes accessible by multiple roles:
  `$router->get('/cart', 'CartController@index', ['customer', 'guest']);`

#### Public Directory

This project has a public directory that contains all of the assets like CSS, JS and images. This is where the `index.php` file is located, which is the entry point for the application.

You will need to set your document root to the `public` directory.

#### Core Directory

All of the core files for this project are in the `core` directory. This includes the following files:

- **Database.php** - Database connection and query methods (PDO)
- **Router.php** - Router logic
- **Session.php** - Session management
- **Validation.php** - Form validation
- **Authorize.php** - Authorization logic
- **Flash.php** - Flash message handling

#### PSR-4 Autoloading

This project uses PSR-4 autoloading. All of the classes are loaded in the `composer.json` file:

```json
{
  "autoload": {
    "psr-4": {
      "\\Core\\": "core/",
      "\\App\\": "app/"
    }
  }
}
```

#### Namespaces

This project uses namespaces for all of the classes. Here are the namespaces used:

- **Core** - All of the core framework classes
- **App\Controllers** - All of the controllers
- **App\Models** - All of the models

#### App Directory

The `App` directory contains all of the main application files like controllers, models, and views. Here is the directory structure:

- **controllers/** - Contains all of the controllers
- **models/** - Contains all of the models
- **views/** - Contains all of the views
- **views/partials/** - Contains all of the partial views
- **views/admin/** - Contains all of the admin views

#### Other Files

- **/routes.php** - Contains all of the routes
- **/helpers.php** - Contains helper functions
- **/config/db.php** - Contains the database configuration
- **composer.json** - Contains the composer dependencies
- **db.sql** - Contains the database schema