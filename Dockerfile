FROM centos:7
MAINTAINER Adauto Jr <adautonet@gmail.com>

# Update repo for php 5.6
#RUN rpm -Uvh https://mirror.webtatic.com/yum/el7/epel-release.rpm

RUN yum -y install wget
RUN yum -y install git

RUN wget https://dl.fedoraproject.org/pub/epel/epel-release-latest-7.noarch.rpm

RUN wget http://rpms.remirepo.net/enterprise/remi-release-7.rpm

RUN rpm -Uvh remi-release-7.rpm

RUN yum-config-manager --enable remi-php70
RUN yum -y install unzip
RUN yum -y install php

RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer
RUN /usr/local/bin/composer create-project sge laravel/laravel /var/www/laravel --prefer-dist "5.4.*"

#install
WORKDIR /var/www/laravel/sge/public

VOLUME /home/fesc/sge:/var/www
COPY apache2.conf /etc/apache2/

#ports
EXPOSE 80
EXPOSE 443

ENTRYPOINT ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]