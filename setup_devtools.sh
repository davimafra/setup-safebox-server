#!/bin/bash
# init
clear
echo 
echo "_________________________ INSTALL DEVELOPMENT TOOLS ____________________________"
echo
function pause(){
   read -p "$*"
} 
# ...
# call it


sudo snap install -y --classic code

wget -c https://dbeaver.io/files/6.0.0/dbeaver-ce_6.0.0_amd64.deb
sudo dpkg -i dbeaver-ce_6.0.0_amd64.deb
sudo apt-get install -f -y


echo "done!"


