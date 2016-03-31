<?php

// bootstrap/testing.php
$testEnv = (getenv('APP_ENV')) ? : 'testing';

passthru("php " . __DIR__ . "/../artisan db:seed-test --env={$testEnv}");

require __DIR__ . '/autoload.php';
