# Wostock

Wostock is a web-based inventory and order management system built with Laravel.

It helps businesses manage their products, categories, suppliers, clients, and orders from a centralized dashboard.

## Core Features

* Product management
* Category management
* Supplier management
* Client management
* Order management
* Inventory management
* Stock tracking
* Order status management
* Dashboard and basic reporting
* User authentication

## Technology

* Laravel
* PHP
* MySQL
* Blade
* JavaScript
* HTML / CSS

## Main Relationships

```text
Client    1 → many    Orders

Order     1 → many    OrderItems

Product   1 → many    OrderItems

Category  1 → many    Products

Supplier  1 → many    Products
```

## Project Purpose

Wostock is designed to simplify daily inventory operations by connecting products, stock, suppliers, clients, and orders in one application.

The system is built with Laravel's MVC architecture and Eloquent ORM to provide a structured and maintainable codebase.
