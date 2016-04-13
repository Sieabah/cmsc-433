# CMSC 433 - Project 1

## Contributers
- Christopher Sidell

## Requirements
- A PHP 5 or higher installation.
- A MariaDB or MySQL installation.

## How to start
Before anything you will need to setup the database and change the relevant information in config.php.

### Setup Mysql user
This guide assumes you already have root access to the DB, if you don't have root access please get it.

Give the user you created all privileges.

    GRANT ALL PRIVLEGES ON `cmsc433-proj1`.* TO 'devdb'@'localhost';


After doing that you *must* run the migrations.

### Migrations
To run migrations run

    php migration.php

Optionally if you would like to migrate and seed see below

### Seeding the Database
To run migration and seeders

    php migration.php seed

**Note**: This runs all of the migrations as well as seed