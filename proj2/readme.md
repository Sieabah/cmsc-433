# CMSC 433 - Project 2

## Contributers
- Christopher Sidell
- Joshua Standiford

## Requirements
- A PHP 5.6 or higher installation.
- A MariaDB or MySQL installation.
- Vagrant (Optional)

## Required Linux Packages
- mysql-server
- curl
- apache2
- php5
- php-pear
- php5-mysql
- php5-curl

## How to start
Before anything you will need to setup the database and change the relevant information in config.php.

**This includes before running any vagrant commands**

## Vagrant

[Vagrant](https://www.vagrantup.com/) allows to share and deliver development environments easily. Underneath the hood
it uses [VirtualBox](https://www.virtualbox.org/) so please have both of these installed for the easiest setup. To connect
to the machine it will be at the IP of 192.168.33.8, you can either setup a host in your hosts file or not.

For the simplest setup run *vagrant up* and wait for it to finish and visit 192.168.33.8. The site should be available.

Vagrant will setup synced folders for */config*, */proj1/* and */proj2*.

For vagrant to completely work the plugin for updating hosts must be installed by running

    vagrant plugin install vagrant-hostsupdater

Vagrant will have problems editing the hosts file if you do not have the correct permissions. Give your user account access
to edit the hosts file for your operating system before running *vagrant up*.

### Setup Mysql

If you want exacts as to how to setup the entire system we will start with MySQL. This guide assumes you
already have root access to the DB, if you don't have root access please get it.

After going through the install and setting up your root password run these few commands as root on mysql

    CREATE USER 'devdb'@'localhost' IDENTIFIED BY 'devdb'
    CREATE DATABASE devdb
    GRANT ALL ON devdb.* TO 'devdb'@'localhost'

Either change in config.php where db.dev is or add this to your */etc/hosts* file

    127.0.0.1 db.dev

### Setup Apache

Setting up apache is rather easy. Firsly you need to enable the rewrite module as this project uses it

    sudo a2enmod rewrite

Then after that you can change the *000-default.conf* website or add your own and enable it. Google it. Here is the default
configuration that is provided when you run vagrant up.

    # APACHE VIRTUAL HOST CONFIGURATION

    <VirtualHost _default_:80>
            ServerName cmsc433.dev

            ServerAdmin webmaster@localhost
            DocumentRoot /srv/proj2

            <Directory /srv/proj2>
                    Require all granted
                    AllowOverride all
            </Directory>

            ErrorLog ${APACHE_LOG_DIR}/error.log
            CustomLog ${APACHE_LOG_DIR}/access.log combined
    </VirtualHost>

### Setup Files

Simply put the files into a folder on the webserver. I will not go into setting up permissions, use my vagrant setup
if you want to get up and running.

##### After doing that you *must* run the migrations.

### Migrations
To run migrations and seeders run the following command from the project root.

    php database/populate.php

Optionally if you would like to migrate and seed see below

## Adding or Removing classes

For ease of use and simplicity you can modify the classes.json file in the resources
folder and rerun the seeder to push all your changes to the DB. You can alternatively
modify the classes directly from the database.

To reflect the changes in the file you must reseed the database, there is no way around this.

# Directory Structure

- classes: All of the classes that are used in the framework exist in this folder
- config: Configuration files for the framework exist in this folder
- database: All database related files exist in this folder
- public: The public facing directory that users hit
- resources: File resources
- - views: The views that are displayed to the end user

## Framework mentality

The framework is setup to be built around the MVC architecture. You can read more about it [here](https://en.wikipedia.org/wiki/Model%E2%80%93view%E2%80%93controller).