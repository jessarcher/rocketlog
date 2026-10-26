<?php

return [

    'disks' => [
        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
            'throw' => false,
        ],

        'backup' => [
            'driver' => 'local',
            'root' => storage_path('backup'),
        ],
    ],

];
