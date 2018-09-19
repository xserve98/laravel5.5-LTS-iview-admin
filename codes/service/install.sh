#!/usr/bin/env bash
composer install
chmod -R 777 storage
chmod -R 777 bootstrap/cache
# 判断.env是否存在，若不存在则执行操作
if [ ! -f "./.env" ];then
    cp .env.example .env
    php artisan key:generate
fi
