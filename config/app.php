<?php

use Framework\Database\ServiceProvider as DatabaseProvider;
use Framework\View\ServiceProvider as ViewProvider;

return [
    'providers' => [
        DatabaseProvider::class,
        ViewProvider::class
    ]
];