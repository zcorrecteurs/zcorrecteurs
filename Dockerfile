# Première étape : dépendances Composer
FROM composer:1.7 as composer

WORKDIR /opt/app/

COPY lib ./lib
COPY app ./app
COPY composer.json composer.lock ./

RUN composer install \
    --ignore-platform-reqs \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist \
    --optimize-autoloader \
    --no-dev

# Dernière étape : création de l'image qui sera exécutée
FROM alpine:3.6

RUN apk update && \
  apk upgrade && \
  apk add \
	apache2 \
	bash \
	php7-apache2 \
	curl \
	ca-certificates \
	openssl \
	openssh \
	php7 \
	php7-phar \
	php7-json \
	php7-iconv \
	php7-openssl \
	tzdata \
	openntpd

RUN apk update && \
  apk add \
	php7-xdebug \
	php7-mbstring \
	php7-dom \
	php7-pdo \
	php7-zip \
	php7-gd \
	php7-pdo_mysql \
	php7-curl \
	php7-ctype \
	php7-session \
	php7-simplexml \
	php7-xsl \
	php7-fileinfo

RUN cp /usr/bin/php7 /usr/bin/php && rm -f /var/cache/apk/*

RUN mkdir /run/apache2 \
    && sed -i "s/#LoadModule\ rewrite_module/LoadModule\ rewrite_module/" /etc/apache2/httpd.conf \
    && sed -i "s/#LoadModule\ session_module/LoadModule\ session_module/" /etc/apache2/httpd.conf \
    && sed -i "s/#LoadModule\ session_cookie_module/LoadModule\ session_cookie_module/" /etc/apache2/httpd.conf \
    && sed -i "s/#LoadModule\ session_crypto_module/LoadModule\ session_crypto_module/" /etc/apache2/httpd.conf \
    && sed -i "s/#LoadModule\ deflate_module/LoadModule\ deflate_module/" /etc/apache2/httpd.conf \
    && sed -i "s/#ServerName\ www.example.com:80/ServerName\ localhost:80/" /etc/apache2/httpd.conf \
    && sed -i "s#^DocumentRoot \".*#DocumentRoot \"/opt/app/web\"#g" /etc/apache2/httpd.conf \
    && sed -i "s#/var/www/localhost/htdocs#/opt/app/web#" /etc/apache2/httpd.conf \
    && printf "\n<Directory \"/opt/app/web\">\n\tAllowOverride All\n\tOptions -Indexes\n\tRequire all granted\n</Directory>\n" >> /etc/apache2/httpd.conf \
    && printf "\n<FilesMatch \.php$>\n\tSetHandler application/x-httpd-php\n</FilesMatch>\n" >> /etc/apache2/httpd.conf \
    && sed -i "s/variables_order\ =\ \"GPCS\"/variables_order\ =\ \"EGPCS\"/" /etc/php7/php.ini \
    && sed -i "s/;realpath_cache_size\ =\ 4096k/realpath_cache_size=4096K/" /etc/php7/php.ini \
    && sed -i "s/;realpath_cache_ttl\ =\ 120/realpath_cache_ttl=600/" /etc/php7/php.ini \
    #&& sed -i "s/;opcache.validate_timestamps=1/opcache.validate_timestamps=0/" /etc/php7/php.ini \
    && sed -i "s/;opcache.memory_consumption=128/opcache.memory_consumption=256/" /etc/php7/php.ini \
    && sed -i "s/;opcache.max_accelerated_files=10000/opcache.max_accelerated_files=20000/" /etc/php7/php.ini \
    && sed -i "s/;date.timezone\ =/date.timezone\ =\ \"Europe\/Paris\"/" /etc/php7/php.ini \
    && sed -i "s/;intl.default_locale\ =/intl.default_locale\ =\ \"fr_FR.UTF-8\"/" /etc/php7/php.ini \
    && ln -sfT /dev/stderr /var/log/apache2/error.log \
    && ln -sfT /dev/stdout /var/log/apache2/access.log

COPY build/entrypoint.sh /
RUN chmod +x /entrypoint.sh

ENTRYPOINT ["/entrypoint.sh"]
CMD ["httpd", "-D", "FOREGROUND"]
EXPOSE 80

VOLUME /opt/app/web/uploads

ENV SYMFONY_LOG_DIR=/var/log/symfony \
  SYMFONY_CACHE_DIR=/var/cache/symfony \
  SYMFONY_ENVIRONMENT=prod \
  SYMFONY_DEBUG=false

WORKDIR /opt/app
COPY --from=composer /opt/app/vendor vendor
COPY . .