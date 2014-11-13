#!/bin/bash
# inject the environmental variables into php using the fastcgi_params provided by nginx

for v in `env | egrep VAR_`
do
    echo $v | awk -F = '{print "fastcgi_param",$1,$2";"}' >> /etc/nginx/fastcgi_params
done

service php5-fpm start && nginx
