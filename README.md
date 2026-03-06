you have to install for convert to pdf and excel

composer require barryvdh/laravel-dompdf
composer require maatwebsite/excel

then 

php artisan vendor:publish --provider="Barryvdh\DomPDF\ServiceProvider"
php artisan vendor:publish --provider="Maatwebsite\Excel\ExcelServiceProvider"
