<?php

return [
    'services'  => [
        'Client' => function () {
            if (class_exists('\App\Aws\ElasticTranscoder\Client')) {
                return new \App\Aws\ElasticTranscoder\Client();
            } else {
                return new \Nails\Aws\ElasticTranscoder\Client();
            }
        },
    ],
    'factories' => [
        'Job'      => function () {
            if (class_exists('\App\Aws\ElasticTranscoder\Job')) {
                return new \App\Aws\ElasticTranscoder\Job();
            } else {
                return new \Nails\Aws\ElasticTranscoder\Job();
            }
        },
        'Pipeline' => function () {
            if (class_exists('\App\Aws\ElasticTranscoder\Pipeline')) {
                return new \App\Aws\ElasticTranscoder\Pipeline();
            } else {
                return new \Nails\Aws\ElasticTranscoder\Pipeline();
            }
        },
        'Preset'   => function () {
            if (class_exists('\App\Aws\ElasticTranscoder\Preset')) {
                return new \App\Aws\ElasticTranscoder\Preset();
            } else {
                return new \Nails\Aws\ElasticTranscoder\Preset();
            }
        },
    ],
];
