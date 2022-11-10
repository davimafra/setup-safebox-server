#!/bin/bash
# init
clear
echo 
echo "_________________________ PHP INSTALL ____________________________"
echo
function pause(){
   read -p "$*"
} 
# ...
# call it
#pause 'Press [Enter] key to continue...'
#_______________________________________apache verification___________________
nome=apache2;
echo -n "Check if $nome is installed."
if which $nome >/dev/null;
then echo
     echo "$nome Installed"     
else echo
     echo "$nome Not Installed!"     
     pause 'setup cannot continue! Press [Enter] key to continue...'
	exit
fi
#____________________________________________________________________________

apt-get install software-properties-common -y
add-apt-repository ppa:ondrej/php -y
apt-get update -y

clear
echo "Install PHP 7.4..."
sleep 1
apt-get update -y
apt-get install -y php7.4

clear
echo "Install Módulos..."
sleep 1
apt-get install -y php-pear php7.4-curl php7.4-dev php7.4-gd php7.4-mbstring php7.4-zip php7.4-mysql php7.4-xml
printf "yes\n" | pecl install -n apcu

clear
echo "Config php cache..."
sleep 1
echo "extension=apcu.so" | tee -a /etc/php/7.4/mods-available/cache.ini
ln -s /etc/php/7.4/mods-available/cache.ini /etc/php/7.4/apache2/conf.d/30-cache.ini
sudo apt install -y php-xdebug
clear
echo "restarting apache..."
sleep 1
systemctl restart apache2
sleep 5
#gnome-terminal -- /bin/sh -c 'systemctl status apache2; sleep 3'
echo "create php info..."
echo "<?php
phpinfo();
?>
" > /var/www/html/info.php
#gnome-terminal -- /bin/sh -c 'su davimafra xdg-open http://localhost/info.php; sleep 30'
sleep 1

echo "_________________________ PHP INSTALL OK____________________________"



# systemctl stop apache2
# to remove: sudo apt-get autoremove php7.4
