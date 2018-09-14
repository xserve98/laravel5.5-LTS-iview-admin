#### 常用命令集合
* php artisan down  开启维护模式，关闭站点
* php artisan up    关闭维护模式，开启站点
* php artisan key:generate  生成密钥


#### 常用包解释
* composer require barryvdh/laravel-cors    Laravel应用程序中添加CORS（跨源资源共享）标头支持
* composer require laravelcollective/html   Laravel框架的HTML和表单构建器
* composer require predis/predis            适用于PHP和HHVM的灵活且功能齐全的Redis客户端
* composer require prettus/laravel-validation   Laravel验证服务
* composer require simplesoftwareio/simple-qrcode   Simple QrCode是为Laravel制作的QR码生成器。
* composer require zedisdog/laravel-schema-extend   数据迁移扩展包　可生成表注释
* composer require --dev barryvdh/laravel-ide-helper    Laravel IDE Helper为所有Facade类生成正确的PHPDoc，以改进自动完成。

#### 优化
* php artisan route:cache   缓存路由
* php artisan config:cache  缓存配置文件
* php artisan optimize      Laravel优化命令
* composer dump-autoload --optimize 优化composer

#### 优化脚本
#!/usr/bin/env bash
php artisan clear-compiled
php artisan cache:clear
php artisan route:cache
php artisan config:cache
php artisan optimize --force
composer dump-autoload --optimize