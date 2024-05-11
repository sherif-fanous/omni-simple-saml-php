<?php

$metadata[getenv('OMNI_FQDN') . '/idp'] = [
    'auth' => 'username-password',
    'certificate' => getenv('TLS_CERT_FILE'),
    'host' => '__DEFAULT__',
    'privatekey' => getenv('TLS_KEY_FILE'),
];

