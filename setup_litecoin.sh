#!/bin/bash
# init

diretorio_atual=$(pwd);
appname=litecoin_service;
appdesc='Litecore lTC service';
diretorio_destino=/opt/$appname;

clear
echo "_________________________ INSTALL LITECOIN SERVICE ____________________________"
echo "Application name: $appname"
echo "DIRETORIO ATUAL: $diretorio_atual"
echo "INSTALAR EM: $diretorio_destino" 
sleep 2
mkdir $diretorio_destino
cp -r $diretorio_atual/'nodejs_apps' $diretorio_destino
sudo chmod -R 755 $diretorio_destino

#___________create service
echo "
[Unit]
Description=Litecore LTC service

[Service]
ExecStart=/usr/bin/node /opt/litecoin_service/nodejs_apps/rest/service.js

[Install]
WantedBy=multi-user.target
" > $diretorio_destino/$appname.service





sudo cp -r $diretorio_destino/$appname.service /etc/systemd/system/$appname.service
sudo chmod 644 /etc/systemd/system/$appname.service

echo "OK"


sleep 1

sudo systemctl start $appname
sleep 2



