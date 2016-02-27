#!/bin/bash

chown -R bob:www-data ./*
find . -type d -exec chmod 755 {} \;
find . -type f -exec chmod 644 {} \;
chown -R www-data:www-data ./wp-content/uploads
