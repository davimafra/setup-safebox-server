#!/bin/bash
# init
clear
echo 
echo "_________________________ MYSQL INSTALL ____________________________"
echo

sudo apt-get update -y
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password password admin'
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password admin'
sudo apt-get install -y mysql-server mysql-client
echo "_________________________ MYSQL INSTALL OK____________________________"


#systemctl status mysql.service
#gnome-terminal -- /bin/sh -c 'systemctl status mysql.service; sleep 3;exec bash'

# to remove: sudo apt-get remove --purge mysql*
#sudo apt-get --purge remove mysql-server mysql-common mysql-client.
