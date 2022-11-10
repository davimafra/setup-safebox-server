#!/bin/bash
# init
clear
echo 
echo "_________________________ NODE INSTALL ____________________________"
echo

diretorio=$(pwd);
nome=node;
nome2=npm;
echo "install node v6.0"
echo -n "Check if $nome is installed."
if which $nome >/dev/null;
then echo
     echo "$nome Already Installed"
else echo
     echo "$nome Not Installed!"     
     curl -sL https://deb.nodesource.com/setup_6.x | sudo -E bash -
     sudo apt-get install nodejs -y
fi

echo "install npm"
echo -n "Check if $nome2 is installed."
if which $nome2 >/dev/null;
then echo
     echo "$nome2 Already Installed"
else echo
     echo "$nome2 Not Installed!"     
     sudo apt-get install npm -y
fi


sudo nvm install 6.0.0
sudo nvm use 6.0
sleep 1


sleep 1
