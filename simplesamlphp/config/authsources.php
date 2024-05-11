<?php

$config = [
    'admin' => [
        'core:AdminPassword',
    ],
    'username-password' => [
        'exampleauth:UserPass',
        getenv('OMNI_USER_USERNAME') . ':' . getenv('OMNI_USER_PASSWORD') => [
            'uid' => [getenv('OMNI_USER_USERNAME')],
            'email' => getenv('OMNI_USER_EMAIL'),
        ],
    ],
];
