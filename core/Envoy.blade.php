@servers(['web' => 'dev@137.184.139.206'])

@setup
$sudoPassword = 'ddc010';
$path = '/usr/share/nginx/html';
$hostDatabase = '10.116.80.3';
$nameDatabase = 'site';
$userDatabase = 'site';
$passDatabase = 'BLSLtXzPWW@M';
$clonePath = 'git@github.com:Denisbeder/revistadagente.git';
$baseUrl = 'https://revistadagente.com.br';
$appName = 'Revista DaGente';
$mailDriver = 'smtp';
$mailHost = 'smtp.revistadagente.com.br';
$mailPort = '587';
$mailUserName = 'comercial@revistadagente.com.br';
$mailPassword = '';
$mailEncryption = 'TLS';
$mailFromAddress = 'comercial@revistadagente.com.br';
$mailFromName = $appName;
@endsetup

@story('deploy')
create_swap
clear
git
env
composer
permissions
key
cache
config
route
restart
remove_swap
@endstory

@story('update')
clear
git
permissions_basic
cache
config
route
restart
@endstory

@task('clear')
cd {{ $path }}

@if ($clone)
echo {{ $sudoPassword }} | sudo -S rm -Rf ./*
echo {{ $sudoPassword }} | sudo -S rm -Rf .git/
@endif
@endtask

@task('beforegit')
mv -f {{ $path }}/public/ads.txt {{ $path }}/ads.txt 2>/dev/null; true
@endtask

@task('aftergit')
mv -f {{ $path }}/ads.txt {{ $path }}/public/ads.txt 2>/dev/null; true
@endtask

@task('git')
@if ($clone)
cd {{ $path }}
git clone {{ $clonePath }} .
@else
cd {{ $path }}
git reset --hard origin/main
git pull origin main
@endif
@endtask

@task('composer')
cd {{ $path . '/core' }}

composer install --optimize-autoloader --no-dev
@endtask

@task('key')
cd {{ $path . '/core' }}

@if ($clone)
php artisan key:generate
@endif
@endtask

@task('migrate')
cd {{ $path . '/core' }}

@if ($clone)
php artisan migrate
@endif
@endtask

@task('cache')
cd {{ $path . '/core' }}

php artisan page-cache:clear
php artisan cache:clear
echo {{ $sudoPassword }} | sudo -S php artisan nginx:purge
@endtask

@task('config')
cd {{ $path . '/core' }}

php artisan config:cache
@endtask

@task('route')
cd {{ $path . '/core' }}

php artisan route:cache
@endtask

@task('permissions_basic')
echo {{ $sudoPassword }} | sudo -S chown -R www-data.www-data {{ $path }}
echo {{ $sudoPassword }} | sudo -S chmod -R 775 {{ $path }}
echo {{ $sudoPassword }} | sudo -S chgrp -R www-data {{ $path }}/core/storage {{ $path }}/core/bootstrap/cache
echo {{ $sudoPassword }} | sudo -S chmod -R ug+rwx {{ $path }}/core/storage {{ $path }}/core/bootstrap/cache
@endtask

@task('permissions')
echo {{ $sudoPassword }} | sudo -S chown -R www-data.www-data {{ $path }}
echo {{ $sudoPassword }} | sudo -S chmod -R 775 {{ $path }}
echo {{ $sudoPassword }} | sudo -S find {{ $path }} -type f -exec chmod 664 {} \;
echo {{ $sudoPassword }} | sudo -S find {{ $path }} -type d -exec chmod 775 {} \;
echo {{ $sudoPassword }} | sudo -S chgrp -R www-data {{ $path }}/core/storage {{ $path }}/core/bootstrap/cache
echo {{ $sudoPassword }} | sudo -S chmod -R ug+rwx {{ $path }}/core/storage {{ $path }}/core/bootstrap/cache
@endtask

@task('restart')
echo {{ $sudoPassword }} | sudo -S /etc/init.d/php7.4-fpm restart
@endtask

@task('env')
cd {{ $path . '/core' }}

@if ($clone)
(echo "APP_NAME=\"{{ $appName }}\"" & echo "APP_ENV=production" & echo "APP_KEY=" & echo "APP_DEBUG=true" & echo "APP_LOG_LEVEL=debug" & echo "APP_URL={{ $baseUrl }}" & echo & echo "DEBUGBAR_ENABLED=false" & echo & echo "DB_CONNECTION=mysql" & echo "DB_HOST={{ $hostDatabase }}" & echo "DB_PORT=3306" & echo "DB_DATABASE={{ $nameDatabase }}" & echo "DB_USERNAME={{ $userDatabase }}" & echo "DB_PASSWORD=\"{{ $passDatabase }}\"" & echo & echo "BROADCAST_DRIVER=log" & echo "CACHE_DRIVER=redis" & echo "SESSION_DRIVER=redis" & echo "QUEUE_DRIVER=sync" & echo REDIS_CLIENT=predis & echo & echo "REDIS_HOST=127.0.0.1" & echo "REDIS_PASSWORD=null" & echo "REDIS_PORT=6379" & echo & echo "MAIL_DRIVER={{ $mailDriver }}" & echo "MAIL_HOST={{ $mailHost }}" & echo "MAIL_PORT={{ $mailPort }}" & echo "MAIL_ENCRYPTION={{ $mailEncryption }}" & echo "MAIL_USERNAME={{ $mailUserName }}" & echo "MAIL_PASSWORD={{ $mailPassword }}" & echo & echo "MAIL_FROM_ADDRESS={{ $mailFromAddress }}" & echo "MAIL_FROM_NAME=\"{{ $mailFromName }}\"" & echo & echo "PUSHER_APP_ID=" & echo "PUSHER_APP_KEY=" & echo "PUSHER_APP_SECRET=" & echo SCOUT_DRIVER=tntsearch & echo SCOUT_QUEUE=true) > .env
@endif
@endtask

@task('create_swap')
echo
@if ($swap)
sudo /bin/dd if=/dev/zero of=/var/swap.1 bs=1M count=2048
sudo /sbin/mkswap /var/swap.1
sudo /sbin/swapon /var/swap.1
php -d memory_limit=-1 /usr/bin/composer update --optimize-autoloader --no-dev
@endif
@endtask

@task('remove_swap')
echo
@if ($swap)
sudo swapoff -v /var/swap.1
sudo rm -f /var/swap.1
@endif
@endtask