#!/bin/bash
# init

diretorio_atual=$(pwd);
appname=bitcoin_service;
appdesc='Blockchain BTC service';
diretorio_destino=/opt/$appname;

clear
echo "_________________________ BITCOIN SERVICE INSTALL ____________________________"
echo "Application name: $appname"
echo "DIRETORIO ATUAL: $diretorio_atual"
echo "INSTALAR EM: $diretorio_destino" 


pre1=npm;

if $pre1 -v >/dev/null 2>&1; then
    echo "$pre1 OK"
else
    echo "$pre1 not installed "
    pause 'Press [Enter] key to continue...'
    exit
fi

clear
sleep 1

if sudo npm install -g blockchain-wallet-service; then    
    echo "Service Successfully installed"
else
    echo "Error installing Service"
    pause 'Press [Enter] key to continue...'
    exit	
fi

sudo npm update -g blockchain-wallet-service

mkdir $diretorio_destino
#___________create sh 
echo "
#!/bin/bash
blockchain-wallet-service start
" > $diretorio_destino/$appname.sh

sudo chmod +x $diretorio_destino/$appname.sh



#___________create service
echo "
[Unit]
Description=$appdesc

[Service]
Type=simple
ExecStart=/bin/bash $diretorio_destino/$appname.sh

[Install]
WantedBy=multi-user.target
" > $diretorio_destino/$appname.service

sudo cp -r $diretorio_destino/$appname.service /etc/systemd/system/$appname.service
sudo chmod 644 /etc/systemd/system/$appname.service

echo "OK"



sudo systemctl start $appname
#gnome-terminal -- /bin/sh -c "systemctl status $appname; sleep 3;exec bash"


sleep 1


echo "done"

