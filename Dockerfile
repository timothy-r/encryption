FROM ubuntu:latest
MAINTAINER Tim Rodger

# Expose the port
EXPOSE 80

# Start the server
CMD ./build/run.sh

# Install dependencies
RUN apt-get update -qq
RUN apt-get -y install wget curl nginx php5-common php5-cli php5-fpm php-apc php5-mcrypt

# Make the directories
RUN mkdir /home/app /home/app/build /home/app/web /home/app/config

# Setup nginx
ADD build/default /etc/nginx/sites-available/default
RUN echo "cgi.fix_pathinfo = 0;" >> /etc/php5/fpm/php.ini && \
    echo "daemon off;" >> /etc/nginx/nginx.conf

# Install composer
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

# Move files into place
ADD web/ /home/app/web
ADD composer.json /home/app/
ADD composer.lock /home/app/
ADD build/ /home/app/build

# Install dependencies
WORKDIR /home/app
RUN composer install --prefer-dist

# generate key files
RUN openssl genrsa  -out config/mykey.pem 2048
RUN openssl rsa -pubout -in config/mykey.pem -out config/mykey.pub 
