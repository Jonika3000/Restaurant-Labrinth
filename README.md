# Symfony/Twig Web Application Restaurant

Web application for a restaurant that allows you to manage the menu, place orders, reserve tables, and manage events. Used for styling Tailwind CSS, has responsive design.
Has 6 public pages and an admin panel. Localization is also present.

* Home
* Menu
* Events
* Reservation
* Cart
* Profile

## Technology Stack

* Symfony
* Twig
* Tailwind CSS
* Easy Admin
* JS
* PostgreSQL

## Prerequisites

* PHP (version 7.2.5 or higher)
* Composer (Dependency Manager for PHP)
* A web server
* PostgreSQL or another supported database
* Symfony CLI (optional, but recommended)
* Use symfony check:requirements

## Getting Started

```
git clone https://github.com/Jonika3000/Restaurant-Labrinth.git
```
```
cd Restaurant-Labrinth
```
```
composer install
```
```
in env set yours database and mailer settings
```
```
symfony console doctrine:migrations:migrate
```
```
symfony server:start
```
