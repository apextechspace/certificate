<?php

return [
    'canvas' => [
        'width' => 4636,
        'height' => 6000,
        'image_path' => public_path('images/certificate-templates/umeraboost-5.0.png'),
    ],

    'fields' => [
        'name' => [
            'x' => 2318, // Center of canvas
            'y' => 2520, // Under "This is to certify that"
            'max_width' => 3600,
            'font_size' => 150,
            'min_font_size' => 80,
            'font_path' => resource_path('fonts/Georgia-Bold.ttf'),
            'alignment' => 'center',
            'color' => '#171717',
            'max_lines' => 1,
        ],

        'course' => [
            'x' => 2318, // Center of canvas
            'y' => 3280, // Under "fundamentals of"
            'max_width' => 3200,
            'font_size' => 90,
            'min_font_size' => 60,
            'font_path' => resource_path('fonts/Georgia.ttf'),
            'alignment' => 'center',
            'color' => '#171717',
            'max_lines' => 2,
            'line_height' => 110,
        ],

        'date' => [
            'x' => 3320, // Above "DATE" label on the right
            'y' => 4180,
            'max_width' => 1000,
            'font_size' => 75,
            'font_path' => resource_path('fonts/Georgia.ttf'),
            'alignment' => 'center',
            'color' => '#171717',
            'max_lines' => 1,
        ],

        'certificate_id' => [
            'x' => 350, // Bottom-left footer area
            'y' => 5580,
            'max_width' => 1500,
            'font_size' => 50,
            'font_path' => resource_path('fonts/Inter-Regular.ttf'),
            'alignment' => 'left',
            'color' => '#525252',
        ],

        'qr_code' => [
            'enabled' => false, // Keep disabled per user request
            'x' => 3700, // Bottom-right footer area
            'y' => 5200,
            'size' => 350,
        ],
    ],
];
