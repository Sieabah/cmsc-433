# CMSC 433 - Project 1

## Contributers
- Christopher Sidell

## Requirements
- A PHP 5 or higher installation.
- A MariaDB or MySQL installation.

## How to start
Before anything you will need to setup the database and change the relevant information in config.php.

After doing that you *must* run the migrations.

### Migrations
To run migrations run

    php migration.php

Optionally if you would like to migrate and seed see below

### Seeding the Database
To run migration and seeders

    php migration.php seed

**Note**: This runs all of the migrations as well as seed