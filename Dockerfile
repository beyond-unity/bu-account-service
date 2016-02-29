FROM bobbydvo/centos-php7

MAINTAINER bobby@dvomedia.net

ADD ./config/docker/development/default.conf /etc/nginx/conf.d/default.conf
ADD ./config/docker/development/10-opcache.ini /etc/php.d/10-opcache.ini
ADD ./config/docker/development/php.ini /etc/php.ini
ADD ./config/docker/development/nginx.conf /etc/nginx/nginx.conf
ADD ./config/docker/development/gzip.conf /etc/nginx/conf.d/gzip.conf

EXPOSE 80 443 8080