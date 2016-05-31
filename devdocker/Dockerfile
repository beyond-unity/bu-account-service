## In Lieu of seperate Dev DB Container

FROM bobbydvo/quint-api-dev:latest

MAINTAINER me@bobbyjason.co.uk

RUN echo 'env[AWS_ENVIRONMENT]       = dev' >> /etc/php-fpm.d/www.conf

# MariaDB
RUN yum -y install mariadb
RUN yum -y install mariadb-server

COPY mariadb.sh /
RUN chmod 777 mariadb.sh
RUN /mariadb.sh devdb devuser devpass

WORKDIR "/srv"

RUN chown -R apache:apache .

ADD ./mongodb-org-3.2.repo /etc/yum.repos.d/mongodb-org-3.2.repo

RUN yum install -y php-pear
RUN yum install -y mongodb-org
RUN yum install -y openssl-devel

RUN pecl install mongodb
RUN echo "extension=mongodb.so" >> `php --ini | grep "Loaded Configuration" | sed -e "s|.*:\s*||"`

RUN mkdir -p /data/db

RUN mongod --fork --logpath /var/log/mongodb.log

EXPOSE 80 443 3306 6379 27017

CMD ["/usr/bin/supervisord","-n","-c","/etc/supervisord.conf"]