#!/bin/bash


#APPCHK = $(ps aux | grep  -c "java -jar teddy.jar")

if [ $(ps aux | grep  -c "java -jar teddy.jar") = '1' ];
then
	echo  "Teddy is not running " 
	cd /opt/teddy/teddy-online-judge/teddy.itc.mx/bin
	java -jar teddy.jar >> log &  
	echo "Teddy is running now "
else
	echo "OK"
fi

exit
