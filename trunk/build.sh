#borrar old files si existen
rm file.list

#find java src files
find src -name \*.java -print > file.list

#compile those
javac -d bin -cp src:lib/log4j-1.2.17.jar:lib/mysql-connector-java-5.0.5-bin.jar @file.list || exit;

rm file.list

#create manifest file
echo "Main-Class: mx.itc.teddy.Teddy
Class-Path: ../lib/log4j-1.2.17.jar ../lib/mysql-connector-java-5.0.5-bin.jar" > manifest

cd bin

#create the jar
jar cfm teddy.jar ../manifest mx

cd ..

rm manifest
rm -rf bin/mx

#cd bin

#run main for testing...
#java -jar teddy.jar 
