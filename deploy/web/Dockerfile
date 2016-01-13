#############################################
#       Teddy Online Judge - Web Application
#############################################
FROM ubuntu:14.04
MAINTAINER Alan Gonzalez<alanboy@alanboy.net>

ENV DEBIAN_FRONTEND=noninteractive

# Get some security updates
RUN apt-get update
RUN apt-get -y upgrade

# Install nginx, php5, mysql driver and supervisor
RUN apt-get -y install nginx
RUN apt-get -y install php5-fpm
RUN apt-get -y install php5-mysql
RUN apt-get -y install supervisor
RUN apt-get -y install git
RUN apt-get -y install mysql-server mysql-client
RUN apt-get -y install vim
RUN apt-get -y install curl
RUN apt-get -y install php5
RUN apt-get -y install php5-cli
RUN apt-get -y install php-pear php5-mcrypt
RUN pear install Mail-1.2.0

# Add config files
RUN rm /etc/nginx/sites-available/default
ADD conf/nginx.conf /etc/nginx/nginx.conf
ADD conf/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
ADD conf/php-fpm.conf /etc/php5/fpm/php-fpm.conf
ADD conf/sites-available /etc/nginx/sites-available/
ADD conf/my.cnf /etc/mysql/
RUN ln -s /etc/nginx/sites-available/teddy /etc/nginx/sites-enabled/teddy

# Install compose requirements
RUN mkdir --parents /opt/teddy/container
ADD conf/composer.json /opt/teddy/container
RUN cd /opt/teddy/container/
RUN curl -sS https://getcomposer.org/installer | php
RUN php composer.phar install --working-dir /opt/teddy/container/

# Teddy configuration
RUN echo "<?php \$TEDDY_DB_USER = \"root\";" >> /opt/teddy/container/config.php \
    && echo "\$TEDDY_DB_SERVER = \"localhost\";" >> /opt/teddy/container/config.php \
    && echo "\$TEDDY_DB_PASS = \"\";" >> /opt/teddy/container/config.php \
    && echo "\$TEDDY_DB_NAME = \"teddy\";" >> /opt/teddy/container/config.php \
    && echo "\$TEDDY_LOG = \"/var/log/teddy/teddy.log\";" >> /opt/teddy/container/config.php \
    && echo "\$TEDDY_CODIGOS_PATH = \"/usr/teddy/codigos\";" >> /opt/teddy/container/config.php 

# Setup database
ADD bd.sql /opt/teddy/container
RUN echo "mysqld_safe &" > /tmp/config \
    && echo "mysqladmin --silent --wait=30 ping || exit 1" >> /tmp/config \
    && echo "mysql -e 'GRANT ALL PRIVILEGES ON *.* TO \"root\"@\"%\" WITH GRANT OPTION;'" >> /tmp/config \
    && echo "mysql -e 'create database teddy;'" >> /tmp/config \
    && echo "mysql --database teddy < /opt/teddy/container/bd.sql" >> /tmp/config \
    && bash /tmp/config \
    && rm -f /tmp/config

# Define mountable directories
VOLUME ["/etc/nginx/sites-enabled", "/etc/nginx/sites-available", "/var/log/nginx"]

# Expose http & https
EXPOSE 80
EXPOSE 443

CMD ["/usr/bin/supervisord"]

# Need to run this at the end (runtime)
#RUN cd /opt/teddy/trunk; git submodule init
#RUN cd /opt/teddy/trunk; git submodule update

