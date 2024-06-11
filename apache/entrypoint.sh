#!/usr/bin/env bash
service ssh start
chmod -R 777 /var/www
apachectl -D FOREGROUND