<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Schedule::command('receipt:monitor')->dailyAt('08:00');
Schedule::command('shipping:monitor')->dailyAt('08:00');
Schedule::command('cart:monitor')->dailyAt('08:00');
Schedule::command('cart:monitor')->dailyAt('14:00');
Schedule::command('cart:monitor')->dailyAt('18:00');

