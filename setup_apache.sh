#!/bin/bash
# init
clear
echo 
echo "_________________________ APACHE INSTALL ____________________________"
echo
function pause(){
   read -p "$*"
} 
# ...
# call it
#pause 'Press [Enter] key to continue...'
sudo dpkg --configure -a
sudo apt install apache2 -y
sudo ufw allow 'Apache Full'

#gnome-terminal -- /bin/sh -c 'x-www-browser http:\\localhost --no-sandbox; sleep 30'
sleep 1
sudo systemctl start apache2
sleep 1




# to remove: sudo apt-get remove --purge apache2 -y
