<?php

include_once 'Route.php';

Route::get('/users', function() {
    return 'List users!';
});

Route::get('/users/*', function() {
    return 'Show user id = *';
});

Route::run();