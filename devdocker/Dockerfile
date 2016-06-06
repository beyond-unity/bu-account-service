## In Lieu of seperate Dev DB Container

FROM bobbydvo/packer-lemp-dev:latest

MAINTAINER me@bobbyjason.co.uk

EXPOSE 80 443 3306 6379 27017

CMD ["/usr/bin/supervisord","-n","-c","/etc/supervisord.conf"]