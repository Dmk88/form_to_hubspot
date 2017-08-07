# form_to_hubspot
Form`s data from csv format google docs uploads to hubspot form

# INSTALL

 composer install

Run php artisan vendor:publish --provider="PulkitJalan\Google\GoogleServiceProvider" --tag="config" to publish the google config file

php artisan vendor:publish --provider="Barryvdh\Debugbar\ServiceProvider"

Automatic phpDoc generation for Laravel Facades: 
php artisan ide-helper:generate

php artisan migrate
