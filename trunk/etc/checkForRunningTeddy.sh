#!/bin/bash


#APPCHK = $(ps aux | grep  -c "java -jar teddy.jar")

if [ $(ps aux | grep  -c "java -jar teddy.jar") = '1' ];
then
	cd /opt/teddy-online-judge/trunk/bin/
	java -jar teddy.jar >> log &  
else
	echo "OK"
fi

exit
