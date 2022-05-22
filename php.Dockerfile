FROM php:7.4.3-apache
RUN apt-get -y update \
&& apt-get install -y \
	 	git zip unzip \
&& pecl install xdebug
COPY --from=composer /usr/bin/composer /usr/bin/composer

CMD apachectl -D FOREGROUND