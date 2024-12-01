<?php
include '__autoload.php';

use Core\Core;
array_shift($argv);
$core = new Core(...$argv);

