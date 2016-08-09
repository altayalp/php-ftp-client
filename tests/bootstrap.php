<?php

$vendorDir = 'vendor';

if (! file_exists($vendorDir . '/autoload.php')) {
    die("You must set up the project with conposer");
}

require($vendorDir . '/autoload.php');