<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Artisan::command('optimizeApp', function () {
    $this->comment('Optimizing application...');
    // $this->call('optimize:clear');
    // $this->call('config:cache');
    // $this->call('route:cache');
    // $this->call('view:cache');
    $this->call('icons:cache');
    $this->comment('Application optimized successfully');
})->purpose('Optimize the application');



// setup the App from scratch
Artisan::command('setupApp', function () {
    $this->comment('Setting up the application...');
    $this->call('key:generate');
    $this->call('migrate:fresh');
    $this->call('db:seed');
    $this->call('optimizeApp');
    $this->comment('Application setup successfully');
    $this->comment('You can now run the application by running "php artisan serve" on http://localhost:8000/');
    $this->comment('You can login with the following credentials: admin@gmail.com / password: 12345678');
})->purpose('Setup the application');