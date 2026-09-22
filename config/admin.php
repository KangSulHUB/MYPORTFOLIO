<?php

return [
    'default_name' => trim((string) env('ADMIN_NAME', 'Admin Portfolio')),
    'default_email' => trim((string) env('ADMIN_EMAIL', 'admin@portfolio.com')),
    'default_password' => trim((string) env('ADMIN_PASSWORD', 'password123')),
];
