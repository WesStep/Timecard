FROM ubuntu:18.04

MAINTAINER Wes Stephenson

# Getting ready to install PHP and NGINX
RUN apt-get update \
    && apt-get install -y locales tzdata \
    && locale-gen en_US.UTF-8

# Set environment variables
ENV LANG en_US.UTF-8
ENV LANGUAGE en_US:en
ENV LC_ALL en_US.UTF-8

# Install PHP and NGINX
RUN apt-get update \
	&& apt-get install -y nginx curl zip unzip git software-properties-common supervisor sqlite3 \
	&& add-apt-repository -y ppa:ondrej/php \
	&& apt-get update \
	&& apt-get install -y php7.2-fpm php7.2-cli php7.2-gd php7.2-mysql \
	   php7.2-pgsql php7.2-imap php-memcached php7.2-mbstring php7.2-xml php7.2-curl \
	   php7.2-sqlite3 php7.2-xdebug \
	&& php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer \
	&& mkdir /run/php \
	&& apt-get remove -y --purge software-properties-common \
	&& apt-get -y autoremove \
	&& apt-get clean \
	&& rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* \
	&& echo "daemon off;" >> /etc/nginx/nginx.conf

# Expose HTTP and HTTPS ports
EXPOSE 80
EXPOSE 443

# Set up error and access log reporting for Laravel
RUN ln -sf /dev/stdout /var/log/nginx/access.log \
	&& ln -sf /dev/stderr /var/log/nginx/error.log

# Copy over the necessary config files
COPY default /etc/nginx/sites-available/default
COPY php-fpm.conf /etc/php/7.2/fpm/php-fpm.conf
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Set the working directory
WORKDIR /var/www/html

# Start up the supervisor
CMD ["/usr/bin/supervisord"]