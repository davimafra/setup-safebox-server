#!/bin/bash
# init
function pause(){
   read -p "$*"
} 

diretorio_atual=$(pwd);
appname=safebox;
appdesc='safebox web service';
diretorio_destino=/var/www/html;

clear
echo "_________________________ INSTALL WEBSITE ____________________________"
echo "Application name: $appname"
echo "DIRETORIO ATUAL: $diretorio_atual"
echo "INSTALAR EM: $diretorio_destino" 


cp -r $diretorio_atual/'safebox' $diretorio_destino
sudo chmod -R 755 $diretorio_destino

cp -r $diretorio_atual/safebox.conf /etc/apache2/sites-available/


#___________append line in vhost 
echo "
127.0.0.1       safebox
" >> /etc/hosts


echo "config new sites"


sudo a2ensite safebox.conf
sudo systemctl restart apache2
sudo a2dissite 000-default.conf
sudo a2enmod rewrite
sudo systemctl restart apache2



apache2ctl -S



sleep 1



echo "done"


