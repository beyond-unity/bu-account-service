FROM bobbydvo/packer-lemp-dev:latest
MAINTAINER me@bobbyjason.co.uk

RUN echo '' >> /etc/php-fpm.d/www.conf
RUN echo 'env[AWS_ENVIRONMENT]  = $AWS_ENVIRONMENT' >> /etc/php-fpm.d/www.conf

# Copy the code onto the container
COPY . /srv
WORKDIR "/srv"
RUN composer install

# http, https, mongo, redis
EXPOSE 80 443 3306 6379

CMD ["/usr/bin/supervisord","-n","-c","/etc/supervisord.conf"]