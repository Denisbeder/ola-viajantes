FROM hhvm/hhvm:latest

RUN mkdir -p /var/www

COPY server.ini /etc/hhvm/server.ini

RUN usermod -u 1000 www-data

WORKDIR /var/www

#CMD ["/usr/bin/hhvm", "--user", "www-data", "-m", "server", "-c", "/etc/hhvm/server.ini"]
CMD ["/usr/bin/hhvm", "--user", "www-data", "-m", "server", "-d", "hhvm.server.type=fastcgi", "-d", "hhvm.server.port=9000"]

EXPOSE 9000
