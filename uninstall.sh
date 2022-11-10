#!/bin/bash
# init
clear
echo 
echo "_________________________ SAFEBOX UNISTALL ____________________________"
echo
function pause(){
   read -p "$*"
} 
# ...
# call it
echo "DELETE ALL FOLDERS?"
pause 'Press [Enter] key to continue...'


systemctl stop mysql
systemctl stop apache2
systemctl stop bitcoin_service
systemctl stop litecoin_service

# to remove: sudo apt-get remove --purge mysql*

sudo apt-get --purge remove -y mysql-server mysql-common mysql-client
sudo apt-get autoremove -y php7.4
sudo apt-get purge -y 'php*'
sudo apt-get remove -y nodejs npm
sudo apt-get autoremove -y node
sudo apt-get purge -y apache2-data
sudo apt-get --purge remove -y apache2
sudo apt-get autoremove -y apache2
sudo apt-get autoremove -y nodejs
sudo apt-get autoremove -y npm

sudo rm -R /opt/litecoin_service
sudo rm -R /opt/bitcoin_service
sudo rm -R /var/www/html/safebox

sudo rm -rf ~/.nvm
sudo rm -rf ~/.npm
sudo rm -rf ~/.bower
sudo rm -rf $NVM_DIR ~/.npm ~/.bower

echo "_________________________ UNINSTALL OK____________________________"


