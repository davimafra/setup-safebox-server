#!/bin/bash
# init
clear
echo 
echo "_________________________ CRONTAB CONFIG ____________________________"
echo
function pause(){
   read -p "$*"
} 
# ...
# call it

#verify root
if [ `id -u` -ne 0 ]; then
      echo "This script can be executed only as root, Exiting.."
      exit 1
   fi


diretorio=$(pwd);
user=root;


CRON_FILE="/var/spool/cron/crontabs/$user"

	if [ ! -f $CRON_FILE ]; then
	   echo "cron file for $user doesnot exist, creating.."
	   touch $CRON_FILE
	   /usr/bin/crontab $CRON_FILE
	fi


#write out current crontab
crontab -l > mycron
#echo new cron into cron file
echo > mycron
#echo "* * * * * echo 'test cron job to execute every minute'">> mycron
echo "* * * * * /usr/bin/curl  http://safebox/excenbitservices/api/run_services_1m.php">> mycron
echo "*/5 * * * * /usr/bin/curl  http://safebox/excenbitservices/api/run_services_5m.php">> mycron
echo "*/10 * * * * /usr/bin/curl  http://safebox/excenbitservices/api/run_services_10m.php">> mycron
echo "*/15 * * * * /usr/bin/curl  http://safebox/excenbitservices/api/run_services_15m.php">> mycron
echo "*/30 * * * * /usr/bin/curl  http://safebox/excenbitservices/api/run_services_30m.php">> mycron
echo "0 * * * * /usr/bin/curl  http://safebox/excenbitservices/api/run_services_1h.php">> mycron
echo "0 4 * * * /usr/bin/curl  http://safebox/excenbitservices/api/run_services_daily.php">> mycron


#install new cron file
crontab mycron
rm mycron

sleep 1

cat /var/log/syslog | grep cron
