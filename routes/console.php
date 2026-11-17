<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Sinkronisasi otomatis data Google Scholar setiap hari pukul 02:00 pagi
Schedule::command('scholar:sync')->dailyAt('02:00');
