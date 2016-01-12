rm file.list

# find java src files
find src -name \*.java -print > file.list

# compile
javac -d bin -cp src:lib/log4j-1.2.17.jar:lib/mysql-connector-java-5.0.5-bin.jar @file.list || exit -1;

rm file.list

# create manifest file
echo "Main-Class: mx.itc.teddy.Teddy
Class-Path: ../lib/log4j-1.2.17.jar ../lib/mysql-connector-java-5.0.5-bin.jar" > manifest


# create the jar
cd bin
jar cfm teddy.jar ../manifest mx

cd ..

# cleanup
rm manifest
rm -rf bin/mx

echo OK
