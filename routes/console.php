<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('horizon:snapshot')->everyFiveMinutes();

Schedule::command('backup:clean')->daily()->at('4:00');
Schedule::command('backup:run')->daily()->at('04:30')
    ->onFailure(function () {
        //
    })
    ->onSuccess(function () {
        //
    });

// clean livewire-tmp folder

// clean empty image folders
