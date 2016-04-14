# CMSC 433 - Project 1

## Contributers
- Christopher Sidell
- Michael Leung

## Requirements
- A PHP 5.6 or higher installation.
- A MariaDB or MySQL installation.
- Vagrant (Optional)

## How to start
Before anything you will need to setup the database and change the relevant information in config.php.

**This includes before running any vagrant commands**

## Vagrant

[Vagrant](https://www.vagrantup.com/) allows to share and deliver development environments easily. Underneath the hood
it uses [VirtualBox](https://www.virtualbox.org/) so please have both of these installed for the easiest setup. To connect
to the machine it will be at the IP of 192.168.33.10, you can either setup a host in your hosts file or not.

### Setup Mysql user
This guide assumes you already have root access to the DB, if you don't have root access please get it.

Give the user you created all privileges.

    GRANT ALL PRIVLEGES ON `cmsc433-proj1`.* TO 'devdb'@'localhost';

##### After doing that you *must* run the migrations.

### Migrations
To run migrations run

    php migration.php

Optionally if you would like to migrate and seed see below

### Seeding the Database
To run migration and seeders

    php migration.php seed

**Note**: This runs all of the migrations as well as seed

## Adding or Removing classes

For ease of use and simplicity you can modify the classes.json file in the resources
folder and rerun the seeder to push all your changes to the DB. You can alternatively
modify the classes directly from the database.

# Directory Structure

- classes: All of the classes that are used in the framework exist in this folder
- config: Configuration files for the framework exist in this folder
- database: All database related files exist in this folder
- - migrations: Database migrations that setup the database
- - seeders: Database seeders that fill the database with data
- public: The public facing directory that users hit
- resources: File resources
- - views: The views that are displayed to the end user

## Framework mentality

The framework is setup to be built around the MVC architecture. You can read more about it [here](https://en.wikipedia.org/wiki/Model%E2%80%93view%E2%80%93controller).