# Vagrant setup

sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password password devdb'
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password devdb'
sudo apt-get install -y mysql-server curl
sudo apt-get install -y apache2 php5 php-pear php5-mysql php5-curl

sudo a2enmod rewrite