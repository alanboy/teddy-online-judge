#############################################
#       Teddy Online Judge - Runner
#############################################
FROM ubuntu:15.10
MAINTAINER Alan Gonzalez<alanboy@alanboy.net>

ENV DEBIAN_FRONTEND=noninteractive

# Get some security updates
RUN apt-get update
RUN apt-get -y upgrade

RUN apt-get -y install supervisor
RUN apt-get -y install git
RUN apt-get -y install mysql-server mysql-client
RUN apt-get -y install curl

RUN apt-get -y install vim

RUN mkdir --parents /opt/teddy/runner
RUN mkdir --parents /var/tmp/teddy/work_zone

RUN echo "\$TEDDY_DB_USER = \"root\";" >> /opt/teddy/runner/config.php
RUN echo "\$TEDDY_DB_SERVER = \"web\";" >> /opt/teddy/runner/config.php
RUN echo "\$TEDDY_DB_NAME = \"teddy\";" >> /opt/teddy/runner/config.php
RUN echo "\$TEDDY_DB_PASSWORD= \"\";" >> /opt/teddy/runner/config.php

# Add config files
ADD conf/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Install compilers and interpreters
RUN apt-get -y install openjdk-8-jdk
RUN apt-get -y install php5 php5-cli

CMD ["/usr/bin/supervisord"]

