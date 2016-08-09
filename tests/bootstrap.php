<?php

$vendorDir = __DIR__ . '/../vendor';

if (! @include($vendorDir . '/autoload.php')) {
    die("You must set up the project with conposer");
}

$loader = require $vendorDir . '/autoload.php';