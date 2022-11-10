#!/bin/bash
# init
#progress bar______________________________________________________
prog() {
    local w=80 p=$1;  shift
    # create a string of spaces, then change them to dots
    printf -v dots "%*s" "$(( $p*$w/100 ))" ""; dots=${dots// /_};
    # print those dots on a fixed-width space plus the percentage etc. 
    printf "\r\e[K|%-*s| %3d %% %s" "$w" "$dots" "$p" "$*"; 
}
#____________________________________________________________________
function pause(){
   read -p "$*"
} 
#__________________________setup config_____________________
user=davimafra;
password=102030;

#__________________________________________________________
echo
dbus-update-activation-environment --systemd --all
gnome-terminal &
clear
x=1
prog "$x" setup mysql...
gnome-terminal --disable-factory -- /bin/sh -c "./setup_mysql.sh; sleep 3;exit"

clear
x=5
prog "$x" import database...
sleep 2
gnome-terminal -- /bin/sh -c "./import_database.sh; sleep 3;exit"
sleep 2
clear
x=10
prog "$x" setup apache...
sleep 2
gnome-terminal --disable-factory -- /bin/sh -c "./setup_apache.sh; sleep 3;exit"
sleep 2


clear
x=15
prog "$x" setup php...
sleep 2
gnome-terminal --disable-factory -- /bin/sh -c "./setup_php.sh; sleep 3;exit"


clear
x=25
prog "$x" PACK MYQL+APACHE+PHP VERIFICATION...
echo
sleep 2
#_______________________________________mysql verification___________________
nome=mysql;
echo -n "Check if $nome is installed."
if which $nome >/dev/null;
then echo
     echo "$nome Installed"  
     gnome-terminal -- /bin/sh -c 'systemctl status mysql.service; sleep 3;exec bash'
	sleep 2   
else echo
     echo "$nome Not Installed!"     
     pause 'Proceed with instalation? Press [Enter] key to continue...'
fi
#____________________________________________________________________________
#_______________________________________apache verification___________________
nome=apache2;
echo -n "Check if $nome is installed."
if which $nome >/dev/null;
then echo
     echo "$nome Installed"
     gnome-terminal -- /bin/bash -c "echo $password | su $user xdg-open http://localhost; sleep 3"
     #gnome-terminal -- /bin/sh -c 'systemctl status apache2; sleep 3;exec bash'
	sleep 2     
else echo
     echo "$nome Not Installed!"     
     pause 'Proceed with instalation? Press [Enter] key to continue...'
fi
#____________________________________________________________________________
#_______________________________________php verification___________________
nome=php;
echo -n "Check if $nome is installed."
if which $nome >/dev/null;
then echo
     echo "$nome Installed" 
     gnome-terminal -- /bin/bash -c "echo $password | su $user xdg-open http://localhost/info.php;" 
	sleep 2   
else echo
     echo "$nome Not Installed!"     
     pause 'Proceed with instalation? Press [Enter] key to continue...'
fi
#____________________________________________________________________________

clear
x=27
prog "$x" setup website...
sleep 2
gnome-terminal --disable-factory -- /bin/sh -c "./setup_web.sh; sleep 3;exit"
sleep 1
gnome-terminal -- /bin/bash -c "echo $password | su $user xdg-open http://safebox/; sleep 3"

clear
x=50
prog "$x" setup node...
sleep 2
gnome-terminal --disable-factory -- /bin/sh -c "./setup_pre_node.sh; sleep 3;exit"

#_______________________________________node verification___________________
nome=npm;
echo -n "Check if $nome is installed."
if which $nome >/dev/null;
then echo
     echo "$nome Installed"
     node -v  
     npm -v
     sleep 2   
else echo
     echo "$nome Not Installed!"     
     pause 'Cannot proceed with instalation Press [Enter] key to continue...'
	exit
fi
#____________________________________________________________________________


clear
x=60
prog "$x" setup bitcoin...
sleep 2
gnome-terminal --disable-factory -- /bin/sh -c "./setup_bitcoin_service.sh; sleep 3;exit"
sleep 1
#gnome-terminal -- /bin/sh -c "systemctl status bitcoin_service; sleep 3;exec bash"

clear
x=65
prog "$x" setup litecoin...
sleep 2
echo
	
gnome-terminal --disable-factory -- /bin/sh -c "./setup_litecoin.sh; sleep 3;exit"
sleep 1
#gnome-terminal -- /bin/sh -c "systemctl status litecoin_service; sleep 3;exec bash"


#_______________________________________blockchain services verification___________________
clear
x=69
prog "$x" checking blockchain services...
sleep 2
echo
echo -n "Check if bitcoin is running..."
echo
if lsof -Pi :3000 -sTCP:LISTEN -t >/dev/null ; then
	echo
    echo "bitcoin running at port 3000..."
	sleep 2
else
	echo
    echo "WARNING: bitcoin not running!!!"
	pause 'Proceed with instalation Press [Enter] key to continue...'	
fi
echo
echo -n "Check if litecoin is running..."
echo
if lsof -Pi :3005 -sTCP:LISTEN -t >/dev/null ; then
	echo
    echo "litecoin running at port 3005..."
	sleep 2
else
	echo
    echo "WARNING: litecoin not running!!!"
	pause 'Proceed with instalation Press [Enter] key to continue...'	
fi


#__________________________________________________________________________________________
clear
x=70
prog "$x" setup crontab...
sleep 2
gnome-terminal -- /bin/sh -c "./setup_crontab.sh; sleep 3;exec bash"


clear
x=75
prog "$x" setup devtools...
sleep 2
#gnome-terminal --disable-factory -- /bin/sh -c "./setup_devtools.sh; sleep 3;exit"

sleep 5

clear
x=100
prog "$x" finishing...
sleep 2

sudo apt autoremove -y

clear
echo 
echo "»»»»»»»»»»»»»»»»»»»»»»»»»»» S A F E B O X  D O N E ! «««««««««««««««««««««««««««««"
echo
mysql -V
echo
php -v
echo
node -v
echo
npm -v
echo
echo "litecoin running at port 3005..."
echo
echo "bitcoin running at port 3000..."
sleep 2


