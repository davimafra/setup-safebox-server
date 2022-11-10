#!/bin/bash
# init
clear
echo 
echo "_________________________ IMPORT DATABASE ____________________________"
echo
function pause(){
   read -p "$*"
} 
#____________________________________________________________________
diretorio_atual=$(pwd);
databasename=exchange;
user=root;
password=admin;

mysql -u $user -p$password -e "create database $databasename"
sleep 1
mysql -u $user -p$password $databasename < exchange.sql

echo "_________________________ IMPORTED ____________________________"
