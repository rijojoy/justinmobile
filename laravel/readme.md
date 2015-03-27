# Recycle

## Install

- unzip .zip
- chmod -R 0777 app/storage
- make database
- do configs
- php artisan key:generate
- php artisan migrate
- php artisan migrate --package="cartalyst/sentry"
- php artisan db:seed --class=GroupTableSeeder
- php artisan db:seed --class=UserTableSeeder
- chmod -R 0777 public/assets/images
- create first status