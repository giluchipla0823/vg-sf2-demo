#!/usr/bin/env bash

# Updating packages
Update () {
    echo "-- Update packages --"
    sudo apt-get update
    sudo apt-get upgrade
}
Update

# ---------------------------------------
#          Apache Setup
# ---------------------------------------

# Installing Packages
apt-get install -y apache2 

Update

# ---------------------------------------
#         PPA SETUP
# ---------------------------------------
sudo apt-get install -y python-software-properties
sudo add-apt-repository -y ppa:ondrej/php

Update


# ---------------------------------------
#          Setup PHP
# ---------------------------------------
sudo apt-get install -y php5.6
sudo apt-get install -y php5.6-fpm php5.6-curl php5.6-gd php5.6-mcrypt php5.6-mbstring php5.6-opcache php5.6-cli libapache2-mod-php5.6 php5.6-json php5.6-common
sudo apt-get install -y php5.6-gd php5.6-intl php5.6-xsl php5.6-xml php5.6-zip

cat >> /etc/apache2/apache2.conf << EOF
ServerName localhost
EOF


# cat >> /etc/apache2/sites-enabled/000-default.conf << EOF
# <VirtualHost *:80>
#     ServerName sf2-demo.test
#     DocumentRoot "/var/www/html/core"
#     <Directory "/var/www/html/core">
#         Options Indexes FollowSymLinks
#         AllowOverride All
#         Order allow,deny
#         Allow from all
#     </Directory>
# </VirtualHost>
# EOF

# Setup hosts file
# echo "${VHOST}" > /etc/apache2/sites-enabled/000-default.conf

# user www-data
usermod -G33 vagrant
usermod -Gvagrant www-data

# sudo service apache2 restart

# Modify AllowOverride
sed -i 's/DocumentRoot \/var\/www\/html/DocumentRoot \/var\/www\/html\n\t<Directory \/var\/www\/html>\n\t\tOptions Indexes FollowSymLinks\n\t\tAllowOverride All\n\t\tRequire all granted\n\t<\/Directory>\n/' /etc/apache2/sites-available/000-default.conf

# Loading needed modules to make apache work
sudo a2enmod rewrite
sudo service apache2 restart

Update

# Update


# ---------------------------------------
#          MySQL Setup
# ---------------------------------------

# Setting MySQL root user password root/root
echo "-- Prepare configuration for MySQL --"
sudo debconf-set-selections <<< "mysql-server mysql-server/root_password password root"
sudo debconf-set-selections <<< "mysql-server mysql-server/root_password_again password root"

# Installing packages
sudo apt-get install -y mysql-server mysql-client php5.6-mysql

## sudo nano /etc/mysql/mysql.conf.d/mysqld.cnf
sed -i 's/bind-address/# bind-address/' /etc/mysql/mysql.conf.d/mysqld.cnf 
sed -i 's/skip-external-locking/# skip-external-locking/' /etc/mysql/mysql.conf.d/mysqld.cnf 

sudo service mysql restart
sudo service apache2 restart

Update

# ---------------------------------------
#       Tools Setup.
# ---------------------------------------

# Installing GIT
sudo apt-get install -y git

Update

# Install Composer
curl -s https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
sudo chmod 777 /usr/local/bin/composer
# composer global require "fxp/composer-asset-plugin:*"
# composer install 

cd /var/www/html/core/
composer install

echo "-- Setup databases --"
mysql -uroot -proot -e "GRANT ALL PRIVILEGES ON *.* TO 'root'@'%' IDENTIFIED BY 'root' WITH GRANT OPTION; FLUSH PRIVILEGES;"
