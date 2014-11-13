#!/bin/bash
# inject the environmental variables into php using the fastcgi_params provided by nginx

if [ $KEY_NAME ]; then
    echo "setting KEY_NAME to $KEY_NAME"
    echo "fastcgi_param KEY_NAME $KEY_NAME;" >> /etc/nginx/fastcgi_params
fi

service php5-fpm start && nginx
